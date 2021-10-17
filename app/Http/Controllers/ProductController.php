<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;

class ProductController extends Controller
{
    public function addCart(Request $request)
    {
        
        //変数の初期化
        $cartData = [];
        
        //商品詳細画面のhidden属性で送信（Request）された商品IDと注文個数を取得し配列として変数に格納
        $cartData = [
            'session_products_id' => $request->products_id, 
            'session_quantity' => $request->product_quantity, 
        ];
        
        //sessionにcartData配列が「ない」場合$cartDataをsessionに追加
        //（カート内が空なら商品を追加する）
        if (!$request->session()->has('cartData')) {
            $request->session()->push('cartData', $cartData);
            
        } else {
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
        
        dd($request);
        
        
    }
}