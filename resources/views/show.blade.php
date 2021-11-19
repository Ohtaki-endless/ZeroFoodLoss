@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <!--管理者のみ表示-->
                @can('isAdmin')
                <div class="card-body">
                    <a href="/posts/{{ $post->id }}/edit" class="btn btn-primary">編集</a>
                    <form action="/posts/{{ $post->id }}" id="post_delete" method="post" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <input type="button" onclick="deletePost();" value="削除" class="btn btn-primary">
                    </form>
                </div>
                @endcan
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <img src="{{ $post->image_path }}" width="250" height="250">
                        </div>
                        <div class="col-lg-6 pt-2">
                            <h3>{{ $post->title }}</h3>
                            <p class="pt-2">
                                {{ $post->body }}
                            </p>
                            <h4 class="pt-2">
                                ¥ {{ number_format($post->price) }}
                            </h4>
                            @if($post->role == 1)
                            <div id="sale">
                                <h4 class='card-text'><span class="text-white badge rounded-pill bg-danger">販売中</span></h4>
                                <h5 class="font-weight-bold">
                                    在庫数：{{ number_format($post->quantity) }}
                                </h5>
                                
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
                                    <input type="submit" value="カートに追加" class="btn btn-warning btn-sm">
                                </form>
                            </div>
                            
                            <div id="sold-out">
                                <h4 class="card-text"><span class="text-white badge rounded-pill bg-secondary">売り切れ</span></h4>
                                <p class="card-text">申し訳ございません。<br>こちらの商品は、購入期限切れとなりました。</p>
                            </div>
                            @else
                                <h4 class="card-text"><span class="text-white badge rounded-pill bg-secondary">売り切れ</span></h4>
                                <p class="card-text">申し訳ございません。<br>こちらの商品は、売り切れとなりました。</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if($post->users()->where('user_id', Auth::id())->exists())
                    	<a href="/{{ $post->id }}/unlikes" class="btn btn-danger btn-sm">
                    		いいね
                    		<span class="badge">
                    			{{ $post->users()->count() }}
                    		</span>
                    	</a>
                    @else
                    	<a href="/{{ $post->id }}/likes" class="btn btn-secondary btn-sm">
                    		いいね
                    		<span class="badge">
                    			{{ $post->users()->count() }}
                    		</span>
                    	</a>
                    @endif
                    <a href="/{{ $post->id }}/likes/users" class="btn btn-secondary btn-sm">
                    	いいねしたユーザー
                    </a>
                </div>
                
                <div class="card-body">
                    <a href="/" class="card-link">
                        戻る
                    </a>
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
                    @can('isAdmin')
                    <form action="/{{ $comment->id }}/comments" id="comment_{{ $comment->id }}_delete" method="post" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <input type="button" data-id="{{ $comment->id }}" onclick="deleteComment(this);" value="削除">
                    </form>
                    @endcan
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script>const goal = @json($limit)</script>
<script src="{{ asset('/js/show.js') }}"></script>
@endsection