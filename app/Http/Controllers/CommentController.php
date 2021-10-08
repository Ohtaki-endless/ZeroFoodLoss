<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Comment $comment, CommentRequest $request)
    {
        dd($post);
        $input = $request['comment'];
        $input += ['user_id' => $request->user()->id];
        // $input += ['post_id' => $request->post()->id]; なぜ取得できない？
        $comment->fill($input)->save();
        return redirect('/posts/' . $input['post_id']);
    }
    
    // 削除処理（論理削除）
    public function delete(Comment $comment)
    {
        $comment->delete();
        return redirect('/posts/' . $comment->post_id);
    }
}
