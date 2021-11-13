<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    
    // マイページ
    public function mypage()
    {
        return view('mypage');
    } 
    
    public function OrderHistory()
    {
        $user = Auth::user();
        $user->load('orders.orderdetails.post');
        
        return view('OrderHistory', compact('user'));
    }
    
    //userデータの取得
    public function index() {
        return view('user.index', ['user' => Auth::user() ]);
    }
    
    //userデータの編集
    public function edit() {
        return view('user.edit', ['user' => Auth::user() ]);
    }
    
    //userデータの保存
    public function update(Request $request) {

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
