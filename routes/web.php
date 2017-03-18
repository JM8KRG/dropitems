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

Route::get('/test', function () {
    return view('home');
});

// 会員登録
Route::get('register', 'Sentinel\RegisterController@index');
Route::post('register', 'Sentinel\RegisterController@store');

// 認証
Route::get('login', 'Sentinel\LoginController@index');
Route::post('login', 'Sentinel\LoginController@login');
Route::get('logout', 'Sentinel\LoginController@logout');

// ホーム
Route::get('/', 'HomeController@index');
