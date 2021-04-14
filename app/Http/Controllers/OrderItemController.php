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
     * Display the sellers shipment order
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $orders = OrderItem:: where([['users_id', '=', $id], ['status', '=', '出貨']])->paginate(8);
        $role = 'seller';
        return view('sellerOrder')->with(['orders' => $orders, 'role' => $role]);
    }

    /**
     * Display the customer's orderItem
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
     * Store a new orderItem from order
     *
     * @param int $order_id
     * @return \Illuminate\Http\Response
     */
    public function store($order_id)
    {
        $id = Auth::id();
        $carts = User::find($id)->sku()->get()->toArray();
        foreach ($carts as $cart) {
            $data['users_id'] = $cart['users_id'];
            $data['order_id'] = $order_id;
            $data['sku_id'] = $cart['id'];
            $data['amount'] = $cart['pivot']['amount'];
            $data['price'] = $cart['price'];
            $data['status'] = '出貨';
            $status = OrderItem::create($data);
        }

        $cart_id = $carts[0]['pivot']['id'];

        $status = CartItem::where('users_id', '=', $id)->delete();

        return view('ordersuccess');
    }

    /**
     * Update the status of orderItem.
     *
     * @param Request $request
     * @param int $order_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $order_id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:運送中,取消,取貨,完成'
        ]);

        if (! $orderItem = OrderItem::find($order_id)) {
            throw new APIException('課程找不到', 404);
        }

        $status = $orderItem->update($validatedData);

        if ($validatedData['status'] == '運送中' || $validatedData['status'] == '取消') {
            $sku = Sku::find($orderItem->toArray()['sku_id']);
            $stock = $sku->toArray() ['stock'];

            $commodity = $sku->toArray();
            $amount = $orderItem->toArray() ['amount'];
            $unitPrice = $commodity['price'];

            // 出貨失敗就減少顧客花費的總金額,出貨成功就減少賣家商品的存貨
            if ($stock < $amount || $validatedData['status'] == '取消') {
                $validatedData['status'] = "取消";
                $order = Order::find($orderItem->toArray() ['order_id']);
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
