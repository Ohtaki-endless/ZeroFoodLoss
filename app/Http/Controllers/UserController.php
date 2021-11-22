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
    
    // ユーザー登録情報の表示画面
    public function edit() 
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }
    
    public function EditName() 
    {
        $user = Auth::user();
        return view('user.EditName', compact('user'));
    }
    
    public function EditEmail() 
    {
        $user = Auth::user();
        return view('user.EditEmail', compact('user'));
    }
    
    public function EditPassword() 
    {
        $user = Auth::user();
        return view('user.EditPassword', compact('user'));
    }
    
    // public function EditUser($page) 
    // {
    //     $user = Auth::user();
    //     return view('user.EditPassword', compact('user'));
    // }
    
    
    //ユーザー登録情報変更の保存処理
    public function UpdateName(Request $request) 
    {
        // 入力情報取得
        $form = $request['user'];
        $user = Auth::user();
        
        //保存
        $user->fill($form)->save();
        return redirect('user/edit');
    }
    
    public function UpdateEmail(Request $request) 
    {
        // 入力情報取得
        $form = $request['user'];
        $user = Auth::user();
        
        //保存
        $user->fill($form)->save();
        return redirect('user/edit');
    }
    
    // public function UpdatePassword(Request $request) 
    // {
    //     // 入力情報取得
    //     $form = $request['user'];
    //     $user = Auth::user();
        
    //     //保存
    //     $user->fill($form)->save();
    //     return redirect('user/edit');
    // }
}
