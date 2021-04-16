<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;

class AdminOrderItemController extends Controller
{
    /**
     * Display all orderItem's information
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderItems = OrderItem::paginate(10);
        return view('adminOrderItem')->with(['orderItems' => $orderItems]);
    }

    /**
     * Display all transport orderItem's
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $orderItems = OrderItem::where('status', '=', '運送中')->paginate(10);
        return view('adminOrderItemTransport')->with(['orderItems' => $orderItems]);
    }

    /**
     * Display the specific transport orderItem's
     *
     * @return \Illuminate\Http\Response
     */
    public function display($order_id)
    {
        $orderItems = OrderItem::where('order_id', '=', $order_id)->paginate(10);
        return view('adminOrderItemSpecific')->with(['orderItems' => $orderItems]);
    }

    /**
     * Remove the transport orderItem's information.
     *
     * @param  int  $orderItem_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($orderItem_id)
    {
        if (! $orderItem = OrderItem::find($orderItem_id)) {
            abort(404);
        }

        $status = $orderItem->delete();

        return redirect()->action('AdminOrderItemController@index');
    }

    /**
     * Update the transport orderItem's information.
     *
     * @param Request $request
     * @param int $orderItem_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $orderItem_id)
    {

        if (! $orderItem = OrderItem::find($orderItem_id)) {
            abort(404);
        }

        $orderItemStatus = [ 'status' => '取貨' ];

        $status = $orderItem->update($orderItemStatus);

        return redirect()->action('AdminOrderItemController@show');
    }
}
