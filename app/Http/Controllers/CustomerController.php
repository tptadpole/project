<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Spu;
use App\Models\Sku;
use DB;

class CustomerController extends Controller
{
    /**
     * Display the homepage and recommend commodity
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users_id = Auth::id();
        $commodities = Spu::where('id', '!=', $users_id)->paginate(8);
        return view('customerTotal')->with(['commodities' => $commodities]);
    }

    /**
     * Show the homepage and recommend commodity
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commodities = Sku::where('spu_id', '=', $id)->paginate(8);
        return view('customerPick')->with(['commodities' => $commodities]);
    }
}
