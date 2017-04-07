<?php

namespace DropItems\Http\Controllers\Settings;

use Illuminate\Http\Request;
use DropItems\Http\Controllers\Controller;

/**
 * Class AccountController
 * @package DropItems\Http\Controllers\Settings
 */

class AccountController extends Controller
{
    protected $user;

    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // ユーザーのメールアドレスを取得
        $email = \Sentinel::getUser()->email;

        return view('settings.account', ['email' => $email]);
    }

    /**
     * メールアドレスを更新
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEmail(Request $request)
    {
        // バリデーション
        $validator = \Validator::make($request->all(), [
            'email'     => 'required|email|unique:users',
            'password'  => 'required',
        ]);

        // バリデーション失敗
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->getMessages());
        }

        $credentials = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        $this->user = \Sentinel::getUser();

        if (\Sentinel::getUserRepository()->validateCredentials($this->user, $credentials)) {
            \Sentinel::getUserRepository()->update($this->user, $credentials);
            return redirect()->back()->with('success', 'メールアドレスを更新しました。');
        }

        return redirect()->back()->withErrors('パスワードが間違っています。');
    }

    /**
     * パスワードを更新
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        // バリデーション
        $validator = \Validator::make($request->all(), [
           'old_password'   => 'required',
           'password'       => 'required|between:8,255|confirmed',
        ]);

        // バリデーション失敗
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->getMessages());
        }

        // 古いパスワード
        $credentials = [
            'password' => $request->input('old_password'),
        ];

        // ユーザーを取得
        $this->user = \Sentinel::getUser();

        // 検証
        if (\Sentinel::getUserRepository()->validateCredentials($this->user, $credentials)) {
            // パスワード更新
            \Sentinel::getUserRepository()->update($this->user, ['password' => $request->input('password')]);

            return redirect()->back()->with('success', 'パスワードを更新しました。');
        }

        return redirect()->back()->withErrors('パスワードが間違っています。');
    }

    /**
     * パスワードを削除
     */
    public function destroy(Request $request)
    {

    }
}
