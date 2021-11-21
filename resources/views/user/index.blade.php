@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header h5">
                    マイページメニュー
                </div>
                
                <div class="card-body">
                    <div class="card-deck">
                        <div class="card">
                            <a href="/user/order-history" class="card-body text-center text-decoration-none h5">
                                商品予約の履歴
                            </a>
                        </div>
                        <div class="card">
                            <a href="/user/likes" class="card-body text-center text-decoration-none h5">
                                いいねした商品一覧
                            </a>
                        </div>
                        <div class="card">
                            <a href="/user/edit" class="card-body text-center text-decoration-none h5">
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