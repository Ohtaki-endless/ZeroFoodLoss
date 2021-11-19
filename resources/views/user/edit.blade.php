@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ユーザー登録内容の変更</div>
                <div class="card-body">
                    <form method="POST" action="/user/edit">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name">ユーザー名</label>
                            <div>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">メールアドレス</label>
                            <div>
                                <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                            </div>
                        </div>
                        
                        <input type="submit" value="変更">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection