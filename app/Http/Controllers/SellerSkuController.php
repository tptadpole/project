<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Sku;
use App\Models\Spu;
use DB;

class SellerSkuController extends Controller
{
    /**
     * Display the detail of commodity which is selled by users
     *
     * @param int $spu_id
     * @return \Illuminate\Http\Response
     */
    public function index($spu_id)
    {
        $spu = Spu:: where('id', '=', $spu_id)->get()->toArray();
        //dd($spu);

        $commodities = Sku:: where('spu_id', '=', $spu_id)->get()->toArray();

        return view('sku')->with([ 'spu' => $spu, 'commodities' => $commodities ]);
    }

    /**
     * Create a new detail of commodity
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $spu_id = $id;
        return view('createSku')->with(['spu_id' => $spu_id]);
    }

    /**
     * Store a newly created detail of commodity in storage
     *
     * @param Request $request
     * @param integer $spu_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $spu_id)
    {
        $id = $spu_id;
        $validatedData = $request->validate([
            'price' => 'required|numeric',
            'capacity' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);
        $validatedData['spu_id'] = $id;
        $show = Sku::create($validatedData);
   
        return redirect()->action('SellerSkuController@index', ['id' => $id]);
    }

    /**
     * Remove the specified detail of commodity from storage.
     *
     * @param  int  $sku_Id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sku_id)
    {
        if (! $sku = Sku::find($sku_id)) {
            throw new APIException('商品細項找不到', 404);
        }
        $id = $sku->toArray();
        $spu_id = $id['spu_id'];
        $status = $sku->delete();
        return redirect()->action('SellerSkuController@index', ['id' => $spu_id]);
    }

    /**
     * edit the specified commodity of detail from storage.
     *
     * @param int $sku_id
     * @return \Illuminate\Http\Response
     */
    public function edit($sku_id)
    {
        $data = Sku::find($sku_id)->toArray();
        return view('editSku')->with(['data' => $data]);
    }

    /**
     * Update the specified commodity of datail in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sku_id)
    {
        $request->validate([
            'price' => 'required|numeric',
            'capacity' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        if (! $sku = Sku::find($sku_id)) {
            throw new APIException('課程找不到', 404);
        }
        $status = $sku->update($request->toArray());
        $spu_id = $sku->toArray();
        return redirect()->action('SellerSkuController@index', ['id' =>$spu_id['spu_id']]);
    }
}