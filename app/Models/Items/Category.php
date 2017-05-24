<?php

namespace DropItems\Models\Items;

use DropItems\Models\Contructs\Items\CategoryInterface;

class Category implements CategoryInterface
{
    /**
     * カテゴリーを保存する
     *
     * @param $category_name string カテゴリーの名前
     * @return boolean
     */
    public function saveCategory($category_name)
    {
        // DB接続
        $con = \DB::connection('mysql');

        // トランザクション開始
        $con->beginTransaction();

        // 例外
        try {

            $result = $con->insert('
            INSERT INTO item_categories (category) VALUES (:category)
            ', [
                'category' => $category_name,
            ]);

            if (!$result) {
                throw new \Exception('カテゴリーの追加に失敗');
            }

        } catch (\Exception $e) {
            // ロールバック
            $con->rollBack();

            // ログに記録
            \Log::warning($e->getMessage());

            return false;
        }

        // コミット
        $con->commit();

        return true;
    }

    /**
     * カテゴリーを取得する
     *
     * @return array|null
     */
    public static function getCategories()
    {
        $result = \DB::connection('mysql')->select('
            SELECT *
            FROM item_categories
        ');

        if (!$result) {
            return null;
        }

        return $result;
    }

    /**
     * カテゴリーIDからカテゴリー名を取得する
     *
     * @param $category_id string カテゴリーID
     * @return string
     */
    public static function getCategoryNameById($category_id)
    {
        if (!$category_id) {
            return "カテゴリー名を取得できません。";
        }

        $result = \DB::connection('mysql')->selectOne('
            SELECT category
            FROM item_categories
            WHERE category_id = :category_id
        ', [
            'category_id' => $category_id
        ]);

        if (!$result) {
            return "カテゴリー名を取得できません。";
        }

        return $result->category;
    }
}