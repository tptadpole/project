<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Sku;
use App\Models\Spu;
use Storage;

class SellerSkuController extends Controller
{
    /**
     *  顯示賣家某商品標題與該標題底下所有的商品物品
     *
     * @param int $spu_id
     * @return \Illuminate\Http\Response
     */
    public function index($spu_id)
    {
        if (!$spu = Spu::find($spu_id)) {
            abort(404);
        }
        $this->authorize('index', $spu);
        $spu = $spu->toArray();

        $commodities = Sku:: where('spu_id', '=', $spu_id)->paginate(8);

        return view('sku')->with([ 'spu' => $spu, 'commodities' => $commodities ]);
    }

    /**
     * 前往新增商品物品的頁面
     * @param int $spu_id
     * @return \Illuminate\Http\Response
     */
    public function create($spu_id)
    {
        return view('createSku')->with(['spu_id' => $spu_id]);
    }

    /**
     * Store a newly created 商品物品 in storage
     *
     * @param Request $request
     * @param integer $spu_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $spu_id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'price' => 'required|numeric|integer|max:1000000',
            'specification' => 'required|string|max:50',
            'stock' => 'required|numeric|integer|max:10000',
            'image' => 'required|image',
        ]);
        $validatedData['spu_id'] = $spu_id;
        $validatedData['users_id'] = Auth::id();

        if (request()->hasFile('image')) {
            // 檔案存在，所以存到project/storage/app/public，並拿到url，此範例會拿到public/fileName
            $imageURL = request()->file('image')->store('/public');
            // 因為我們只想要將純粹的檔名存到資料庫，所以特別做處理
            $imageName = 'garyke/garyke-demo/image/' .substr($imageURL, 7);
            $path = $request->image->path();
            Storage::disk('s3')->put($imageName, file_get_contents($path), 'public');
            $validatedData['image'] = substr($imageURL, 7);
        }

        $show = Sku::create($validatedData);
   
        return redirect()->action('SellerSkuController@index', ['id' => $spu_id]);
    }

    /**
     * Remove the specified 商品物品 from storage.
     *
     * @param  int  $sku_Id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sku_id)
    {
        if (! $sku = Sku::find($sku_id)) {
            abort(404);
        }
        $this->authorize('delete', $sku);

        $spu_id = $sku->toArray()['spu_id'];
        $status = $sku->delete();

        return redirect()->action('SellerSkuController@index', ['id' => $spu_id]);
    }

    /**
     * edit the specified 商品物品 from storage.
     *
     * @param int $sku_id
     * @return \Illuminate\Http\Response
     */
    public function edit($sku_id)
    {
        if (!$sku = Sku::find($sku_id)) {
            abort(404);
        }
        $sku = $sku->toArray();

        return view('editSku')->with(['sku' => $sku]);
    }

    /**
     * Update the specified 商品物品 in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sku_id)
    {
        if (! $sku = Sku::find($sku_id)) {
            abort(404);
        }
        $this->authorize('update', $sku);

        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'price' => 'required|integer|max:1000000',
            'specification' => 'required|string|max:50',
            'stock' => 'required|integer',
        ]);
        if (request()->hasFile('image')) {
            $request->validate([
                'image' => 'image',
            ]);

            // 檔案存在，所以存到project/storage/app/public，並拿到url，此範例會拿到public/fileName
            $imageURL = request()->file('image')->store('/public');
            // 因為我們只想要將純粹的檔名存到資料庫，所以特別做處理
            $imageName = 'garyke/garyke-demo/image/' .substr($imageURL, 7);
            $path = $request->image->path();
            Storage::disk('s3')->put($imageName, file_get_contents($path), 'public');
            $validatedData['image'] = substr($imageURL, 7);

            $image_path = 'garyke/garyke-demo/image/'. $sku->toArray() ['image'];

            if ($exists = Storage::disk('s3')->has($image_path)) {
                Storage::disk('s3')->delete($image_path);
            }
        }
        $status = $sku->update($validatedData);

        $sku = $sku->toArray();

        return redirect()->action('SellerSkuController@index', ['id' => $sku['spu_id']]);
    }
}
