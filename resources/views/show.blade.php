@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <example-component></example-component>
            <!--フラッシュメッセージ-->
            @if (session('flash_message'))
                <div class="alert alert-primary" role="alert">
                    {{ session('flash_message') }}
                </div>
            @endif
            
            <div class="card">
                
                <!--管理者のみ表示-->
                @can('isAdmin')
                <div class="card-body">
                    <a href="/posts/{{ $post->id }}/edit" class="btn btn-primary btn-lg">
                        編集
                    </a>
                    <form action="/posts/{{ $post->id }}" id="post_delete" method="post" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <input type="button" onclick="deletePost();" value="削除" class="btn btn-primary btn-lg">
                    </form>
                    <a href="/posts/{{ $post->id }}/role" class="btn btn-primary btn-lg">
                        販売状態の切り替え
                    </a>
                </div>
                @endcan
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <img class="mx-auto d-block" src="{{ $post->image_path }}" width="280" height="280">
                            
                            <!--いいねボタン-->
                            <!--<div class="card-body mx-auto">-->
                            <!--    @if($post->users()->where('user_id', Auth::id())->exists())-->
                            <!--    	<a href="/posts/{{ $post->id }}/unlikes" class="btn btn-danger btn-sm rounded-pill">-->
                            <!--    		いいね-->
                            <!--    		<span class="badge">-->
                            <!--    			{{ $post->users()->count() }}-->
                            <!--    		</span>-->
                            <!--    	</a>-->
                            <!--    @else-->
                            <!--    	<a href="/posts/{{ $post->id }}/likes" class="btn btn-outline-danger btn-sm rounded-pill">-->
                            <!--    		いいね-->
                            <!--    		<span class="badge">-->
                            <!--    			{{ $post->users()->count() }}-->
                            <!--    		</span>-->
                            <!--    	</a>-->
                            <!--    @endif-->
                                
                            <!--    @can('isAdmin')-->
                            <!--        <a href="/posts/{{ $post->id }}/likesusers" class="btn btn-secondary btn-sm">-->
                            <!--    	    いいねしたユーザー-->
                            <!--        </a>-->
                            <!--    @endcan-->
                            <!--</div>-->
                            <!--いいねボタン終-->
                            
                            <div class="card-body mx-auto">
                                <like-component :post="{{ json_encode($post)}}"></like-component>
                            </div>
                            
                        </div>
                        
                        <div class="col-lg-6 pt-2">
                            <h3>
                                {{ $post->title }}
                            </h3>
                            <p class="pt-2">
                                {{ $post->body }}
                            </p>
                            <h3 class="pt-2 font-weight-bold">
                                ¥ {{ number_format($post->price) }}
                            </h3>
                            
                            <!--販売中の表示-->
                            @if($post->role == 1)
                            <div id="sale">
                                <h5 class="font-weight-bold pt-2">
                                    在庫数：{{ number_format($post->quantity) }}
                                </h5>
                                
                                <h4 class='card-text'>
                                    <span class="text-white badge rounded-pill bg-danger">
                                        販売中
                                    </span>
                                </h4>
                                
                                <div class="countdown-timer">
                                    販売終了まであと</br>
                                    <span id="days"></span>日
                                    <span id="hours"></span>時間
                                    <span id="min"></span>分
                                    <span id="sec"></span>秒
                                </div>
                                
                                <form class="pt-4" action="/posts/{{ $post->id }}/addCart" method="POST" >
                                    @csrf
                                    <input type="hidden" name="products_id" value="{{$post->id}}">
                                    <input type="hidden" name="users_id" value="{{ Auth::id() }}">
                                    数量
                                    <select name="product_quantity">
                                        @for ($i = 1; $i <= $post->quantity; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <input type="submit" value="カートに追加" class="btn btn-primary rounded-pill">
                                </form>
                            </div>
                            
                            <div id="sold-out">
                                <h4 class="card-text">
                                    <span class="text-white badge rounded-pill bg-secondary">
                                        売り切れ
                                    </span>
                                </h4>
                                <p class="card-text">
                                    申し訳ございません。<br>
                                    こちらの商品は、購入期限切れとなりました。
                                </p>
                            </div>
                            <!--販売中の表示終-->
                            
                            @else
                            
                            <!--売切中の表示-->
                            <h4 class="card-text">
                                <span class="text-white badge rounded-pill bg-secondary">
                                    売り切れ
                                </span>
                            </h4>
                            <p class="card-text">
                                申し訳ございません。<br>
                                こちらの商品は、売り切れとなりました。
                            </p>
                            <!--売切中の表示終-->
                            
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <a href="/" class="card-link btn btn-outline-secondary">
                        商品一覧へ戻る
                    </a>
                </div>
            </div>
        </div>
        
        <!--コメント投稿フォーム-->
        <div class="col-md-8 pt-3">
            <div class="card">
                <div class="card-header">
                    コメントを投稿
                </div>
                <div class="card-body">
                    <form action="/{{ $post->id }}/comments" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input class="form-control @error('comment') is-invalid @enderror" name="comment" placeholder="コメントを入力">{{ old('comment.body') }}</input>
                        </div>
                        <p class="comment__error" style="color:red">{{ $errors->first('comment') }}</p>
                        <input class="btn btn-secondary rounded-pill" type="submit" value="投稿">
                    </form>
                </div>
            </div>
        </div>
        <!--コメント投稿フォーム終-->
            
        <!--コメント表示-->
        <div class="col-md-8">
            @foreach ($post->comments as $comment)
            <div class="card">
                <div class="card-body">
                    <div class='card-text' style='font-weight:  bold;'>
                        投稿者：{{ $comment->user->name }}
                    </div>
                    <div class='card-text pt-2'>
                        {{ $comment->comment }}
                    </div>
                    
                    <!--削除ボタン（投稿したユーザーのみ表示-->
                    @if(auth()->user()->name === $comment->user->name)
                    <form action="/{{ $comment->id }}/comments" id="comment_{{ $comment->id }}_delete" method="post" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <input type="button" data-id="{{ $comment->id }}" onclick="deleteComment(this);" value="削除" class="btn btn-secondary rounded-pill btn-sm">
                    </form>
                    @endcan
                    
                    <!--管理者用削除ボタン-->
                    @can('isAdmin')
                    <form action="/{{ $comment->id }}/comments" id="comment_{{ $comment->id }}_delete" method="post" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <input type="button" data-id="{{ $comment->id }}" onclick="deleteComment(this);" value="削除" class="btn btn-secondary rounded-pill btn-sm">
                    </form>
                    @endcan
                    
                </div>
            </div>
            @endforeach
        </div>
        <!--コメント表示終-->
        
    </div>
</div>
<script>const goal = @json($limit)</script>
<script src="{{ asset('/js/show.js') }}"></script>
@endsection