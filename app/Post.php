<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    use SoftDeletes;
    // use Sortable; // 追加
    // public $sortable = ['id', 'access'];
    
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    
    public function users(){
        return $this->belongsToMany('App\User')->withTimestamps();
    }
    
    public function orderdetails(){
        return $this->hasMany('App\OrderDetail');
    }
    
    protected $fillable = [
        'title',
        'body',
        'price',
        'quantity',
        'limit'
    ];
    
    public function getPaginateByLimit(int $limit_count = 4)
    {
        // created_atで作成順に並べたあと、limitで件数制限をかける
        return $this->orderBy('created_at', 'DESC')->paginate($limit_count);
    }
    
    // アクセス数のカウント
    public function AccessCounter ($post)
    {
        // ページにアクセスするとaccessの値を１増やす
        $this->where('id', '=', $post)->increment('access');
    }
    
    
    public function order($order, int $limit_count = 4)
    {
        // ページの並べ替え処理
        if($order == 'access'){
            return $this->orderBy('access', 'desc')->paginate($limit_count);
        } else {
            return $this->orderBy('created_at', 'desc')->paginate($limit_count);
        }
    }
    
    // カートへの商品追加処理
    public function AddCart($cartData, $request){
        //sessionにcartData配列が「ない」場合$cartDataをsessionに追加（カート内が空なら商品を追加する）
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
                    //cartDataをの個数を上書き処理
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
    }
    
    // カート内の商品削除処理
    public function RemoveCart($request){
        $sessionCartData = $request->session()->get('cartData');

        // 削除する商品IDの値を数値変換
        $id = (int)$request->product_id;

        foreach ($sessionCartData as $index => $sessionData) {
            if ($sessionData['session_products_id'] === $id ){
                // DBの商品個数更新
                $post = Post::find($sessionData['session_products_id']);
                $quantity_result = $post->quantity + $sessionData['session_quantity'];
                $post->where('id', $sessionData['session_products_id'])->update(['quantity' => $quantity_result]);
                // ロールの更新
                $post->where('id', $sessionData['session_products_id'])->update(['role' => 1]);
                
                // 該当商品のセッション情報削除
                $request->session()->forget('cartData.' . $index);
                break;
            }
        }
    }
}
