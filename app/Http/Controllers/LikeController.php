<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use App\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Post $post){
        $like=New Like();
        $like->post_id = $post->id;
        $like->user_id = Auth::user()->id;
        $like->save();
        return back();
    }
    
    public function unlike(Post $post){
        $user=Auth::user()->id;
        $nice=Like::where('post_id', $post->id)->where('user_id', $user)->first();
        $nice->delete();
        return back();
    }
}
