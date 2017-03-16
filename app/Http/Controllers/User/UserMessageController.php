<?php

namespace DropItems\Http\Controllers\User;

use DropItems\Models\User\User;
use Illuminate\Http\Request;
use DropItems\Http\Controllers\Controller;


/**
 * ユーザーメッセージ送受信コントローラー
 *
 * Class UserMessageController
 * @package DropItems\Http\Controllers\User
 */

class UserMessageController extends Controller
{
    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * メッセージ送受信
     *
     * @param int $item_id アイテムID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($item_id)
    {
        // スレッドIDから全メッセージを取得
        //$this->user->getUserMessageInstance()->getMessage($thread_id);

        // スレッドが存在しない


        return view('user.message');
    }


    /**
     * メッセージ送信
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // バリデーション
        $validate = \Validator::make($request->all(), [
            'item_id'   => 'required|numeric',
            'message'   => 'required|max:512',
        ]);

        // バリデーションエラー
        if ($validate->fails()) {
            // 前のページに戻る
            return redirect()->back()->with('danger', $validate->errors()->getMessages());
        }

        // メッセージを保存
        $this->user->getUserMessageInstance()->sendMessage($request->input('item_id'), $request->input('message'));

        // 前のページに戻る
        return redirect()->back()->with('success', 'メッセージを送信しました。');
    }
}
