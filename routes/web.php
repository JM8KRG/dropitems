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

// アイテム
Route::get('items/detail/{item_id}', 'Items\ItemController@index');
// 受け取り申請
Route::post('items/order', 'Items\ItemController@store');

// カテゴリー
Route::get('category/{category_id}', 'Items\ItemController@showCategoryItems');

// アイテムアップロード
Route::get('upload', 'User\ItemUploader@index');
Route::post('upload', 'User\ItemUploader@store');
Route::post('upload/images', 'User\ItemUploader@uploadImages');

// アイテム管理
Route::get('items/my', 'User\UserItemController@index');
Route::get('items/update/status/{item_id}', 'User\UserItemController@updateItemStatus');
Route::get('items/delete/{item_id}', 'User\UserItemController@destroyItem');

// 取引管理
Route::get('trade', 'User\UserTransactionController@index');
Route::get('trade/close/{item_id}', 'User\UserTransactionController@closeTrade');

// 取引メッセージ
Route::get('messages/t/{item_id}', 'User\UserMessageController@index');
Route::post('messages/update', 'User\UserMessageController@store');

// ライセンス情報
Route::get('license', function() {
    return view('others.license');
});