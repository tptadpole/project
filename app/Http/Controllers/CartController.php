<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Sku;
use App\Models\CartItem;
use App\User;

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
     * Store a newly created commodity in cart
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
            if (($cart->amount + $request->amount) <= $sku[0]['stock']) {
                $cart->update([
                    'amount' => $cart->amount + $request->amount,
                ]);
            }
        } else {
            $validatedData['users_id'] = $id;
            $validatedData['sku_id'] = $sku_id;
            $show = CartItem::create($validatedData);
        }

        return redirect()->action('CustomerController@show', ['id' => $sku[0]['spu_id']]);
    }

    /**
     * edit the buy amount of specified commodity in cart.
     *
     * @param int $cart_id
     * @return \Illuminate\Http\Response
     */
    public function edit($cart_id)
    {
        $cart = CartItem::find($cart_id)->toArray();
        $sku = Sku::find($cart['sku_id'])->toArray();

        return view('editCart')->with([ 'cart' => $cart, 'sku' => $sku ]);
    }

    /**
     * Update the buy amount of specified commodity in cart.
     *
     * @param Request $request
     * @param int $cart_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cart_id)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
        ]);

        if (! $cart = CartItem::find($cart_id)) {
            throw new APIException('商品細項找不到', 404);
        }

        $status = $cart->update($validatedData);

        return redirect()->action('CartController@index');
    }

    /**
     * Remove the buying of commodity from cart.
     *
     * @param  int  $cart_Id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cart_id)
    {
        if (! $cart = CartItem::find($cart_id)) {
            throw new APIException('購物車內商品找不到', 404);
        }

        $status = $cart->delete();
        return redirect()->action('CartController@index');
    }
}
