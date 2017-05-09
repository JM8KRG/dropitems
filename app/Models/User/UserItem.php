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
     * @param $user_id int ユーザーID
     * @param $page  int 今のページ
     * @param $total int 全行数
     * @param $limit int 表示件数
     * @return array|null
     */
    public function getUserItem($user_id, $page, $total, $limit)
    {
        // 開始位置
        $offset = $limit * ($page-1);

        $result = DB::connection('mysql')->select('
            SELECT 
              items.item_id,
              items.name,
              items.description,
              items.create_at,
              items.image1,
              items.image2,
              items.image3,
              item_conditions.condition,
              item_categories.category,
              items.status
            FROM items
            INNER JOIN item_conditions ON item_conditions.condition_id = items.condition_id
            INNER JOIN item_categories ON item_categories.category_id = items.category_id
            LEFT OUTER JOIN transactions USING (item_id)
            WHERE
              user_id  = :user_id AND
              transactions.completed_at IS NULL AND
              status = 0 OR 
              status = 1
            ORDER BY items.item_id DESC
              LIMIT :limit
              OFFSET :offset
        ',[
           'user_id' => $user_id,
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
        $result = DB::connection('mysql')->selectOne('SELECT COUNT(*) AS count FROM items WHERE user_id = :user_id', ['user_id' => $user_id]);

        if (empty($result)) {
            return 0;
        }

        return $result->count;
    }

    /**
     * アイテムを出品する
     *
     * @param $user_id int ユーザーID
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
        $con = \DB::connection('mysql');

        // トランザクション開始
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
        DB::connection('dropitems')->update('
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

    /**
     * ユーザーのアイテムを論理削除する
     *
     * @param $user_id int ユーザID
     * @param $item_id string アイテムID
     * @return boolean
     */
    public function deleteUserItem($user_id, $item_id)
    {
        $con = \DB::connection('mysql');

        $result = $con->select('
            SELECT 
              user_id,
              image1,
              image2,
              image3
            FROM
              items
            WHERE
              item_id = :item_id
        ', [
            'item_id'   => $item_id,
        ]);

        if (!$result) {
            return false;
        }

//        $result2 = \DB::connection('mysql')->update('
//          DELETE
//          FROM items
//          WHERE
//            item_id = :item_id AND
//            user_id = :user_id
//        ', [
//            'item_id' => $item_id,
//            'user_id' => $user_id,
//        ]);

        // トランザクション開始
        $con->beginTransaction();

        // 例外
        try {

            // 更新
            $insert = $con->insert('
                UPDATE items
                SET status = :status
                WHERE
                  item_id = :item_id
            ', [
                'status'    => 2, // softDelete
                'item_id'   => $item_id,
            ]);

            if (!$insert) {
                throw new \Exception('出品状態の更新に失敗');
            }

        } catch (\Exception $e) {

            // ロールバック
            $con->rollBack();

            // ログに記録
            \Log::warning($e->getMessage());

            return false;

        }

        // 画像削除
//        if ($result[0]->image1) {
//            unlink(public_path('storage/images').'/'.$result[0]->image1);
//        }
//        if ($result[0]->image2) {
//            unlink(public_path('storage/images').'/'.$result[0]->image2);
//        }
//        if ($result[0]->image3) {
//            unlink(public_path('storage/images').'/'.$result[0]->image3);
//        }

        // コミット
        $con->commit();

        return true;
    }

    /**
     * 出品状態を更新する
     *
     * @param $user_id int ユーザーID
     * @param $item_id string アイテムID
     */
    public function updateUserItemStatus($user_id, $item_id)
    {
        // DB接続
        $con = \DB::connection('mysql');

        // status取ってくる
        $result = $con->select('
            SELECT 
              user_id,
              status
            FROM items
            WHERE item_id = :item_id
        ' ,[
            'item_id'   => $item_id,
        ]);

        if (!$result) {
            return false;
        }

        // 本人以外の更新を防ぐ
        if ($result[0]->user_id !== $user_id) {
            return false;
        }

        // トランザクション開始
        $con->beginTransaction();

        // 例外
        try {

            // 更新
            $insert = $con->insert('
                UPDATE items
                SET status = :status
                WHERE
                  item_id = :item_id
            ', [
                'status'    => !$result[0]->status,
                'item_id'   => $item_id,
            ]);

            if (!$insert) {
                throw new \Exception('出品状態の更新に失敗');
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
}
