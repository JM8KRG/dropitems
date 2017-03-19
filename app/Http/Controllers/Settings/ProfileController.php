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
        $this->middleware('auth');
    }

    public function index()
    {
        $this->user = \Sentinel::getUser();

        $profile = new \stdClass();
        $profile->screen_name = $this->user->getUserLogin();
        $profile->first_name  = $this->user->getUserFirstName();
        $profile->last_name   = $this->user->getUserLastName();

        return view('settings.profile',  ['profile' => $profile]);
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = \Validator::make($request->all(), [
            'screen_name'   => 'required|max:16',
            'last_name'     => 'max:16',
            'first_name'    => 'max:16',
        ]);

        // 失敗
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->getMessages());
        }

        $credentials = [
            'screen_name'   => $request->input('screen_name'),
            'last_name'     => $request->input('last_name'),
            'first_name'    => $request->input('first_name'),
        ];

        $this->user = \Sentinel::getUser();

        \Sentinel::getUserRepository()->update($this->user, $credentials);

        // 成功
        return redirect()->back()->with('success', 'プロフィールを更新しました。');
    }
}
