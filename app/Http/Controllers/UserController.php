<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    
    // マイページ表示
    public function index()
    {
        return view('user.index');
    }
    
    public function index1()
    {
        $user = Auth::user();
        $user->where('id', $user->id)->update(['role' => 1]);
        return back();
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
    
    // ユーザー登録情報の一覧表示
    public function UserEdit() 
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }
    
    
    // ユーザー登録情報の個別表示（name, email, pass)
    public function edit($page) 
    {
        $user = Auth::user();
        return view('user.editItem', compact('user', 'page'));
    }
    
    // ユーザー登録情報の更新処理
    public function update(Request $request, $page) 
    {
        // バリデーション選択
        if ($page == 'name'){
            $rule = User::$editNameRules;
            $page = 'ユーザー名';
        } elseif ($page == 'email'){
            $rule = User::$editEmailRules;
            $page = 'メールアドレス';
        } elseif ($page == 'password'){
            $rule = User::$editPasswordRules;
            $page = 'パスワード';
        }
        // バリデーションチェック
        $this->validate($request, $rule);
        
        // 入力情報取得
        $form = $request->all();
        $user = Auth::user();
        // フォームトークン削除
        unset($form['_token']);
        
        // パスワードのチェック処理
        if (isset($form['password'])) {
            
            // 旧パスワードのチェック
            $passcheck = Hash::check($form['old_password'], $user->password);
            $validator = Validator::make(
                ['old_password' => $passcheck],
                ['old_password' => 'accepted'],
                ['現在のパスワードが一致しません']
            );
            
            // 旧パスワードが一致しない場合リダイレクト
            if ($validator->fails()) {
                return redirect('user/edit/password')
                    ->withErrors($validator)
                    ->withInput();
            }
            
            // 新パスワードをハッシュ化
            $form['password'] = Hash::make($form['password']);
        }
        //入力情報の保存
        $user->fill($form)->save();
        
        // フラッシュメッセージの追加
        session()->flash('flash_message', $page.'の変更が完了しました！');
        
        return redirect('user/edit');
    }

}
