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

    /**
     * 取引を完了する
     *
     * @param $item_id
     * @param $seller_id
     * @return boolean
     */
    public function closeUserTransaction($item_id, $seller_id);
}