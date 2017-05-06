<?php

namespace DropItems\Models\User;

use DropItems\Models\Contructs\User\UserItemInterface;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * ユーザーアイテムモデル
 *
 * Class UserItem
 * @package DropItems\Models\User
 */
class UserItem implements UserItemInterface
{
    /**
     * ユーザーのアイテムリストを取得する
     *
     * @param $page  int 今のページ
     * @param $total int 全行数
     * @param $limit int 表示件数
     * @return array|null
     */
    public function getUserItem($page, $total, $limit)
    {
        // 開始位置
        $offset = $limit * ($page-1);

        $result = DB::connection('items')->select('
            SELECT items.item_id,
                   items.item_name,
                   items.item_description,
                   items.create_at,
                   item_images.image1,
                   item_images.image2,
                   item_condition.condition,
                   item_categorys.category_name
            FROM items
            INNER JOIN item_condition ON item_condition.condition_id = items.item_condition_id
            INNER JOIN item_categorys ON item_categorys.category_id = items.category_id
            WHERE user_id  = :user_id
            ORDER BY items.item_id DESC
            LIMIT :limit
            OFFSET :offset
        ',[
           'user_id' => \Auth::user()->id,
            'limit'  => $limit,
            'offset' => $offset,
        ]);

        if (empty($result)) {
            return null;
        }

        return $result;
    }

    /**
     * ユーザーのアイテムリストのページャー
     *
     * @param $page int 今のページ
     * @param $total int 全行数
     * @param $limit int 表示件数
     * @return null|string
     */
    public function getUserItemListPager($page, $total, $limit)
    {
        // 最大ページ数
        $last_page = ceil($total / $limit);

        // リンク作成
        $pager = null;
        for ($i=1; $i<=$last_page; $i++) {
            if ($page == $i) {
                $pager .= '<li class="active"><a href="?p='.$i.'">'.$i.'</a></li>';
            }else{
                $pager .= '<li><a href="?p='.$i.'">'.$i.'</a></li>';
            }
        }

        return $pager;
    }

    /**
     * ユーザーのアイテム出品数
     *
     * @return int
     */
    public function getUserItemCount($user_id)
    {
        $result = DB::connection('dropitems')->selectOne('SELECT COUNT(*) AS count FROM items WHERE user_id = :user_id', ['user_id' => $user_id]);

        if (empty($result)) {
            return 0;
        }

        return $result->count;
    }

    /**
     * アイテムを出品する
     *
     * @param $user_id string ユーザーID
     * @param $item_name string アイテムの名前
     * @param $item_description string アイテムの説明
     * @param $category_id string カテゴリーID
     * @param $condition_id string コンディションID
     * @param $images array アイテムの画像
     * @return boolean
     */
    public function registerUserItem($user_id, $item_name, $item_description, $condition_id, $category_id, $images)
    {
        // 画像が全て来るとは限らないでの中身を確認する
        for ($i=0; $i<3; $i++) {
            if (!isset($images[$i])) {
                $images[$i] = null;
            }
        }

        // DB接続
        $con = \DB::connection('dropitems');

        // トランザクション
        $con->beginTransaction();

        // 例外
        try {

            // アイテム情報をDBに記録する
            $result1 = $con->insert('
                INSERT INTO items (
                  user_id,
                  name,
                  description,
                  category_id,
                  condition_id,
                  create_at,
                  image1,
                  image2,
                  image3
                ) VALUES (
                  :user_id,
                  :item_name,
                  :item_description,
                  :category_id,
                  :condition_id,
                  :create_at,
                  :image1,
                  :image2,
                  :image3
                )
            ', [
                'user_id'           => $user_id,
                'item_name'         => $item_name,
                'item_description'  => $item_description,
                'category_id'       => $category_id,
                'condition_id'      => $condition_id,
                'create_at'         => date('Y-m-d H:i:s'),
                'image1'            => $images[0],
                'image2'            => $images[1],
                'image3'            => $images[2],
            ]);

            if (!$result1) {
                throw new \Exception('アイテム情報の記録に失敗');
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
     * ユーザーのアイテムを更新する
     *
     * @param $user_id
     * @param $item_id
     * @param $item_name
     * @param $item_description
     * @param $category_id
     * @param $item_condition_id
     */
    public function updateUserItem($user_id, $item_id, $item_name, $item_description, $category_id, $item_condition_id)
    {
        DB::connection('mysql')->update('
            UPDATE items
            SET item_name          = :item_name,
                item_description   = :item_discription,
                category_id        = :category_id,
                item_condition_id  = :item_condition_id
            WHERE item_id          = :item_id
            AND user_id            = :user_id
        ',[
            'item_name'         => $item_name,
            'item_description'  => $item_description,
            'category_id'       => $category_id,
            'item_condition_id' => $item_condition_id,
            'item_id'           => $item_id,
            'user_id'           => \Auth::user()->id,
        ]);
    }

    public function deleteUserItem($user_id, $item_id)
    {
        // TODO: Implement deleteItem() method.
    }
}
