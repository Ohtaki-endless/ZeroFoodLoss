@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <a href='/posts/create'>新規投稿作成</a>
            
            @foreach ($posts as $post)
            <div class="card">
                <div class="card-body">
                    <h5 class='card-title'><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></h5>
                    <div class='card-text'>{{ $post->body }}</p></div>
                </div>
            </div>
            @endforeach
            
            <div class='paginate'>
                {{ $posts->links() }}
            </div>
            
        </div>
    </div>
</div>
@endsection