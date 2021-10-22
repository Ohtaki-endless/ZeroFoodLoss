<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Post;

class ProductController extends Controller
{
    // 商品詳細からセッション情報保存
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
        return back();
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
        //session情報の取得
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
}