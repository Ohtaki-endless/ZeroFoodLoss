@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h5">
                    ユーザー登録内容の変更
                </div>
                
                <div class="card-body">
                    <form method="POST" action="/user/edit">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name" class="h5">ユーザー名</label>
                            <div>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="h5">メールアドレス</label>
                            <div>
                                <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                            </div>
                        </div>
                        
                        <input class="btn btn-primary rounded-pill" type="submit" value="変更">
                    </form>
                </div>
                
                <div class="card-body">
                    <a href="/user/index" class="card-link btn btn-outline-secondary">
                        変更せずに戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection