@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">カート内容</h5>
                
                <div class="card-body mx-auto">
                    @foreach ($cartData as $key => $data)
                    <div class="row pt-2 pb-2">
                        <div class="col-xs-4 pl-2">
                            <img src="{{ $data['product_image'] }}" width="150" height="150">
                        </div>
                        <div class="col-xs-8 pl-3">
                            <h5 class="pt-2">{{ $data['product_name'] }}</h5>
                            <p>¥{{ number_format($data['price']) }} × {{ $data['session_quantity'] }}個</p>
                            <h5>小計  ¥{{ number_format($data['session_quantity'] * $data['price']) }}円</h5>
                            
                            <form action="/cartindex/{{ $data['session_products_id'] }}/remove" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $data['session_products_id'] }}">
                                <input type="hidden" name="product_quantity" value="{{ $data['session_quantity'] }}">
                                <input type="submit" value="削除" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="d-flex flex-row mx-auto bg-light">
                    <div class="p-2 align-items-center justify-content-center">
                        <h4 class="my-1">合計</h4>
                    </div>
                    <div class="p-2 align-items-center justify-content-center">
                        <h4 class="my-1">¥ {{ number_format($totalPrice) }} 円</h4>
                    </div>
                </div>

                <div class="card-body mx-auto">
                    <div class="row">
                        <div class="col-xs-6 pl-4">
                            <a class="btn btn-success" href="/" role="button">
                                買い物を続ける
                            </a>
                        </div>
                        <div class="col-xs-6 pl-4">
                            <form action="/cartindex/store" method="POST" >
                                @csrf
                                <input type="submit" name="orderFinalize" value="予約を確定する" class="btn btn-primary">
                                <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection