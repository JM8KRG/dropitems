<?php

namespace DropItems\Models\Contructs\User;

/**
 * Interface UserMessageInterface
 * @package DropItems\Models\Contructs\User
 */

interface UserMessageInterface
{
    /**
     * メッセージを取得する
     *
     * @param $user_id
     * @param $item_id
     * @return null|array
     */
    public function getMessage($user_id, $item_id);

    /**
     * メッセージを送信する
     *
     * @param user_id
     * @param $item_id
     * @param $message
     * @return bool
     */
    public function sendMessage($user_id, $item_id, $message);
}