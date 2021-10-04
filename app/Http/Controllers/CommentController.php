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
        $input = $request['comment'];
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