@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    マイページメニュー
                </div>
                <div class="card-body">
                    <div class="card-deck">
                        <div class="card">
                            <a href="/user/{{ Auth::user()->id }}/order-history" class="abcd card-body text-center text-decoration-none">
                                商品予約の履歴
                            </a>
                        </div>
                        <div class="card">
                            <a href="/user/{{ Auth::user()->id }}/edit" class="abcd card-body text-center text-decoration-none">
                                登録情報の変更
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection