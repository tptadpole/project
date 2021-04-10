<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Sku;
use App\Models\CartItem;
use App\User;
use DB;

class CartController extends Controller
{
    /**
     * Display the users cart
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $cart = User::find($id)->sku()->get()->toArray();
        
        $total = 0;
        foreach ($cart as $carts) {
            $total += ($carts['pivot']['amount'] * $carts['price']);
        }

        return view('cart')->with([ 'cart' => $cart, 'total' => $total ]);
    }

    /**
     * Store a newly created commodity in storage
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $sku_id)
    {
        $id = Auth::id();
        $sku = Sku:: where('id', '=', $sku_id)->get()->toArray();

        $validatedData = $request->validate([
            'amount' => 'required|numeric',
        ]);

        if ($cart = CartItem:: where([['users_id', '=', $id],['sku_id', '=', $sku_id]])->first()) {
            $cart->update([
                'amount' => $cart->amount + $request->amount,
            ]);
        } else {
            $validatedData['users_id'] = $id;
            $validatedData['sku_id'] = $sku_id;
            $show = CartItem::create($validatedData);
        }

        return redirect()->action('CustomerController@show', ['id' => $sku[0]['spu_id']]);
    }
}
