@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <a href='/posts/create'>新規投稿作成</a>
            
            @foreach ($posts as $post)
            <div class="card">
                
                <div class="card-body">
                    <div class='posts'>
                    <h3 class='card-title'><a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                    <p class='card-text'>{{ $post->body }}</p>
                    
                    <!--削除ボタン-->
                    <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary" onclick="deletePost();">削除</button> 
                    </form>
                        
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

<div class='paginate'>
    {{ $posts->links() }}
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