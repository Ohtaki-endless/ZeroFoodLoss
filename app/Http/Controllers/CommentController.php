<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Comment $comment, CommentRequest $request, Post $post)
    {
        $input = $request['comment'];
        $input += ['user_id' => $request->user()->id];
        $input += ['post_id' => $post->id];
        $comment->fill($input)->save();
        return back();
    }
    
    // 削除処理（論理削除）
    public function delete(Comment $comment)
    {
        $comment->delete();
        return back();
    }
}
