<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;

class AdminCartController extends Controller
{
    /**
     * 顯示所有的購物車
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 讓購物車多一個商品物品陣列存放購物車與商品物品關聯的資料
        $carts = CartItem::paginate(10);
        foreach ($carts as $cart) {
            $cart['sku'] = $cart->sku;
        }
        $cartsData = $carts->toArray();

        //['data']是cartsData這個collection裡真正存放資料的index
        return view('adminCart')->with(['carts' => $cartsData['data'], 'link' => $carts]);
    }

    /**
     * Remove the cart's information.
     *
     * @param  int  $cart_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cartId)
    {
        if (! $cart = CartItem::find($cartId)) {
            abort(404);
        }
        
        $status = $cart->delete();

        return redirect()->action('AdminCartController@index');
    }
}
