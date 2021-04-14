<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display the users order
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $orders = Order:: where('users_id', '=', $id)->paginate(8);
        return view('order')->with(['orders' => $orders]);
    }

    /**
     * Create a new order,get total from user->sku pivot cart
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $id = Auth::id();
        $cart = User::find($id)->sku()->get()->toArray();
        
        $total = 0;
        foreach ($cart as $carts) {
            $total += ($carts['pivot']['amount'] * $carts['price']);
        }

        if ($total == 0) {
            return redirect()->action('CartController@index');
        }

        return view('createOrder')->with(['total_price' => $total]);
    }

    /**
     * Store a newly created order
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::id();
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'address' => 'required|string|max:50',
            'phone' => ['required','regex:/^09[0-9]{8}$/',],
            'total_amount' => 'required|numeric',
            'payment' => 'required|in:cash,credit-card',
        ]);

        $validatedData['users_id'] = $id;
        $validatedData['status'] = '出貨';

        $status = Order::create($validatedData);

        $orderId = $status->toArray()['id'];

        return redirect()->action('OrderItemController@store', ['id' => $orderId]);
    }
}
