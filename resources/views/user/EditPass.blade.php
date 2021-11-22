@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h5">
                    パスワードの変更
                </div>
                
                <div class="card-body">
                    <form action="/user/edit/name" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="h5">
                                パスワード
                            </label>
                            <input type="text" value="{{ $user->email }}" class="form-control">
                        </div>
                        <input type="submit" value="変更" class="btn btn-primary">
                    </form>
                </div>
                
                <div class="card-body">
                    <a href="/user/edit" class="card-link btn btn-outline-secondary">
                        戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection