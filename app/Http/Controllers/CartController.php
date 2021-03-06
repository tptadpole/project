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
     * Display the user's 購物車
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
     * 將商品物品放入購物車
     *
     * @param Request $request
     * @param int $sku_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $sku_id)
    {
        $users_id = Auth::id();
        if (!$sku = Sku::find($sku_id)) {
            abort(404);
        }
        if ($users_id == $sku->users_id) {
            abort(403);
        }
        $sku = $sku->toArray();

        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        // 如果購物車內有相同的商品了,更新數量即可,否則將商品加入到購物車中
        if ($cart = CartItem:: where([['users_id', '=', $users_id],['sku_id', '=', $sku_id]])->first()) {
            $total_amount = $cart->amount + $request->amount;
            // 每個商品最多買100份,追加買商品也是
            if ($total_amount <= $sku['stock']) {
                $cart->update([
                    'amount' => $total_amount,
                ]);
            }
        } else {
            $validatedData['users_id'] = $users_id;
            $validatedData['sku_id'] = $sku_id;
            $show = CartItem::create($validatedData);
        }

        return redirect()->action('CustomerController@show', ['id' => $sku['spu_id']]);
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
        $this->authorize('update', $cart);

        $validatedData = $request->validate([
            'amount' => 'required|integer|min:1',
        ]);
        $status = $cart->update($validatedData);

        return redirect()->action('CartController@index');
    }

    /**
     * Remove 購物車內的商品物品.
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
