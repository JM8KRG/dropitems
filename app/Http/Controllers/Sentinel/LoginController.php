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
    protected $redirectTo = '/';

    function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->getMessages());
        }

        $credentials = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        // 認証
        Sentinel::authenticate($credentials);

        // 認証成功
        if (Sentinel::check()) {
            return redirect($this->redirectTo);
        }

        return redirect()->back()->withErrors('ログインできませんでした。');
    }

    public function logout()
    {
        Sentinel::logout();

        return redirect($this->redirectTo);
    }
}
