@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ $post->body }}</p>
                </div>
                
                <div class="card-body">
                    <a href="/posts/{{ $post->id }}/edit" class="card-link">編集</a>
                    <form action="/posts/{{ $post->id }}" id="form_delete" method="post" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <input type="button" onclick="deletePost();" value="削除">
                    </form>
                </div>
                    
                <div class="card-body">
                    <a href="/" class="card-link">戻る</a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">コメントを投稿</div>

                <div class="card-body">
                    <form action="/posts" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control" name="post[body]" placeholder="This is Good!">{{ old('post.body') }}</textarea>
                            <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
                        </div>
                        <input type="submit" value="投稿">
                    </form>
                </div>
            </div>
            @foreach ($post->comments as $comment)
            <div class="card">
                <div class="card-body">
                    <div class='card-text' style='font-weight:  bold;'>投稿者：{{ $comment->user->name }}</p></div>
                    <div class='card-text'>{{ $comment->comment }}</p></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    function deletePost(){
        'use strict'
        if (window.confirm('削除すると復元できません。\n本当に削除しますか？')) {
            document.getElementById('form_delete').submit();
        }
    }
</script>
@endsection