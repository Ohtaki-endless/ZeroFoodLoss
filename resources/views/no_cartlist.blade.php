@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <!--フラッシュメッセージ-->
            @if (session('flash_message'))
                <div class="alert alert-danger" role="alert">
                    {{ session('flash_message') }}
                </div>
            @endif
            
            <div class="card">
                <h5 class="card-header">
                    カート内容
                </h5>
                <div class="card-body">
                    カート内に商品はありません
                </div>
                <div class="card-body">
                    <a href="/" class="card-link">
                        戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection