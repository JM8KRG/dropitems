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
        // 取引履歴を取得
        $transactions = $this->user->getUserTransactionInstance()->getUserTransaction();

        return view('user.transaction', ['transactions' => $transactions]);
    }
}
