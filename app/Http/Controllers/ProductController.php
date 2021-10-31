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
    public function addCart(Request $request)
    {
        //変数の初期化
        $cartData = [];
        
        //商品詳細画面のhidden属性で送信された商品IDと注文個数を取得し配列として変数に格納
        $cartData = [
            'session_products_id' => $request->products_id, 
            'session_quantity' => $request->product_quantity, 
        ];
        
        //sessionにcartData配列が「ない」場合$cartDataをsessionに追加
        //（カート内が空なら商品を追加する）
        if (!$request->session()->has('cartData')) {
            $request->session()->push('cartData', $cartData);
            
        } else {
            // カート内に商品が「ある」場合の処理
            //sessionにcartData配列が「ある」場合、情報取得
            $sessionCartData = $request->session()->get('cartData');
            
            //product_id同一確認のフラグを指定（「false」は同一ではない状態）
            $isSameProductId = false;
            
            foreach ($sessionCartData as $index => $sessionData) {
                //product_idが同一であれば、フラグをtrueにする → 個数の合算処理、セッション情報更新。更新は一度のみ
                //（カートには商品があり、かつ追加しようとしている商品のIDがカート内商品と同じ場合の処理）
                if ($sessionData['session_products_id'] === $cartData['session_products_id'] ) {
                    $isSameProductId = true;
                    $quantity = $sessionData['session_quantity'] + $cartData['session_quantity'];
                    //cartDataをrootとしたツリー状の多次元連想配列の特定のValueにアクセスし、指定の変数でValueの上書き処理
                    $request->session()->put('cartData.' . $index . '.session_quantity', $quantity);
                    break;
                }
            }
            //product_idが同一ではない場合、pushする
            //（カートには商品があり、かつ追加しようとしている商品のIDがカート内商品と異なる場合の処理）
            if ($isSameProductId === false) {
                $request->session()->push('cartData', $cartData);
            }
        }
        $request->session()->put('users_id', ($request->users_id));
        
        return redirect('/cartindex');
    }
    
    
    
    // カート内商品表示
    public function Cartindex(Request $request)
    {
        //渡されたセッション情報をkey（名前）を用いそれぞれ取得、変数に代入
        $sessionUser = User::find($request->session()->get('users_id'));

        if ($request->session()->has('cartData')) {
            $cartData = array_values($request->session()->get('cartData'));
        }
        
        if (!empty($cartData)) {
            // 商品IDのみ配列に代入
            $sessionProductsId = array_column($cartData, 'session_products_id');
            // 配列の商品IDを「,」で連結する
            $sessionProductsId_order = implode(',', $sessionProductsId);
            
            // postsテーブルから商品IDのデータを取得する。しかし昇順に取得するため、「orderByRaw」で商品を追加した順に並び替える
            // FIELDメソッドは、第一引数に並び替え対象のカラム、第二引数に並び替えたい順番を書く
            $product = Post::whereIn('id', $sessionProductsId)->orderByRaw("FIELD(id, $sessionProductsId_order)")->get();
            
            foreach ($cartData as $index => &$data) {
                //二次元目の配列を指定している$dataに'product〜'key生成 Modelオブジェクト内の各カラムを代入
                //＆で参照渡し 仮引数($data)の変更で実引数($cartData)を更新する
                $data['product_name'] = $product[$index]->title;
                $data['price'] = $product[$index]->price;
                $data['product_image'] = $product[$index]->image_path;
                //商品小計
                $data['itemPrice'] = $data['price'] * $data['session_quantity'];
            }
            unset($data);
            // 合計金額の計算
            $totalPrice = number_format(array_sum(array_column($cartData, 'itemPrice')));

            return view('cartlist', compact('sessionUser', 'cartData', 'totalPrice'));
        } else {
            return view('no_cartlist');
        }
    }
    
    
    
    // カート商品削除
    public function remove(Request $request)
    {
        $sessionCartData = $request->session()->get('cartData');

        foreach ($sessionCartData as $index => $sessionData) {
            if ($sessionData['session_products_id'] === $request->product_id ){
                $request->session()->forget('cartData.' . $index);
                break;
            }
        }
        // session再取得
        $cartData = $request->session()->get('cartData');
        //session情報があればtrue
        if ($request->session()->has('cartData')) {
            return redirect('/cartindex');
        }

        return view('no_cartlist', ['user' => Auth::user()]);
    }
    
    
    // 購入予約確定
    public function store(Request $request , OrderDetail $orderdetail , Order $order)
    {
        $cartData = $request->session()->get('cartData');
        $now = Carbon::now();

        $order = new \App\Order;
        $order->user_id = Auth::user()->id;
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

        //session削除
        $request->session()->forget('cartData');

        // メール送信処理
        $order->load('orderdetails.post');
        $user = Auth::user();
        $mail_data['user']=$user->name;
        $mail_data['order']=$order;
        Mail::to($user->email)->send(new Thanks($mail_data));
        Mail::to(config('mail.username'))->send(new Thanks($mail_data));
        
        return view('ReserveCompleted', compact('order'));
    }
}