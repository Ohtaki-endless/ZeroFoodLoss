@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h5">
                    商品予約履歴
                </div>
                
                @if(empty($user->orders[0]))
                    <div class="card-body">商品予約履歴はありません</div>
                @else
                
                <div class="card-body mx-auto">
                    @foreach ($user->orders as $order)
                    <div class="card">
                        <h5 class="card-header">
                            予約受付日：{{ $order->order_date }}
                        </h5>
                        <div class="card-body">
                            <p>
                                予約番号：{{ $order->order_number }}<br>
                            </p>
                            <h5>
                                合計金額：{{ number_format($order->total_price) }} 円
                            </h5>
                        </div>
                            @foreach ($order->orderdetails as $orderdetail)
                                <div class="card-body row pt-2 pb-2">
                                    <div class="col-xs-4 pl-2">
                                        <img src="{{ $orderdetail->post->image_path }}" width="150" height="150">
                                    </div>
                                    <div class="col-xs-8 pl-3">
                                        <h5 class="pt-2">
                                            {{ $orderdetail->post->title }}
                                        </h5>
                                        <p>
                                            ¥ {{ $orderdetail->post->price }} × {{ $orderdetail->order_quantity }}個
                                        </p>
                                        <p>
                                            小計 ¥ {{ $orderdetail->post->price * $orderdetail->order_quantity }}円
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                    </div>
                    @endforeach
                </div>
                @endif
                
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