<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Spu;
use DB;

class SellerController extends Controller
{
    /**
     * Display the commodity which is selled by users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $commodities = Spu:: where('users_id', '=', $id)->get()->toArray();
        return view('seller')->with(['commodities' => $commodities]);
    }

    /**
     * Create a new commodity
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createSpu');
    }

    /**
     * Store a newly created commodity in storage
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::id();
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
        $validatedData['users_id'] = $id;
        $show = Spu::create($validatedData);
   
        return redirect('/seller')->with('success', '新的商品已成功儲存');
    }
}
