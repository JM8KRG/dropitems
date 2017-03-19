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

    /**
     * index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->user = \Sentinel::getUser();

        $profile = new \stdClass();
        $profile->screen_name = $this->user->getUserLogin();
        $profile->first_name  = $this->user->getUserFirstName();
        $profile->last_name   = $this->user->getUserLastName();

        return view('settings.profile',  ['profile' => $profile]);
    }


    public function updateScreenName(Request $request)
    {
        // バリデーション
        $validator = \Validator::make($request->all(), [
            'screen_name'   => 'required|max:16|alpha_dash|unique:users',
        ]);

        // 失敗
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->getMessages());
        }

        $this->user = \Sentinel::getUser();

        $credentials = [
            'screen_name'   => $request->input('screen_name'),
        ];

        \Sentinel::getUserRepository()->update($this->user, $credentials);

        // 成功
        return redirect()->back()->with('success', 'スクリーンネームを更新しました。');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        // バリデーション
        $validator = \Validator::make($request->all(), [
            'first_name'    => 'required|max:16',
            'last_name'     => 'required|max:16',
        ]);

        // 失敗
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->getMessages());
        }

        $credentials = [
            'last_name'     => $request->input('last_name'),
            'first_name'    => $request->input('first_name'),
        ];

        $this->user = \Sentinel::getUser();

        \Sentinel::getUserRepository()->update($this->user, $credentials);

        // 成功
        return redirect()->back()->with('success', 'プロフィールを更新しました。');
    }
}
