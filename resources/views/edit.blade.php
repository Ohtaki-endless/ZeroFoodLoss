@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h5">編集</div>

                <div class="card-body">
                    <form action="/posts/{{ $post->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label h5">
                                商品名
                            </label>
                            <input type='text' class="form-control" name='post[title]' value="{{ $post->title }}">
                            <h5 class="title__error" style="color:red">{{ $errors->first('post.title') }}</h5>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label h5">
                                商品説明
                            </label>
                            <textarea class="form-control" name='post[body]'>{{ $post->body }}</textarea>
                            <h5 class="body__error" style="color:red">{{ $errors->first('post.body') }}</h5>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label h5">
                                値段
                            </label>
                            <input type="number" class="form-control" name="post[price]" value="{{ $post->price }}"/>
                            <h5 class="price__error" style="color:red">{{ $errors->first('post.price') }}</h5>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label h5">
                                数量
                            </label>
                            <input type="number" class="form-control" name="post[quantity]" value="{{ $post->quantity }}"/>
                            <h5 class="quantity__error" style="color:red">{{ $errors->first('post.quantity') }}</h5>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label h5">
                                期限
                            </label>
                            <input type="datetime-local" class="form-control" name="post[limit]" value="{{ $post->limit }}"/>
                            <h5 class="limit__error" style="color:red">{{ $errors->first('post.limit') }}</h5>
                        </div>
                        
                        <div class="mb-3">
                            <h5>商品画像は変更する場合のみ選択</h5>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label h5">
                                商品画像
                            </label>
                            <input type="file" name="image" value="">
                            <p class="image__error" style="color:red">{{ $errors->first('post.image') }}</p>
                        </div>
                        
                        <input type="submit" value="保存" class="btn btn-primary btn-lg">
                        
                        <a href="/posts/{{ $post->id }}" class="btn btn-outline-secondary btn-lg">戻る</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection