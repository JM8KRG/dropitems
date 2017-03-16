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
     * @param $item_id
     * @return null|array
     */
    public function getMessage($item_id);

    /**
     * メッセージを送信する
     *
     * @param $item_id
     * @param $message
     * @return bool
     */
    public function sendMessage($item_id, $message);
}