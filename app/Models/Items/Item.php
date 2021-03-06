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
            items.name,
            items.description,
            items.create_at,
            items.image1,
            items.image2,
            items.image3,
            items.status,
            users.id AS seller_id,
            users.screen_name AS seller_name,
            item_conditions.condition,
            item_categories.category,
            items.create_at
            FROM items
            INNER JOIN users ON users.id = items.user_id
            INNER JOIN item_conditions ON item_conditions.condition_id = items.condition_id
            INNER JOIN item_categories ON item_categories.category_id = items.category_id
            LEFT OUTER JOIN transactions USING (item_id)

            WHERE item_id = :item_id
        ',[
            'item_id' => $item_id,
        ]);

        if (!$result) {
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
        $result = DB::connection('mysql')->select('
            SELECT
              item_id
            FROM
              transactions
            WHERE
              item_id = :item_id
        ', [
            'item_id' => $item_id,
        ]);

        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * 受け取りユーザーを設定する
     *
     * @param $item_id
     * @param $seller_id
     * @param $buyer_id
     * @return bool
     */
    public function setUser($item_id, $seller_id, $buyer_id)
    {
        $con = \DB::connection('mysql');

        $con->beginTransaction();

        try {

            $result = $con->insert('
              INSERT INTO transactions (
                item_id,
                seller_id,
                buyer_id,
                create_at
              ) VALUES (
                :item_id,
                :seller_id,
                :buyer_id,
                NOW()
              )', [
                'item_id'   => $item_id,
                'seller_id' => $seller_id,
                'buyer_id'  => $buyer_id,
            ]);

            if (!$result) {
                throw new \Exception('申請途中にエラーが発生しました。');
            }

        } catch (\Exception $e) {

            \Log::warning($e->getMessage());

            return false;

        }

        $con->commit();

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
        if (!$item_id) {
            return false;
        }

        $result = DB::connection('mysql')->select('SELECT item_id FROM items WHERE item_id = :item_id', [
           'item_id' => $item_id,
        ]);

        if (empty($result)) {
            return false;
        }

        return true;
    }

    /**
     * アイテムリストを取得する
     *
     * @param $limit int 表示数
     * @return array|null
     */
    public function getItems($limit=10)
    {
        $result = DB::connection('mysql')->select('
            SELECT
              items.item_id,
              items.name,
              items.description,
              items.image1

            FROM items

            LEFT JOIN transactions
              USING (item_id)

            WHERE status = 0 AND
              transactions.create_at IS NULL

            ORDER BY item_id DESC
            LIMIT :limit
        ', [
            'limit' => $limit
        ]);

        if (!$result) {
            return null;
        }

        return $result;
    }

    /**
     *  カテゴリーIDからアイテムリストを取得する
     *
     * @param $category_id string カテゴリーID
     * @return array|null
     */
    public function getItemsByCategoryId($category_id)
    {
        if (!$category_id) {
            return null;
        }

        $result = DB::connection('mysql')->select('
            SELECT
              items.item_id,
              items.name,
              items.description,
              items.image1

            FROM items

            LEFT JOIN transactions
              USING (item_id)

            WHERE
              category_id = :category_id AND
              status = 0 AND
              transactions.create_at IS NULL

            ORDER BY item_id DESC
        ', [
            'category_id' => $category_id,
        ]);

        if (!$result) {
            return null;
        }

        return $result;
    }
}
