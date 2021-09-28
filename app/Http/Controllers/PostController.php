<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;

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
        return view('show')->with(['post' => $post]);
    }
    
    // 新規投稿画面表示
    public function create()
    {
        return view('create');
    }
    
    // 新規投稿実行処理
    public function store(Post $post, PostRequest $request)
    {
        $input = $request['post'];
        $post->fill($input)->save();
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
}
