@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ $post->body }}</p>
                    <div class='card-text'><img src="{{ $post->image_path }}"></div>
                </div>
                
                <div class="card-body">
                    @if($post->users()->where('user_id', Auth::id())->exists())
                    	<a href="/{{ $post->id }}/unlikes" class="btn btn-danger btn-sm">
                    		いいね
                    		<!-- いいねの数を表示 -->
                    		<span class="badge">
                    			{{ $post->users()->count() }}
                    		</span>
                    	</a>
                    @else
                    	<a href="/{{ $post->id }}/likes" class="btn btn-secondary btn-sm">
                    		いいね
                    		<!-- いいねの数を表示 -->
                    		<span class="badge">
                    			{{ $post->users()->count() }}
                    		</span>
                    	</a>
                    @endif
                </div>
                
                <div class="card-body">
                    <a href="/{{ $post->id }}/likes/users" class="btn btn-sm">
                    	いいねしたユーザー
                    </a>
                </div>
                
                @can('isAdmin')
                <div class="card-body">
                    <a href="/posts/{{ $post->id }}/edit" class="card-link">編集</a>
                    <form action="/posts/{{ $post->id }}" id="post_delete" method="post" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <input type="button" onclick="deletePost();" value="削除">
                    </form>
                </div>
                @endcan
                    
                <div class="card-body">
                    <a href="/" class="card-link">戻る</a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">コメントを投稿</div>
                <div class="card-body">
                    <form action="/{{ $post->id }}/comments" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control" name="comment[comment]" placeholder="コメントを入力">{{ old('comment.body') }}</textarea>
                            <p class="comment__error" style="color:red">{{ $errors->first('comment.comment') }}</p>
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
                    <form action="/{{ $comment->id }}/comments" id="comment_{{ $comment->id }}_delete" method="post" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <input type="button" data-id="{{ $comment->id }}" onclick="deleteComment(this);" value="削除">
                    </form>
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
            document.getElementById('post_delete').submit();
        }
    }
    
    function deleteComment(e){
        'use strict'
        if (window.confirm('削除すると復元できません。\n本当に削除しますか？')) {
            document.getElementById('comment_' + e.dataset.id + '_delete').submit();
        }
    }
</script>
@endsection