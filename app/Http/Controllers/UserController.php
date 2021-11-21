<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    
    // マイページ表示
    public function index()
    {
        return view('user.index');
    }
    
    // いいねした商品一覧表示
    public function likes()
    {
        $user = Auth::user();
        $user->load('likes');
        return view('user.likes', compact('user'));
    }
    
    // 商品予約の履歴
    public function OrderHistory()
    {
        $user = Auth::user();
        $user->load('orders.orderdetails.post');
        return view('user.OrderHistory', compact('user'));
    }
    
    // ユーザー登録情報の変更画面表示
    public function edit() 
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }
    
    //ユーザー登録情報変更の保存処理
    public function update(Request $request) 
    {
        // 入力情報取得
        $user_form = $request->all();
        $user = Auth::user();
        
        //不要な「_token」の削除
        unset($user_form['_token']);
        //保存
        $user->fill($user_form)->save();
        return redirect('user/index');
    }
}
