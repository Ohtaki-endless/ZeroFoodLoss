<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // コメント投稿処理
    public function store(Comment $comment, CommentRequest $request, Post $post)
    {
        $input = $request['comment'];
        $input += ['user_id' => $request->user()->id];
        $input += ['post_id' => $post->id];
        $comment->fill($input)->save();
        
        // フラッシュメッセージの追加
        session()->flash('flash_message', 'コメントを投稿しました！');
        return back();
    }
    
    // コメント削除処理
    public function delete(Comment $comment)
    {
        $comment->delete();
        return back();
    }
}
