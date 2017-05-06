<?php

namespace DropItems\Models\Contructs\User;

/**
 * Interface UserItemInterface
 * @package DropItems\Models\Contructs\User
 */

interface UserItemInterface
{
    // 出品中のアイテムを取得
    public function getUserItem($user_id, $page, $max, $limit);

    /**
     * アイテムを出品する
     *
     * @param $user_id string ユーザーID
     * @param $item_name string アイテムの名前
     * @param $item_description string アイテムの説明
     * @param $category_id string カテゴリーID
     * @param $category_id string コンディションID
     * @param $images array アイテムの画像
     * @return boolean
     */
    public function registerUserItem($user_id, $item_name, $item_description, $condition_id, $category_id, $images);

    // 出品情報を更新する
    public function updateUserItem($user_id, $item_id, $item_name, $item_description, $category_id, $item_condition_id);

    // 出品物を削除する
    public function deleteUserItem($user_id, $item_id);

    // ユーザーのアイテムリストのページャー
    public function getUserItemListPager($page, $total, $limit);

    //ユーザーのアイテム出品数
    public function getUserItemCount($user_id);

    /**
     * 出品状態を更新する
     *
     * @param $user_id int ユーザーID
     * @param $item_id string アイテムID
     */
    public function updateUserItemStatus($user_id, $item_id);
}
