<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spu;
use App\Models\Sku;

class AdminSpuController extends Controller
{
    /**
     * Display all 商品標題 information
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spus = Spu::paginate(10);
        return view('adminSpu')->with(['spus' => $spus]);
    }

    /**
     * edit the 商品標題 information.
     *
     * @param int $spu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($spu_id)
    {
        if (! $spu = Spu::find($spu_id)) {
            abort(404);
        }

        $spu = $spu->toArray();
        return view('adminEditSpu')->with([ 'spu' => $spu ]);
    }

    /**
     * Update the 商品標題 information.
     *
     * @param Request $request
     * @param int $spu_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $spu_id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'description' => 'required|string|max:50',
        ]);

        if (! $spu = Spu::find($spu_id)) {
            abort(404);
        }

        if (request()->hasFile('image')) {
            $image = $request->file('image');
            // 檔案存在，所以存到project/storage/app/public，並拿到url，此範例會拿到public/fileName
            $imageURL = request()->file('image')->store('/public');
            // 因為我們只想要將純粹的檔名存到資料庫，所以特別做處理
            $validatedData['image'] = substr($imageURL, 7);

            $image_path = public_path('/storage') . '/' . $spu->toArray() ['image'];

            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $status = $spu->update($validatedData);

        return redirect()->action('AdminSpuController@index');
    }

    /**
     * Remove the 商品標題 information.
     *
     * @param  int  $spu_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($spu_id)
    {
        if (! $spu = Spu::find($spu_id)) {
            abort(404);
        }

        // 在刪除商品標題的同時也透過軟刪除來做刪除商品物品
        $status = Spu::where('id', '=', $spu_id)->first()->delete();

        return redirect()->action('AdminSpuController@index');
    }
}
