<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Sku;
use App\Models\Spu;

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

        $commodities = Sku:: where('spu_id', '=', $spu_id)->paginate(8);

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
            'name' => 'required|string|max:20',
            'price' => 'required|numeric',
            'specification' => 'required|string|max:50',
            'stock' => 'required|numeric',
            'image' => 'required|image',
        ]);
        $validatedData['spu_id'] = $id;
        $validatedData['users_id'] = Auth::id();

        if (request()->hasFile('image')) {
            $image = $request->file('image');
            // 檔案存在，所以存到project/storage/app/public，並拿到url，此範例會拿到public/fileName
            $imageURL = request()->file('image')->store('/public');
            // 因為我們只想要將純粹的檔名存到資料庫，所以特別做處理
            $validatedData['image'] = substr($imageURL, 7);
            $image->move(public_path('/images'), $imageURL);
        }

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
        $spu_id = $sku->toArray()['spu_id'];

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
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'price' => 'required|numeric',
            'specification' => 'required|string|max:50',
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
            $storage_path = public_path('/storage') . '/' . $sku->toArray() ['image'];

            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            if (File::exists($storage_path)) {
                dd(true);
                File::delete($storage_path);
            }
        }

        $status = $sku->update($validatedData);
        $spu_id = $sku->toArray();

        return redirect()->action('SellerSkuController@index', ['id' => $spu_id['spu_id']]);
    }
}
