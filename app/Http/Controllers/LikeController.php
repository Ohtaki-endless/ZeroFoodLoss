<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use Auth;

class LikeController extends Controller
{
    // いいね処理
    public function store(Post $post)
    {
        $post->users()->attach(Auth::id());
        $count = $post->users()->count(); 
        $result = true;
        return response()->json([
            'result' => $result, 
            'count' => $count,  
        ]);
    }
    
    // いいねの取り消し
    public function destroy(Post $post)
    {
        $post->users()->detach(Auth::id());
        $count = $post->users()->count();
        $result = false;
        return response()->json([
            'result' => $result, 
            'count' => $count, 
        ]);
    }
    
    // いいね数のカウント
    public function count(Post $post)
    {
        $count = $post->users()->count();
        return response()->json($count);
    }
    
    // いいねしているか否か判別
    public function hasfavorite(Post $post)
    {
        if ($post->users()->where('user_id', Auth::id())->exists()) {
            $result = true;
        } else {
            $result = false;
        }
        return response()->json($result);
    }
    
    // いいねしたユーザー一覧表示
    public function likeusers(Post $post){
        $post->load('users');
        return view('likeusers', compact('post'));
    }
}
