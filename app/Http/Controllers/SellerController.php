<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Spu;
use App\Models\Sku;
use App\User;

class SellerController extends Controller
{
    /**
     * Display the 商品標題 which is selled by users
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
     * Create a new 商品標題
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
            $image = $request->file('image');
            // 檔案存在，所以存到project/storage/app/public，並拿到url，此範例會拿到public/fileName
            $imageURL = request()->file('image')->store('/public');
            // 因為我們只想要將純粹的檔名存到資料庫，所以特別做處理
            $validatedData['image'] = substr($imageURL, 7);
        }

        $status = Spu::create($validatedData);
   
        return redirect('/seller')->with('success', '新的商品已成功儲存');
    }

    /**
     * Remove the specified 商品標題 from storage.
     *
     * @param  int  $spu_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($spu_id)
    {

        if (! $spu = Spu::find($spu_id)) {
            abort(404);
        }
        
        $status = $spu->delete();

        $deleteSku = Sku:: where('spu_id', '=', $spu_id)->delete();

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
            $image = $request->file('image');
            // 檔案存在，所以存到project/storage/app/public，並拿到url，此範例會拿到public/fileName
            $imageURL = request()->file('image')->store('/public');
            // 因為我們只想要將純粹的檔名存到資料庫，所以特別做處理
            $validatedData['image'] = substr($imageURL, 7);
        }

        $image_path = public_path('/images') . '/' . $spu->toArray() ['image'];

        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        $status = $spu->update($validatedData);
        return redirect()->action('SellerController@index');
    }
}
