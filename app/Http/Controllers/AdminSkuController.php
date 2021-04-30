<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sku;
use Storage;

class AdminSkuController extends Controller
{
    /**
     * Display all 商品物品 information
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skus = Sku::paginate(10);
        return view('adminSku')->with(['skus' => $skus]);
    }

    /**
     * edit the 商品物品 information.
     *
     * @param int $sku_id
     * @return \Illuminate\Http\Response
     */
    public function edit($sku_id)
    {
        if (! $sku = Sku::find($sku_id)) {
            abort(404);
        }

        $sku = $sku->toArray();
        return view('adminEditSku')->with([ 'sku' => $sku ]);
    }

    /**
     * Update the 商品物品 information.
     *
     * @param Request $request
     * @param int $sku_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sku_id)
    {
        if (! $sku = Sku::find($sku_id)) {
            abort(404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'specification' => 'required|string|max:50',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        if (request()->hasFile('image')) {
            // 檔案存在，所以存到project/storage/app/public，並拿到url，此範例會拿到public/fileName
            $imageURL = request()->file('image')->store('/public');
            // 因為我們只想要將純粹的檔名存到資料庫，所以特別做處理
            $imageName = 'garyke/garyke-demo/image/' .substr($imageURL, 7);
            $path = $request->image->path();
            Storage::disk('s3')->put($imageName, file_get_contents($path), 'public');
            $validatedData['image'] = substr($imageURL, 7);

            $oldImagePath = 'garyke/garyke-demo/image/'. $sku->toArray()['image'];

            if ($exists = Storage::disk('s3')->has($oldImagePath)) {
                Storage::disk('s3')->delete($oldImagePath);
            }
        }

        $status = $sku->update($validatedData);

        return redirect()->action('AdminSkuController@index');
    }

    /**
     * Remove the 商品物品 information.
     *
     * @param  int  $sku_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sku_id)
    {
        if (! $sku = Sku::find($sku_id)) {
            abort(404);
        }

        $status = $sku->delete();

        return redirect()->action('AdminSkuController@index');
    }
}
