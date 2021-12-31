<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function orderdetails()
    {
        return $this->hasMany('App\OrderDetail');
    }
    
    // 商品予約処理
    public function CartStore($request){
        $cartData = $request->session()->get('cartData');
        $now = Carbon::now();
        
        $order = new \App\Order;
        $order->user_id = Auth::user()->id;
        $order->total_price = $request->total_price;
        $order->order_date = $now;
        $order->order_number = rand();
        //認証済みのユーザーのみオブジェクトへ保存
        Auth::user()->orders()->save($order);

        //Qrderテーブルの カラム「order_number」が「$order->order_number」の値を取得
        $savedOrder = Order::where('order_number', $order->order_number)->get();
        //上記Collectionから id の値だけを取得した配列に変換
        $savedOrderId = $savedOrder->pluck('id')->toArray();

        //注文詳細情報保存を注文数分繰り返す １回のリクエストを複数カラムに分けDB登録
        foreach ($cartData as $data) {
            //注文詳細情報に関わるオブジェクト生成
            $orderDetail = new \App\OrderDetail;
            $orderDetail->product_id = $data['session_products_id'];
            $orderDetail->order_id = $savedOrderId[0];
            $orderDetail->order_quantity = $data['session_quantity'];
            $orderDetail->save();
        }
        return $order;
    }
}
