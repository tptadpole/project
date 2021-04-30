<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spu;
use App\Models\Sku;

class CustomerController extends Controller
{
    /**
     * Display the homepage and recommend commodity
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commodities = Spu::paginate(8);

        return view('customerTotal')->with(['commodities' => $commodities]);
    }

    /**
     * Show the homepage and recommend commodity
     *
     * @return \Illuminate\Http\Response
     */
    public function show($spu_id)
    {
        if (! $spu = Spu::find($spu_id)) {
            abort(404);
        }
        
        $commodities = Sku::where('spu_id', '=', $spu_id)->paginate(8);

        return view('customerPick')->with(['commodities' => $commodities]);
    }
}
