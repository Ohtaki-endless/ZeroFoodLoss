@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ログインしました！</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="text-center">
                        <a href="/" class="btn-lg card-link btn btn btn-outline-secondary rounded-pill">商品一覧へ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
