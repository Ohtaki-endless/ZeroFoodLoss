@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">カート内容</h5>
                <table class="table mt-5 ml-3 border-dark">
                    
                    <thead>
                        <tr class="text-center">
                            <th class="border-bottom border-dark">No</th>
                            <th class="border-bottom border-dark">商品名</th>
                            <th class="border-bottom border-dark">値段</th>
                            <th class="border-bottom border-dark">個数</th>
                            <th class="border-bottom border-dark">小計</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($cartData as $key => $data)
                            <tr class="text-center">
                                <th class="align-middle">{{ $key += 1 }}</th>
                                <td class="align-middle">
                                    {{ $data['product_name'] }}
                                </td>
                                <td class="align-middle">
                                    ¥{{ number_format($data['price']) }} 円
                                </td>
                                <td class="align-middle">
                                    {{ $data['session_quantity'] }}個
                                </td>
                                <td class="align-middle">
                                    ¥{{ number_format($data['session_quantity'] * $data['price']) }}円
                                </td>
                            </tr>
                        @endforeach

                        <tr class="text-center">
                            <th class="border-bottom-0 align-middle"></th>
                            <td class="border-bottom-0 align-middle"></td>
                            <td class="border-bottom-0 align-middle"></td>
                            <td class="border-bottom-0 align-middle">合計</td>
                                <td class="border-bottom-0 align-middle">
                                ¥{{ $totalPrice }}円
                                </td>
                        </tr>

                        <tr class="text-center">
                            <th class="border-0"></th>
                            <td class="border-0">
                                <a class="btn btn-success" href="/" role="button">
                                    買い物を続ける
                                </a>
                            </td>
                            <td class="border-0"></td>
                            <td class="border-0"></td>
                            <td class="border-0">
                                <button>確定ボタン</button>
                            </td>
                            <td class="border-0 align-middle"></td>
                        </tr>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</div>
@endsection