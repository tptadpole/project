<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sku;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Order;
use App\User;

class OrderItemController extends Controller
{
    /**
     * Display 賣家該出貨的訂單
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users_id = Auth::id();
        $orders = OrderItem:: where([['users_id', '=', $users_id], ['status', '=', '出貨']])->paginate(8);
        $role = 'seller';
        return view('sellerOrder')->with(['orders' => $orders, 'role' => $role]);
    }

    /**
     * Display 買家的訂單裡的商品物品
     *
     * @param int $order_id
     * @return \Illuminate\Http\Response
     */
    public function show($order_id)
    {
        $orders = OrderItem:: where('order_id', '=', $order_id)->paginate(8);
        $role = 'customer';
        return view('sellerOrder')->with(['orders' => $orders, 'role' => $role]);
    }

    /**
     * 將訂單內的物品存入訂單商品物品的storage
     *
     * @param int $order_id
     * @return \Illuminate\Http\Response
     */
    public function store($order_id)
    {

        $users_id = Auth::id();
        $carts = User::find($users_id)->sku()->get()->toArray();

        if (empty($carts)) {
            abort(404);
        }

        // 在將購物車內商品物品資訊存入訂單物品後,將購物車內商品刪除
        foreach ($carts as $cart) {
            $data['users_id'] = $cart['users_id'];
            $data['order_id'] = $order_id;
            $data['sku_id'] = $cart['id'];
            $data['amount'] = $cart['pivot']['amount'];
            $data['price'] = $cart['price'];
            $data['status'] = '出貨';
            $status = OrderItem::create($data);
        }
        $status = CartItem::where('users_id', '=', $users_id)->delete();

        return view('ordersuccess');
    }

    /**
     * (買家與賣家)Update the status of orderItem.
     *
     * @param Request $request
     * @param int $order_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $order_id)
    {

        if (! $orderItem = OrderItem::find($order_id)) {
            abort(404);
        }
        
        $validatedData = $request->validate([
            'status' => 'required|in:運送中,取消,取貨,完成'
        ]);
        $status = $orderItem->update($validatedData);
        $orderItem = $orderItem->toArray();

        if ($validatedData['status'] == '運送中' || $validatedData['status'] == '取消') {
            $sku = Sku::find($orderItem['sku_id']);

            $commodity = $sku->toArray();
            $stock = $commodity['stock'];
            $unitPrice = $commodity['price'];

            $amount = $orderItem['amount'];
            
            // 出貨失敗就減少顧客花費的總金額,出貨成功就減少賣家商品的存貨
            if ($stock < $amount || $validatedData['status'] == '取消') {
                $validatedData['status'] = "取消";
        
                $order = Order::find($orderItem['order_id']);
                $totalAmount = $order->toArray() ['total_amount'];
                $updatedTotalAmount = [ 'total_amount' => $totalAmount - ($amount * $unitPrice) ];
                $order->update($updatedTotalAmount);
            } else {
                $stock = [ 'stock' => $stock - $amount];
                $sku->update($stock);
            }
        }

        return redirect()->action('OrderItemController@index');
    }
}
