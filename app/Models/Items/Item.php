<?php
namespace DropItems\Models\Items;

use DropItems\Models\Contructs\Items\ItemInterface;
use DB;

/**
 * アイテムモデル
 *
 * Class Items
 * @package DropItems\Models\Items
 */
class Item implements ItemInterface {

    /**
     * 特定のアイテムの情報を取得する
     *
     * @param $item_id
     */
    public function getItem($item_id)
    {
        $result = DB::connection('mysql')->select('
            SELECT items.item_id,
            items.item_name,
            items.item_description,
            items.create_at,
            item_images.image1,
            item_images.image2,
            item_images.image3,
            users.id AS seller_id,
            users.name AS seller_name,
            item_condition.condition,
            item_categorys.category_name,
            transactions.transaction_at
            FROM items
            INNER JOIN item_images USING (item_id)
            INNER JOIN users ON users.id = items.user_id
            INNER JOIN item_condition ON item_condition.condition_id = items.item_condition_id
            INNER JOIN item_categorys ON item_categorys.category_id = items.category_id
            LEFT OUTER JOIN transactions USING (item_id)

            WHERE item_id = :item_id
        ',[
            'item_id' => $item_id,
        ]);

        if (empty($result)) {
            return null;
        }

        return $result[0];
    }

    /**
     * アイテムは取引済みか
     *
     * @param $item_id
     * @return bool
     */
    public function isItemTransaction($item_id)
    {
        $result = DB::connection('mysql')->select('SELECT item_id FROM transactions WHERE item_id = :item_id', [
            'item_id' => $item_id,
        ]);

        if (empty($result)) {
            return false;
        }

        return true;
    }

    /**
     * 受け取りユーザーを設定する
     *
     * @param $item_id
     * @param $seller_id
     * @return bool
     */
    public function setUser($item_id, $seller_id)
    {
        $result = DB::connection('mysql')->insert('INSERT INTO 
            transactions (item_id, seller_user_id, buyer_user_id, transaction_at)
            VALUES (:item_id, :seller_id, :buyer_id, NOW())', [
                'item_id' => $item_id,
                'seller_id' => $seller_id,
                'buyer_id' => \Auth::user()->id,
        ]);

        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * アイテムは存在するか
     *
     * @param item_id
     * @return bool
     */
    public function isExistItem($item_id)
    {
        $result = DB::connection('mysql')->select('SELECT item_id FROM items WHERE item_id = :item_id', [
           'item_id' => $item_id,
        ]);

        if (empty($result)) {
            return false;
        }

        return true;
    }
}
