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

// プロフィール設定
Route::get('settings', 'Settings\ProfileController@index');
Route::post('settings/username', 'Settings\ProfileController@updateScreenName');
Route::post('settings/profile', 'Settings\ProfileController@updateProfile');

// アカウント設定
Route::get('settings/account', 'Settings\AccountController@index');
Route::post('settings/account/email', 'Settings\AccountController@updateEmail');
Route::post('settings/account/password', 'Settings\AccountController@updatePassword');

// アイテムアップロード
Route::get('upload', 'User\ItemUploader@index');
Route::post('upload', 'User\ItemUploader@store');

// ライセンス情報
Route::get('license', function() {
    return view('others.license');
});