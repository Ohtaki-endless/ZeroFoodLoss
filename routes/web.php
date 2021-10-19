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

// 管理者のみアクセス可(新規投稿、編集。削除)
Route::middleware(['auth','can:isAdmin'])->group(function(){
        Route::get('/posts/create', 'PostController@create');
        Route::get('/posts/{post}/edit', 'PostController@edit');
        Route::put('/posts/{post}', 'PostController@update');
        Route::delete('/posts/{post}', 'PostController@delete');
        Route::post('/posts', 'PostController@store');
    });
    
Route::get('/posts/cartindex','ProductController@Cartindex');
// 投稿一覧、投稿詳細
Route::get('/', 'PostController@index');
Route::get('/posts/{post}', 'PostController@show')->middleware('auth');

// コメント機能
Route::post('/{post}/comments', 'CommentController@store')->middleware('auth');
Route::delete('/{comment}/comments', 'CommentController@delete');

// いいね機能
Route::get('/{post}/likes', 'LikeController@like')->middleware('auth');
Route::get('/{post}/unlikes', 'LikeController@unlike')->middleware('auth');
Route::get('/{post}/likes/users', 'LikeController@likeusers');

// Google Login
Route::get('login/google', 'Auth\LoginController@redirectToGoogle');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');

// カート機能
Route::post('/posts/{post}/addCart','ProductController@addCart');