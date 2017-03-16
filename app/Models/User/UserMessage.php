<?php

namespace DropItems\Models\User;

use DropItems\Models\Contructs\User\UserMessageInterface;

class UserMessage implements UserMessageInterface
{
    /**
     * メッセージを取得する
     *
     * @param $item_id
     * @return null|array
     */
    public function getMessage($item_id)
    {
        // TODO: Implement getMessage() method.
    }

    /**
     * メッセージを送信する
     *
     * @param $item_id
     * @param $message
     * @return bool
     */
    public function sendMessage($item_id, $message)
    {
        // TODO: Implement sendMessage() method.
    }
}