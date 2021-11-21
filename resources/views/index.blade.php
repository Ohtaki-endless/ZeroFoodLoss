@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @can('isAdmin')
            <a href='/posts/create' class="btn btn-primary btn-lg">商品新規登録</a>
            @endcan
            
            <div class="row">
                @foreach ($posts as $post)
                <div class="col-lg-6 pt-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class='card-text'>
                                <img src="{{ $post->image_path }}" width="180" height="180">
                            </div>
                            <h4 class='card-title pt-4'>
                                <a class="stretched-link" href="/posts/{{ $post->id }}">
                                    {{ $post->title }}
                                </a>
                            </h4>
                            <h3 class='card-text font-weight-bold'>
                                ¥ {{ number_format($post->price) }}
                            </h3>
                            <p class='card-text'>
                                在庫数：{{ number_format($post->quantity) }}
                            </p>
                            
                            @if($post->role == 1)
                                <h4 class='card-text'><span class="text-white badge rounded-pill bg-danger">販売中</span></h4>
                            @else
                                <h4 class='card-text'><span class="text-white badge rounded-pill bg-secondary">売り切れ</span></h4>
                            @endif
                            
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class='paginate pt-3'>
                {{ $posts->links() }}
            </div>
            
        </div>
    </div>
</div>
@endsection