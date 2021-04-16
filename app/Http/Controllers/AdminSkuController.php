<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sku;

class AdminSkuController extends Controller
{
    /**
     * Display all sku's information
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skus = Sku::paginate(10);
        return view('adminSku')->with(['skus' => $skus]);
    }

    /**
     * edit the sku's information.
     *
     * @param int $sku_id
     * @return \Illuminate\Http\Response
     */
    public function edit($sku_id)
    {
        $sku = Sku::find($sku_id)->toArray();
        return view('adminEditSku')->with([ 'sku' => $sku ]);
    }

    /**
     * Update the sku's information.
     *
     * @param Request $request
     * @param int $sku_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sku_id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'specification' => 'required|string|max:50',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        if (! $sku = Sku::find($sku_id)) {
            throw new APIException('商品細項找不到', 404);
        }

        if (request()->hasFile('image')) {
            $image = $request->file('image');
            // 檔案存在，所以存到project/storage/app/public，並拿到url，此範例會拿到public/fileName
            $imageURL = request()->file('image')->store('/public');
            // 因為我們只想要將純粹的檔名存到資料庫，所以特別做處理
            $validatedData['image'] = substr($imageURL, 7);
            $image->move(public_path('/images'), $imageURL);

            $image_path = public_path('/images') . '/' . $sku->toArray() ['image'];

            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $status = $sku->update($validatedData);

        return redirect()->action('AdminSkuController@index');
    }

    /**
     * Remove the sku's information.
     *
     * @param  int  $sku_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sku_id)
    {
        if (! $sku = Sku::find($sku_id)) {
            throw new APIException('購物車內商品找不到', 404);
        }

        $status = $sku->delete();

        return redirect()->action('AdminSkuController@index');
    }
}
