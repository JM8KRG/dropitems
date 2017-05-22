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
            INSERT INTO item_categories (category) VALUES (:category)', [
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
}