@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @can('isAdmin')
            <a href='/posts/create' class="btn btn-primary">新規投稿作成</a>
            @endcan
            
            <div class="row">
                @foreach ($posts as $post)
                <div class="col-lg-6 pt-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class='card-text'><img src="{{ $post->image_path }}"></div>
                            <h5 class='card-title pt-4'><a href="/posts/{{ $post->id }}">{{ $post->title }}</a></h5>
                            <h5 class='card-text'>¥{{ number_format($post->price) }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class='paginate'>
                {{ $posts->links() }}
            </div>
            
        </div>
    </div>
</div>
@endsection