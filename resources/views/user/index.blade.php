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
                            <a href="/user/order-history" class="abcd card-body text-center text-decoration-none">
                                商品予約の履歴
                            </a>
                        </div>
                        <div class="card">
                            <a href="" class="abcd card-body text-center text-decoration-none">
                                いいねした商品一覧
                            </a>
                        </div>
                        <div class="card">
                            <a href="/user/edit" class="abcd card-body text-center text-decoration-none">
                                ユーザー登録情報の変更
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection