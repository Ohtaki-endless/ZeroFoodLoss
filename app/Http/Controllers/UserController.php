<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    
    // マイページ
    public function index()
    {
        return view('user.index');
    } 
    
    // 商品予約の履歴
    public function OrderHistory()
    {
        $user = Auth::user();
        $user->load('orders.orderdetails.post');
        return view('user.OrderHistory', compact('user'));
    }
    
    // ユーザー登録情報変更画面
    public function edit() 
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }
    
    //userデータの保存
    public function update(Request $request) 
    {
        $user_form = $request->all();
        $user = Auth::user();
        //不要な「_token」の削除
        unset($user_form['_token']);
        //保存
        $user->fill($user_form)->save();
        //リダイレクト
        return redirect('user/index');
    }
}
