<?php

namespace DropItems\Models\User;

use DropItems\Models\Contructs\User\UserInterface;
use DropItems\Models\Contructs\User\UserItemInterface;
use DropItems\Models\Contructs\User\UserMessageInterface;
use DropItems\Models\Contructs\User\UserTransactionInterface;

/**
 * ユーザーモデル
 *
 * Class User
 * @package DropItems\Models\User
 */

class User implements UserInterface
{
    /**
     * ユーザーアイテムインスタンスを取得する
     *
     * @return UserItemInterface
     */
    public function getUserItemInstance()
    {
        return new UserItem($this);
    }

    /**
     * ユーザーメッセージインスタンスを取得する
     *
     * @return UserMessageInterface
     */
    public function getUserMessageInstance()
    {
        return new UserMessage($this);
    }

    /**
     * ユーザー取引インスタンスを取得する
     *
     * @return UserTransactionInterface
     */
    public function getUserTransactionInstance()
    {
        return new UserTransaction($this);
    }
}