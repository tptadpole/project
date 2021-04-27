<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display the user's order
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users_id = Auth::id();
        $orders = Order:: where('users_id', '=', $users_id)->paginate(8);
        return view('order')->with(['orders' => $orders]);
    }

    /**
     * Create a new order,並取得user消費的總金額
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $users_id = Auth::id();
        $cart = User::find($users_id)->sku()->get()->toArray();
        
        $totalPrice = 0;
        foreach ($cart as $carts) {
            $totalPrice += ($carts['pivot']['amount'] * $carts['price']);
        }

        if ($totalPrice == 0) {
            return redirect()->action('CartController@index');
        }

        return view('createOrder')->with(['totalPrice' => $totalPrice]);
    }

    /**
     * Store a newly created order
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users_id = Auth::id();
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'address' => 'required|string|max:50',
            'phone' => ['required','string','regex:/^09[0-9]{8}$/',],
            'total_amount' => 'required|numeric',
            'payment' => 'required|in:cash,credit-card',
        ]);

        $validatedData['users_id'] = $users_id;
        $validatedData['status'] = '出貨';

        $status = Order::create($validatedData);

        $orderId = $status->toArray()['id'];

        // 在儲存買家的訂單的時候同時更新賣家的未出貨訂單
        return redirect()->action('OrderItemController@store', ['id' => $orderId]);
    }

    /**
     * Remove the order(使用軟刪除).
     *
     * @param  int  $order_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($order_id)
    {
        if (! $order = Order::find($order_id)) {
            abort(404);
        }
        
        $this->authorize('delete', $order);
        $orderItems = $order->orderItems->toArray();

        $canDelete = true;
        foreach ($orderItems as $orderItem) {
            if ($orderItem['status'] != '取消' && $orderItem['status'] != '完成') {
                $canDelete = false;
            }
        }

        if ($canDelete) {
            $status = $order->delete();
        }

        return redirect()->action('OrderController@index');
    }
}
