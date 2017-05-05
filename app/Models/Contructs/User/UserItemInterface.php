<?php

namespace DropItems\Models\Contructs\User;

/**
 * Interface UserItemInterface
 * @package DropItems\Models\Contructs\User
 */

interface UserItemInterface
{
    // 出品中のアイテムを取得
    public function getUserItem($page, $max, $limit);

    // 出品する
    public function registerUserItem();

    // 出品情報を更新する
    public function updateUserItem($item_id, $item_name, $item_description, $category_id, $item_condition_id);

    // 出品物を削除する
    public function deleteUserItem($item_id);

    // ユーザーのアイテムリストのページャー
    public function getUserItemListPager($page, $total, $limit);

    //ユーザーのアイテム出品数
    public function getUserItemCount();
}
