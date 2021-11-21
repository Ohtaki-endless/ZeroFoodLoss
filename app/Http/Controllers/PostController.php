<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PostRequest;
use Carbon\Carbon;

class PostController extends Controller
{
    // 投稿一覧画面
    public function index(Post $post)
    {
        return view('index')->with(['posts' => $post->getPaginateByLimit()]);
    }
    
    // 投稿詳細画面
    public function show(Post $post)
    {
        $post->load('comments.user');
        // strtotimeメソッドでタイムスタンプに変換
        $limit = strtotime($post->limit);
        
        return view('show', compact('post' , 'limit'));
    }
    
    // 新規投稿画面表示
    public function create()
    {
        return view('create');
    }
    
    // 新規投稿実行処理
    public function store(Post $post, PostRequest $request)
    {
        $post = new Post;
        $input = $request['post'];
        
        if($request->file('image')){
            // バケットへアップロード
            $image = $request->file('image');
            $path = Storage::disk('s3')->putFile('/', $image, 'public');
            // アップロードした画像のパスを取得
            $post->image_path = Storage::disk('s3')->url($path);
        }
        
        $post->fill($input);
        $post->save();
        return redirect('/posts/' . $post->id);
    }
    
    // 編集画面表示処理
    public function edit(Post $post)
    {
        return view('edit')->with(['post' => $post]);
    }
    
    // 編集実行処理
    public function update(PostRequest $request, Post $post)
    {
        $input_post = $request['post'];
        $post->fill($input_post)->save();
        return redirect('/posts/' . $post->id);
    }
    
    // 削除処理（論理削除）
    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/');
    }
    
    // ロールの切り替え処理
    public function role(Post $post)
    {
        if($post->role === 1){
            $post->where('id', $post->id)->update(['role' => 10]);
        } else {
            $post->where('id', $post->id)->update(['role' => 1]);
        }
        return back();
    }
}
