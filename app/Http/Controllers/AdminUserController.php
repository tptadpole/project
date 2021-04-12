<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminUserController extends Controller
{
    /**
     * Display the users information
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', '=', 'user')->paginate(8);
        return view('adminUsers')->with(['users' => $users]);
    }

    /**
     * edit the users information.
     *
     * @param int $users_id
     * @return \Illuminate\Http\Response
     */
    public function edit($users_id)
    {
        $user = User::find($users_id)->toArray();
        return view('adminEditUser')->with([ 'user' => $user ]);
    }

    /**
     * Update the buy amount of specified commodity in cart.
     *
     * @param Request $request
     * @param int $users_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $users_id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'role' => 'required|in:admin,manager,user',
            'email' => 'required|email',
        ]);

        if (! $cart = CartItem::find($cart_id)) {
            throw new APIException('商品細項找不到', 404);
        }

        $status = $cart->update($validatedData);

        return redirect()->action('CartController@index');
    }
}
