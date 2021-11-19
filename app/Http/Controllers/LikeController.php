<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use Auth;

class LikeController extends Controller
{
    // いいね処理
    public function like(Post $post){
        $post->users()->attach(Auth::id());
        return back();
    }
    
    // いいね取り消し処理
    public function unlike(Post $post){
        $post->users()->detach(Auth::id());
        return back();
    }
    
    // いいねしたユーザー一覧表示処理
    public function likeusers(Post $post){
        $post->load('users');
        return view('likeusers', compact('post'));
    }
}
