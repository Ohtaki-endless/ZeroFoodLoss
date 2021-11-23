@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h5">
                    ユーザー名の変更
                </div>
                
                <div class="card-body">
                    <form action="/user/edit/{{ $page }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        @if($page == 'name')
                        <div class="form-group">
                            <label for="exampleFormControlInput1" class="h5">
                                ユーザー名
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}" name="name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @endif
                        
                        @if($page == 'email')
                        <div class="form-group">
                            <label for="exampleFormControlInput1" class="h5">
                                メールアドレス
                            </label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}" name="email">
                            <p>
                                ※ Googleログインをご利用の方は変更しないでください。
                            </p>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @endif
                        
                        @if($page == 'password')
                        <div class="form-group">
                            <label for="exampleFormControlInput1" class="h5">
                                現在のパスワード
                            </label>
                            <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password">
                            @error('old_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                            <label for="exampleFormControlInput1" class="h5">
                                新しいパスワード
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                            <label for="exampleFormControlInput1" class="h5">
                                新しいパスワード（確認用）
                            </label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @endif
                        
                        <input type="submit" value="変更" class="btn btn-primary">
                    </form>
                </div>
                
                <div class="card-body">
                    <a href="/user/edit" class="card-link btn btn-outline-secondary">
                        変更せずに戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection