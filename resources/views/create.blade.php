@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">新規投稿</div>

                <div class="card-body">
                    <form action="/posts" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">タイトル</label>
                            <input type="text" class="form-control" name="post[title]" placeholder="タイトル" value="{{ old('post.title') }}"/>
                            <p class="title__error" style="color:red">{{ $errors->first('post.title') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">本文</label>
                            <textarea class="form-control" name="post[body]" placeholder="今日も1日お疲れさまでした。">{{ old('post.body') }}</textarea>
                            <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
                        </div>
                        
                        <input type="submit" value="保存">
                        
                        <a href="/">戻る</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection