<?php

namespace DropItems\Http\Controllers\Settings;

use Illuminate\Http\Request;
use DropItems\Http\Controllers\Controller;

class AccountController extends Controller
{
    function __construct()
    {
    }

    public function index()
    {
        return view('settings.account');
    }

    public function registerPassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
           'old-password'       => 'require',
           'new-password'       => 'require',
           'confirm-password'   => 'require',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->getMessages());
        }
    }

    public function deleteAccount()
    {

    }
}
