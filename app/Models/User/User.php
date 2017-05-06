<?php

namespace DropItems\Models\User;

use DropItems\Models\Contructs\Items\CategoryInterface;
use DropItems\Models\Contructs\User\UserInterface;
use DropItems\Models\Contructs\User\UserItemInterface;
use DropItems\Models\Contructs\User\UserMessageInterface;
use DropItems\Models\Contructs\User\UserTransactionInterface;
use DropItems\Models\Items\Category;

/**
 * ユーザーモデル
 *
 * Class User
 * @package DropItems\Models\User
 */

class User implements UserInterface
{
    protected $user;

    /**
     * ユーザーIDを返却する
     *
     * @return int
     */
    function getUserId()
    {
        $this->user = \Sentinel::getUser();

        return $this->user->getUserId();
    }

    /**
     * ユーザーアイテムインスタンスを取得する
     *
     * @return UserItemInterface
     */
    public function getUserItemInstance()
    {
        return new UserItem();
    }

    /**
     * ユーザーメッセージインスタンスを取得する
     *
     * @return UserMessageInterface
     */
    public function getUserMessageInstance()
    {
        return new UserMessage();
    }

    /**
     * ユーザー取引インスタンスを取得する
     *
     * @return UserTransactionInterface
     */
    public function getUserTransactionInstance()
    {
        return new UserTransaction();
    }

    /**
     * カテゴリーインスタンスを取得する
     *
     * @return CategoryInterface
     */
    public function getCategoryInstanse()
    {
        return new Category();
    }
}