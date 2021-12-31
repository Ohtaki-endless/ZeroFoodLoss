<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Order;
use App\OrderDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Thanks;

class ProductController extends Controller
{
    // 商品詳細からカートに追加
    public function addCart(Request $request, Post $post)
    {
        $cartData = [];
        //送信された情報を取得
        $cartData = [
            'session_products_id' => $post->id, 
            'session_quantity' => $request->product_quantity, 
            'product_name' => $post->title,
            'price' => $post->price,
            'product_image' => $post->image_path,
        ];
        
        // DBの商品個数更新
        $post = Post::find($cartData['session_products_id']);
        $quantity_result = $post->quantity - $cartData['session_quantity'];
        $post->where('id', $cartData['session_products_id'])->update(['quantity' => $quantity_result]);
        
        // ロールの更新
        if($quantity_result == 0){
            $post->where('id', $cartData['session_products_id'])->update(['role' => 10]);
        }
        
        // カートへの商品追加処理
        $post->AddCart($cartData, $request);
        
        // フラッシュメッセージの追加
        session()->flash('flash_message', 'カートに商品を追加しました！');
        return redirect('/cartindex');
    }
    
    
    
    // カート内商品表示
    public function Cartindex(Request $request)
    {
        if ($request->session()->has('cartData')) {
            $cartData = array_values($request->session()->get('cartData'));
        }
        
        if (!empty($cartData)) {
            foreach ($cartData as $index => &$data) {
                //商品小計
                $data['itemPrice'] = $data['price'] * $data['session_quantity'];
            }
            unset($data);
            
            // 合計金額の計算
            $totalPrice = array_sum(array_column($cartData, 'itemPrice'));
        
            return view('cartlist', compact('cartData', 'totalPrice'));
        } else {
            return view('no_cartlist');
        }
    }
    
    
    
    // カート商品削除
    public function remove(Request $request, Post $post)
    {
        // カート商品削除処理
        $post->RemoveCart($request);
        
        // session再取得
        $cartData = $request->session()->get('cartData');
        
        // フラッシュメッセージの追加
        session()->flash('flash_message', 'カートから商品を削除しました！');
        
        //session情報があればtrue
        if ($request->session()->has('cartData')) {
            return redirect('/cartindex');
        }
        
        return view('no_cartlist', ['user' => Auth::user()]);
    }
    
    
    
    // 購入予約確定
    public function store(Request $request, Order $order)
    {
        // 予約処理
        $order = $order->CartStore($request);
        
        //session削除
        $request->session()->forget('cartData');

        // メール送信処理
        $order->load('orderdetails.post');
        $user = Auth::user();
        $mail_data['user'] = $user->name;
        $mail_data['order'] = $order;
        Mail::to($user->email)->send(new Thanks($mail_data));
        Mail::to(config('mail.username'))->send(new Thanks($mail_data));
        
        return view('ReserveCompleted', compact('order'));
    }
}