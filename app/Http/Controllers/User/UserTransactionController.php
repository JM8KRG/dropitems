<?php

namespace DropItems\Http\Controllers\User;

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

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        // 取引情報を取得
        $transactions = $this->user->getUserTransactionInstance()->getUserTransaction($this->user->getUserId());

        return view('item.transactions', ['transactions' => $transactions]);
    }
}
