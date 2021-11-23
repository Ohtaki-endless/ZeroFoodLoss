@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <!--フラッシュメッセージ-->
            @if (session('flash_message'))
                <div class="alert alert-primary" role="alert">
                    {{ session('flash_message') }}
                </div>
            @endif
                
            <div class="card">
                <div class="card-header h5">
                    ユーザー登録内容の変更
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="h5">
                            ユーザー名
                        </label>
                        <div class="card-text h5 font-weight-bold">
                            {{ $user->name }}
                        </div>
                        <a href="{{ route('user.edit', 'name') }}" class="card-link btn btn-primary btn-sm">
                            編集
                        </a>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="email" class="h5">
                            メールアドレス
                        </label>
                        <div class="card-text h5 font-weight-bold">
                            {{ $user->email }}
                        </div>
                        <p>
                            ※ Googleログインをご利用の方は変更しないでください
                        </p>
                        <a href="{{ route('user.edit', 'email') }}" class="card-link btn btn-primary btn-sm">
                            編集
                        </a>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="password" class="h5">
                            パスワード
                        </label>
                        <div class="card-text">
                            安全のため非表示です
                        </div>
                        <a href="{{ route('user.edit', 'password') }}" class="card-link btn btn-primary btn-sm">
                            編集
                        </a>
                    </div>
                </div>
                
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