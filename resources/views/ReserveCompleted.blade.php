@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-body">
                    <h5>商品の予約が完了しました！</h5>
                </div>
                <div class="card-body">
                    <h3>予約番号:{{ $order->order_number }}</h3>
                </div>
                <div class="card-body">
                    <p>
                        予約詳細情報は、ご登録のメールアドレスに送信しました。
                        ご確認の上、店舗までお越し下さい。
                    </p>
                </div>
                <div class="card-body">
                    <a href="/" class="btn btn-success">
                        商品一覧へ戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection