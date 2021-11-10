@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">新規投稿</div>

                <div class="card-body">
                    <form action="/posts" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">商品名</label>
                            <input type="text" class="form-control" name="post[title]" placeholder="商品名" value="{{ old('post.title') }}"/>
                            <p class="title__error" style="color:red">{{ $errors->first('post.title') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">商品説明</label>
                            <textarea class="form-control" name="post[body]" placeholder="商品説明">{{ old('post.body') }}</textarea>
                            <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">値段</label>
                            <input type="number" class="form-control" name="post[price]" placeholder="値段" value="{{ old('post.price') }}"/>
                            <p class="price__error" style="color:red">{{ $errors->first('post.price') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">数量</label>
                            <input type="number" class="form-control" name="post[quantity]" placeholder="数量" value="{{ old('post.quantity') }}"/>
                            <p class="quantity__error" style="color:red">{{ $errors->first('post.quantity') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">期限</label>
                            <input type="datetime-local" class="form-control" name="post[limit]" placeholder="期限" value="{{ old('post.limit') }}"/>
                            <p class="limit__error" style="color:red">{{ $errors->first('post.limit') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">商品画像</label>
                            <input type="file" name="image">
                            <p class="image__error" style="color:red">{{ $errors->first('post.image') }}</p>
                        </div>    
                        
                        <input type="submit" value="投稿">
                        
                        <a href="/">戻る</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection