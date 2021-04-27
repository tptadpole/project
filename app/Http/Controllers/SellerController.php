<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Spu;
use App\Models\Sku;
use Storage;

class SellerController extends Controller
{
    /**
     * 顯示該賣家所有的商品標題
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users_id = Auth::id();
        $commodities = Spu:: where('users_id', '=', $users_id)->paginate(8);
        return view('seller')->with(['commodities' => $commodities]);
    }

    /**
     * 前往新增商品標題的頁面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createSpu');
    }

    /**
     * Store a newly created 商品標題 in storage
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users_id = Auth::id();
        
        $validatedData = $request->validate([
            'name' => 'required|max:20',
            'description' => 'required|max:50',
            'image' => ['required', 'image'],
        ]);
        $validatedData['users_id'] = $users_id;

        if (request()->hasFile('image')) {
            // 檔案存在，所以存到project/storage/app/public，並拿到url，此範例會拿到public/fileName
            $imageURL = request()->file('image')->store('/public');
            // 因為我們只想要將純粹的檔名存到資料庫，所以特別做處理
            $imageName = 'garyke/garyke-demo/image/' .substr($imageURL, 7);
            $path = $request->image->path();
            Storage::disk('s3')->put($imageName, file_get_contents($path), 'public');
            $validatedData['image'] = substr($imageURL, 7);
        }

        $status = Spu::create($validatedData);
   
        return redirect('/seller')->with('success', '新的商品已成功儲存');
    }

    /**
     * 在移除商品標題的同時也刪除了商品標題內的商品物品
     * 在刪除商品標題內的商品物品也刪除了購物車內的商品物品
     * @param  int  $spu_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($spu_id)
    {
        if (! $spu = Spu::find($spu_id)) {
            abort(404);
        }
        $this->authorize('delete', $spu);
        
        // 在刪除商品標題的同時也透過軟刪除來做刪除商品物品
        $status = Spu::where('id', '=', $spu_id)->first()->delete();

        return redirect()->action('SellerController@index');
    }

    /**
     * edit the specified 商品標題 from storage.
     *
     * @param int $spu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($spu_id)
    {
        if (!$data = Spu::find($spu_id)) {
            abort(404);
        }
        $data = $data->toArray();

        return view('editSpu')->with(['data' => $data]);
    }

    /**
     * Update the specified 商品標題 in storage.
     *
     * @param Request $request
     * @param int $spu_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $spu_id)
    {
        if (! $spu = Spu::find($spu_id)) {
            abort(404);
        }

        $this->authorize('update', Spu::find($spu_id));

        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'description' => 'required|string|max:50',
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

            $image_path = 'garyke/garyke-demo/image/'. $spu->toArray() ['image'];

            if ($exists = Storage::disk('s3')->has($image_path)) {
                Storage::disk('s3')->delete($image_path);
            }
        }

        $status = $spu->update($validatedData);
        return redirect()->action('SellerController@index');
    }
}
