<?php

namespace DropItems\Http\Controllers\User;

use DropItems\Models\Items\Item;
use DropItems\Models\User\User;
use Illuminate\Http\Request;
use DropItems\Http\Controllers\Controller;

/**
 * ユーザー取引コントローラー
 *
 * Class UserTransactionController
 * @package Exchange\Http\Controllers\User
 */

class UserTransactionController extends Controller
{
    protected $user;

    protected $item;

    function __construct(User $user, Item $item)
    {
        $this->user = $user;

        $this->item = $item;
    }

    public function index()
    {
        // 取引情報を取得
        $transactions = $this->user->getUserTransactionInstance()->getUserTransaction($this->user->getUserId());

        return view('item.transactions', ['transactions' => $transactions]);
    }

    public function closeTrade($item_id)
    {
        if (!$this->item->isItemTransaction($item_id)) {
            return redirect()->back()->with('danger', 'このアイテムには取引記録がありません。');
        }

        // 取引を完了にする
        $result = $this->user->getUserTransactionInstance()->closeUserTransaction($item_id, $this->user->getUserId());

        if (!$result) {
            return redirect()->back()->with('danger', '完了処理に失敗しました。');
        }

        return redirect()->action('User\UserTransactionController@index')->with('success', '取引を完了しました。');
    }
}
