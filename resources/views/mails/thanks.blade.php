@component('mail::message')

{{ $user }}様<br>

この度はご購入予約ありがとうございます。<br>

予約番号は、「{{ $order->order_number }}」です。
ご来店時にこちらのメールを提示するか、予約番号をお伝え下さい。

お客様が予約した商品は<br>

@foreach ($order->orderdetails as $orderdetail)
・{{ $orderdetail->post->title }} |
{{ number_format($orderdetail->post->price) }}円 |
{{ $orderdetail->order_quantity }}個 |
小計 ¥{{ number_format($orderdetail->post->price * $orderdetail->order_quantity) }}円
<br>
@endforeach

@php
    $totalPrice = 0;
    foreach ($order->orderdetails as $orderdetail){
        $totalPrice += ($orderdetail->post->price * $orderdetail->order_quantity);
    }
@endphp

合計 ¥{{ number_format($totalPrice) }} 円

となります。<br>

<br>
@endcomponent