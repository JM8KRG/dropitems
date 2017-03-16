<?php

namespace DropItems\Models\Contructs\User;

/**
 * ユーザーインターフェース
 *
 * Interface User
 * @package DropItems\Models\Contructs\User
 */

interface UserInterface
{
    /**
     * ユーザーアイテムインスタンスを取得する
     *
     * @return UserItemInterface
     */
    public function getUserItemInstance();

    /**
     * ユーザーメッセージインスタンスを取得する
     *
     * @return UserMessageInterface
     */
    public function getUserMessageInstance();

    /**
     * ユーザー取引インスタンスを取得する
     *
     * @return UserTransactionInterface
     */
    public function getUserTransactionInstance();
}
