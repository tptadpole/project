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
     * Display the user's cart
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users_id = Auth::id();

        $carts = User::find($users_id)->sku()->get()->toArray();
        
        $total = 0;
        foreach ($carts as $cart) {
            $total += ($cart['pivot']['amount'] * $cart['price']);
        }

        return view('cart')->with([ 'carts' => $carts, 'total' => $total ]);
    }

    /**
     * Store a newly created 商品物品 in cart
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $sku_id)
    {
        $users_id = Auth::id();
        $sku = Sku:: where('id', '=', $sku_id)->get()->toArray();

        $validatedData = $request->validate([
            'amount' => 'required|numeric',
        ]);

        if ($cart = CartItem:: where([['users_id', '=', $users_id],['sku_id', '=', $sku_id]])->first()) {
            if (($cart->amount + $request->amount) <= $sku[0]['stock']) {
                $cart->update([
                    'amount' => $cart->amount + $request->amount,
                ]);
            }
        } else {
            $validatedData['users_id'] = $users_id;
            $validatedData['sku_id'] = $sku_id;
            $show = CartItem::create($validatedData);
        }

        return redirect()->action('CustomerController@show', ['id' => $sku[0]['spu_id']]);
    }

    /**
     * edit the 商品物品的數量 in cart.
     *
     * @param int $cart_id
     * @return \Illuminate\Http\Response
     */
    public function edit($cart_id)
    {
        if (! $cart = CartItem::find($cart_id)) {
            abort(404);
        }
        $cart = $cart->toArray();

        if (!$sku = Sku::find($cart['sku_id'])) {
            abort(404);
        }
        $sku = $sku->toArray();

        return view('editCart')->with([ 'cart' => $cart, 'sku' => $sku ]);
    }

    /**
     * Update the 商品物品的數量 in cart.
     *
     * @param Request $request
     * @param int $cart_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cart_id)
    {

        if (! $cart = CartItem::find($cart_id)) {
            abort(404);
        }
        $this->authorize('update', CartItem::find($cart_id));

        $validatedData = $request->validate([
            'amount' => 'required|numeric',
        ]);

        $status = $cart->update($validatedData);

        return redirect()->action('CartController@index');
    }

    /**
     * Remove the buying of commodity from cart.
     *
     * @param  int  $cart_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cart_id)
    {
        if (! $cart = CartItem::find($cart_id)) {
            abort(404);
        }

        $status = $cart->delete();
        return redirect()->action('CartController@index');
    }
}
