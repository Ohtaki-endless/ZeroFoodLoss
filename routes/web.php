<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// 商品一覧
Route::get('/', 'PostController@index');
Route::get('/order/{order}', 'PostController@order')->name('order');

// 管理者のみアクセス可 (商品の新規投稿、編集。削除)
Route::middleware(['auth','can:isAdmin'])->group(function()
    {
        Route::get('/posts/create', 'PostController@create');
        Route::get('/posts/{post}/role', 'PostController@role');
        Route::get('/posts/{post}/edit', 'PostController@edit');
        Route::put('/posts/{post}', 'PostController@update');
        Route::delete('/posts/{post}', 'PostController@delete');
        Route::post('/posts', 'PostController@store');
    });
    

Route::group(['middleware' => 'auth'], function()
    {  
        // マイページ
        Route::get('/user/index', 'UserController@index');
        Route::get('/user/edit', 'UserController@UserEdit');
        Route::get('/user/edit/{page}', 'UserController@edit')->name('user.edit');
        Route::put('/user/edit/{page}', 'UserController@update');
        Route::get('/user/likes', 'UserController@likes');
        Route::get('/user/order-history', 'UserController@OrderHistory');
        
        // カート機能
        Route::get('/cartindex','ProductController@Cartindex');
        Route::post('/cartindex/store', 'ProductController@store');
        Route::post('/cartindex/{post}/remove', 'ProductController@remove');
        Route::post('/posts/{post}/addCart','ProductController@addCart');
        
        // 商品詳細画面
        Route::get('/posts/{post}', 'PostController@show');
        
        // コメント機能
        Route::post('/{post}/comments', 'CommentController@store');
        Route::delete('/{comment}/comments', 'CommentController@delete');
        
        // いいね機能
        Route::get('/posts/{post}/favorites', 'LikeController@store');
        Route::get('/posts/{post}/unfavorites', 'LikeController@destroy');
        Route::get('/posts/{post}/countfavorites', 'LikeController@count');
        Route::get('/posts/{post}/hasfavorites', 'LikeController@hasfavorite');
        
        Route::get('/posts/{post}/likesusers', 'LikeController@likeusers');
    });

// Google Login
Route::get('login/google', 'Auth\LoginController@redirectToGoogle');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');
