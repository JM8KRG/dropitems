<?php

namespace DropItems\Http\Controllers\Settings;

use Illuminate\Http\Request;
use DropItems\Http\Controllers\Controller;

/**
 * Class ProfileController
 * @package GetBooks\Http\Controllers\Settings
 */

class ProfileController extends Controller
{
    protected $user;

    function  __construct()
    {

    }

    public function index()
    {
        return view('settings.profile');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = \Validator::make($request->all(), [
            'screen-name'   => 'require|max:8',
            'last-name'     => 'require|max:16',
            'first-name'    => 'require|max:16',
            'free-text'     => 'max:300',
        ]);

        // 失敗
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->getMessages());
        }

        // 成功
        return redirect()->back()->with('success', '登録成功');
    }
}
