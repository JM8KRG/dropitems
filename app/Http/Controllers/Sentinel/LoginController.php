<?php

namespace DropItems\Http\Controllers\Sentinel;

use Sentinel;
use Illuminate\Http\Request;
use DropItems\Http\Controllers\Controller;

/**
 * Class LoginController
 * @package DropItems\Http\Controllers\Sentinel
 */

class LoginController extends Controller
{
    function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * ログイン
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'id'        => 'required',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->getMessages());
        }

        $credentials = [
            'login'     => $request->input('id'),
            'password'  => $request->input('password'),
        ];

        // 認証
        Sentinel::authenticate($credentials, $request->has('remember'));

        // 認証成功
        if (Sentinel::check()) {
            return redirect()->action('HomeController@index')->with('success', 'ログインに成功しました。');
        }

        return redirect()->back()->withErrors('ログインできませんでした。');
    }

    /**
     * ログアウト
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Sentinel::logout();

        return redirect()->action('Sentinel\LoginController@index');
    }
}
