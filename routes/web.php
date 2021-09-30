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



// 投稿一覧画面
Route::get('/', 'PostController@index');
// 新規投稿画面
Route::get('/posts/create', 'PostController@create');
// 編集画面
Route::get('/posts/{post}/edit', 'PostController@edit');
// 詳細画面
Route::get('/posts/{post}', 'PostController@show');
// 編集実行
Route::put('/posts/{post}', 'PostController@update');
// 新規投稿実行
Route::post('/posts', 'PostController@store');
// 削除実行
Route::delete('/posts/{post}', 'PostController@delete');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');