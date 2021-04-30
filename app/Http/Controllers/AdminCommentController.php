<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class AdminCommentController extends Controller
{
    /**
     * dispaly all comment
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all()->toArray();
        return view('adminComment')->with([ 'comments' => $comments ]);
    }

    /**
     * delete specific comment
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($comment_id)
    {
        if (!$comment = Comment::find($comment_id)) {
            abort(404);
        }
        
        $status = $comment->delete();

        return redirect()->action('AdminCommentController@index');
    }
}
