<?php

namespace DropItems\Models\Contructs\Items;

/**
 * Interface ItemInterface
 * @package DropItems\Models\Contructs\Items
 */

interface ItemInterface {

    /**
     * アイテムリストを取得する
     *
     * @param $limit int 表示数
     * @return array|null
     */
    public function getItems($limit);

    /**
     * アイテムは存在するか
     *
     * @param item_id
     * @return bool
     */
    public function isExistItem($item_id);

    /**
     * アイテムは取引済みか
     *
     * @param $item_id
     * @return bool
     */
    public function isItemTransaction($item_id);

    /**
     * 受け取りユーザーを設定する
     *
     * @param $item_id
     * @param $seller_id
     * @param $buyer_id
     * @return bool
     */
    public function setUser($item_id, $seller_id, $buyer_id);

    // アイテムIDから出品情報を取得する
    public function getItem($item_id);
}
