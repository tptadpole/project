<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;

class AdminCartController extends Controller
{
    /**
     * Display all cart's and it's information
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = CartItem::paginate(10);
        
        foreach ($carts as $cart) {
            $cart['sku'] = $cart->sku;
        }

        $data = $carts->toArray();
        
        return view('adminCart')->with(['carts' => $data['data'], 'link' => $carts]);
    }

    /**
     * Remove the cart's information.
     *
     * @param  int  $cart_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cart_id)
    {
        if (! $cart = CartItem::find($cart_id)) {
            throw new APIException('購物車內商品找不到', 404);
        }

        $status = $cart->delete();

        return redirect()->action('AdminCartController@index');
    }
}
