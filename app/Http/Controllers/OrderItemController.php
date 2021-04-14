<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sku;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\User;

class OrderItemController extends Controller
{
    /**
     * Store a new orderItem for order from cart
     *
     * @param int $order_id
     * @return \Illuminate\Http\Response
     */
    public function store($order_id)
    {
        $id = Auth::id();
        $carts = User::find($id)->sku()->get()->toArray();
        foreach ($carts as $cart) {
            $data['order_id'] = $order_id;
            $data['sku_id'] = $cart['id'];
            $data['amount'] = $cart['pivot']['amount'];
            $data['price'] = $cart['price'];
            $status = OrderItem::create($data);
            $status = $status->toArray();
            dd($cart);
        }

        $users_id = $carts[0]['pivot']['users_id'];
        dd($users_id);

        return redirect()->action('CartController@destroy', ['id' => $users_id]);
    }
}
