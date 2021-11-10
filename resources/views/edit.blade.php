@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">編集</div>

                <div class="card-body">
                    <form action="/posts/{{ $post->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">商品名</label>
                            <input type='text' class="form-control" name='post[title]' value="{{ $post->title }}">
                            <p class="title__error" style="color:red">{{ $errors->first('post.title') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">商品説明</label></label>
                            <textarea class="form-control" name='post[body]'>{{ $post->body }}</textarea>
                            <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">値段</label>
                            <input type="number" class="form-control" name="post[price]" value="{{ $post->price }}"/>
                            <p class="price__error" style="color:red">{{ $errors->first('post.price') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">数量</label>
                            <input type="number" class="form-control" name="post[quantity]" value="{{ $post->quantity }}"/>
                            <p class="quantity__error" style="color:red">{{ $errors->first('post.quantity') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">期限</label>
                            <input type="datetime-local" class="form-control" name="post[limit]" value="{{ $post->limit }}"/>
                            <p class="limit__error" style="color:red">{{ $errors->first('post.limit') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">商品画像</label>
                            <input type="file" name="image" value="{{ $post->image_path }}">
                            <p class="image__error" style="color:red">{{ $errors->first('post.image') }}</p>
                        </div>
                        
                        <input type="submit" value="保存">
                        
                        <a href="/posts/{{ $post->id }}">戻る</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection