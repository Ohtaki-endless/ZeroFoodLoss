<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    
    public function likes(){
        return $this->belongsToMany('App\Post')->withTimestamps()->orderBy('created_at', 'asc');
    }
    
    public function orders(){
        return $this->hasMany('App\Order')->orderBy('created_at', 'desc');
    }
    
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // ユーザー登録情報変更のバリデーション
    public static $editNameRules = array(
        'name' => 'required|max:255|string'
    );

    public static $editEmailRules = array(
        'email' => 'required|string|email|max:255|unique:users'
    );

    public static $editPasswordRules = array(
        'password' => 'required|string|min:8|confirmed'
    );
    
}
