@component('mail::message')

{{ $user }}様<br>
この度はご購入予約ありがとうございます。<br>

お客様が購入した商品は<br>

@foreach ($order->orderdetails as $orderdetail)
・{{ $orderdetail->post->title }} | 
小計  ¥{{ number_format($orderdetail->post->price * $orderdetail->order_quantity) }}円
<br>
@endforeach

となります。<br>

<br>
{{ config('app.name') }}
@endcomponent