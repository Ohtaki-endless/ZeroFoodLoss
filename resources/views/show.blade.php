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