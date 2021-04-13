<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spu;
use App\Models\Sku;

class AdminSpuController extends Controller
{
    /**
     * Display all spu's information
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spus = Spu::paginate(10);
        return view('adminSpu')->with(['spus' => $spus]);
    }

    /**
     * edit the spu's information.
     *
     * @param int $spu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($spu_id)
    {
        $spu = Spu::find($spu_id)->toArray();
        return view('adminEditSpu')->with([ 'spu' => $spu ]);
    }

    /**
     * Update the user information.
     *
     * @param Request $request
     * @param int $spu_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $spu_id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        if (! $spu = Spu::find($spu_id)) {
            throw new APIException('商品細項找不到', 404);
        }

        if (request()->hasFile('image')) {
            $image = $request->file('image');
            // 檔案存在，所以存到project/storage/app/public，並拿到url，此範例會拿到public/fileName
            $imageURL = request()->file('image')->store('/public');
            // 因為我們只想要將純粹的檔名存到資料庫，所以特別做處理
            $validatedData['image'] = substr($imageURL, 7);
            $image->move(public_path('/images'), $imageURL);
        }

        $status = $spu->update($validatedData);

        return redirect()->action('AdminSpuController@index');
    }

    /**
     * Remove the spu information.
     *
     * @param  int  $spu_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($spu_id)
    {
        if (! $spu = Spu::find($spu_id)) {
            throw new APIException('購物車內商品找不到', 404);
        }
        $status = $spu->delete();


        $deleteSku = Sku:: where('spu_id', '=', $spu_id)->delete();

        return redirect()->action('AdminSpuController@index');
    }
}