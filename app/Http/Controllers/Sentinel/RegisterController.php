<?php

namespace DropItems\Http\Controllers\Sentinel;

use Sentinel;
use Illuminate\Http\Request;
use DropItems\Http\Controllers\Controller;

/**
 * Class RegisterController
 * @package DropItems\Http\Controllers\Sentinel
 */

class RegisterController extends Controller
{
    protected $redirectTo = '/';

    function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 会員登録ページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * 会員登録
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'screen_name'           =>  'required|max:255',
            'email'                 =>  'required|max:255|email|unique:users',
            'password'              =>  'required|between:8,255|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->getMessages());
        }

        $credentials = [
            'screen_name'   => $request->input('screen_name'),
            'email'         => $request->input('email'),
            'password'      => $request->input('password'),
        ];

        // 会員登録
        Sentinel::registerAndActivate($credentials);

        // ログイン
        Sentinel::authenticate($credentials);

        return redirect($this->redirectTo);
    }
}
