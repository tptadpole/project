<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    /**
     * Display all order's information
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(10);
        return view('adminOrder')->with(['orders' => $orders]);
    }

    /**
     * Remove the order's information.
     *
     * @param  int  $order_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($order_id)
    {
        if (! $order = Order::find($order_id)) {
            throw new APIException('訂單找不到', 404);
        }

        $status = $order->delete();

        return redirect()->action('AdminOrderController@index');
    }
}
