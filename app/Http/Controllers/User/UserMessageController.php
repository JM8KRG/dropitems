<?php

namespace DropItems\Http\Controllers\User;

use DropItems\Models\Items\Item;
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

    protected $item;

    function __construct(User $user, Item $item)
    {
        $this->user = $user;

        $this->item = $item;
    }

    /**
     * メッセージ送受信
     *
     * @param int $item_id アイテムID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($item_id)
    {
        // スレッドが存在しない
        if (!$this->item->isItemTransaction($item_id)) {
            \Session::flash('danger', '取引が存在しません。');

            return redirect()->action('User\UserTransactionController@index');
        }

        // スレッドIDから全メッセージを取得
        $messages = $this->user->getUserMessageInstance()->getMessage($this->user->getUserId(), $item_id);

        // アイテムインスタンスから名前を取得
        $item_name = $this->item->getItem($item_id)->name;

        return view('item.messages', [
            'item_id'   => $item_id,
            'item_name' => $item_name,
            'messages'  => $messages,
        ]);
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
            'message'   => 'required|max:500',
        ]);

        // バリデーションエラー
        if ($validate->fails()) {
            // 前のページに戻る
            return redirect()->back()->withErrors($validate->errors()->getMessages());
        }

        // メッセージを保存
        $result = $this->user->getUserMessageInstance()->sendMessage($this->user->getUserId(), $request->input('item_id'), $request->input('message'));

        if (!$result) {
            return redirect()->back()->with('danger', 'メッセージの送信に失敗しました。');
        }

        // 前のページに戻る
        return redirect()->back()->with('success', 'メッセージを送信しました。');
    }
}
