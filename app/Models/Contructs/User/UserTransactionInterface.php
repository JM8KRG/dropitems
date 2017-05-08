<?php

namespace DropItems\Models\Contructs\User;

/**
 * Class Transaction
 * @package DropItems\Models\Contructs\User
 */
interface UserTransactionInterface {
    /**
     * 取引リストを取得
     *
     * @param $user_id int ユーザーID
     * @return mixed
     */
    public function getUserTransaction($user_id);
}