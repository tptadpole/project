<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Sku;
use App\Models\Order;
use App\User;

class CommentController extends Controller
{

    /**
     * Display 買家過去所做的所有評論
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users_id = Auth::id();

        $comments = User::find($users_id)->commentSku()->get()->toArray();
        return view('comment')->with([ 'comments' => $comments ]);
    }

    /**
     * Display the sku's comment
     *
     * @return \Illuminate\Http\Response
     */
    public function show($sku_id)
    {
        $sku = Sku::where('id', '=', $sku_id)->get()->toArray();
        $comments = Sku::find($sku_id)->comment()->get()->toArray();
        return view('skuComment')->with([ 'sku' => $sku, 'comments' => $comments ]);
    }

    /**
     * Store a newly created comment
     *
     * @param Request $request
     * @param  int  $sku_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $sku_id)
    {
        $users_id = Auth::id();

        $validatedData = $request->validate([
            'comment' => ['required', 'string', 'max:50'],
        ]);

        $validatedData['users_id'] = $users_id;
        $validatedData['sku_id'] = $sku_id;

        $status = Comment::create($validatedData);

        $orders = Order:: where('users_id', '=', $users_id)->paginate(8);
        return view('order')->with(['orders' => $orders]);
    }

    /**
     * Remove the comment
     *
     * @param  int  $comment_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($comment_id)
    {
        if (! $comment = Comment::find($comment_id)) {
            abort(404);
        }

        $this->authorize('delete', Comment::find($comment_id));

        $status = $comment->delete();
        return redirect()->action('CommentController@index');
    }

    /**
     * 進入修改評論的頁面
     *
     * @param int $comment_id
     * @return \Illuminate\Http\Response
     */
    public function edit($comment_id)
    {
        if (! $comment = Comment::find($comment_id)) {
            abort(404);
        }
        return view('editComment')->with([ 'comment' => $comment ]);
    }

    /**
     * 更新修改過後的評論
     *
     * @param Request $request
     * @param int $comment_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $comment_id)
    {

        if (! $comment = Comment::find($comment_id)) {
            abort(404);
        }
        $this->authorize('update', Comment::find($comment_id));

        $validatedData = $request->validate([
            'comment' => 'required|string',
        ]);
        $status = $comment->update($validatedData);

        return redirect()->action('CommentController@index');
    }
}
