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

// 投稿一覧、新規投稿、編集、投稿詳細、削除
Route::get('/', 'PostController@index');
Route::get('/posts/create', 'PostController@create');
Route::get('/posts/{post}/edit', 'PostController@edit');
Route::get('/posts/{post}', 'PostController@show')->middleware('auth');
Route::put('/posts/{post}', 'PostController@update');
Route::post('/posts', 'PostController@store');
Route::delete('/posts/{post}', 'PostController@delete');

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