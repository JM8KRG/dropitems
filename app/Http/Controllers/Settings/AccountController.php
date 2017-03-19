<?php

namespace DropItems\Http\Controllers\Settings;

use Illuminate\Http\Request;
use DropItems\Http\Controllers\Controller;

class AccountController extends Controller
{
    protected $user;

    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $email = \Sentinel::getUser()->getUserEmail();

        return view('settings.account', ['email' => $email]);
    }

    public function updateEmail(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email'     => 'required|email|unique:users',
            'password'  => 'required',
        ]);

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

    public function updatePassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
           'old_password'   => 'required',
           'password'       => 'required|between:8,255|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->getMessages());
        }

        $credentials = [
            'password' => $request->input('old_password'),
        ];

        $this->user = \Sentinel::getUser();

        if (\Sentinel::getUserRepository()->validateCredentials($this->user, $credentials)) {
            // パスワード更新
            \Sentinel::getUserRepository()->update($this->user, ['password' => $request->input('password')]);

            return redirect()->back()->with('success', 'パスワードを更新しました。');
        }

        return redirect()->back()->withErrors('パスワードが間違っています。');
    }

    public function destroy()
    {

    }
}
