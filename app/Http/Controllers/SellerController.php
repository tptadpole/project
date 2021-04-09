<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Spu;
use App\Models\Sku;
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

    /**
     * Remove the specified commodity from storage.
     *
     * @param  int  $spu_Id
     * @return \Illuminate\Http\Response
     */
    public function destroy($spu_id)
    {
        if (! $spu = Spu::find($spu_id)) {
            throw new APIException('商品細項找不到', 404);
        }
        $temp = $spu->toArray();
        $id = $temp['id'];
        $status = $spu->delete();

        // 在刪除商品的時候也要把商品細項一起刪除
        $deleteSku = Sku:: where('spu_id', '=', $id)->delete();

        return redirect()->action('SellerController@index', ['id' => $id]);
    }

    /**
     * edit the specified commodity from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Spu::find($id)->toArray();
        return view('editSpu')->with(['data' => $data]);
    }

    /**
     * Update the specified commodity in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        if (! $spu = Spu::find($id)) {
            throw new APIException('課程找不到', 404);
        }
        $status = $spu->update($request->toArray());
        return redirect()->action('SellerController@index');
    }
}
