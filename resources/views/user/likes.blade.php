@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h5">
                    いいねした商品一覧
                </div>
                
                @if(empty($user->likes[0]))
                    <div class="card-body">いいねした商品はありません</div>
                @else
                
                <div class="card-body mx-auto">
                    @foreach ($user->likes as $like)
                    <div class="pb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <img class="mx-auto d-block" src="{{ $like->image_path }}" width="150" height="150">
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <h5 class='card-title pt-1'>
                                            <a class="stretched-link" href="/posts/{{ $like->id }}">{{ $like->title }}</a>
                                        </h5>
                                        <p class="pt-1">
                                            {{ $like->body }}
                                        </p>
                                        <h4 class="pt-1 font-weight-bold">
                                            ¥ {{ number_format($like->price) }}
                                        </h4>
                                        
                                        <div id="sale">
                                            @if($like->role == 1)
                                            <h4 class='card-text'>
                                                <span class="text-white badge rounded-pill bg-danger">
                                                販売中
                                                </span>
                                            </h4>
                                            <p class="card-text">
                                                在庫数：{{ number_format($like->quantity) }}
                                            </p>
                                            @else
                                            <h4 class="card-text">
                                                <span class="text-white badge rounded-pill bg-secondary">
                                                    売り切れ
                                                </span>
                                            </h4>
                                            <p class="card-text">
                                                申し訳ございません。<br>こちらの商品は、売り切れとなりました。
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                
                <div class="card-body">
                    <a href="/user/index" class="card-link btn btn-outline-secondary">
                        戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection