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

        $result = DB::connection('mysql')->select('
            SELECT items.item_id,
                   items.item_name,
                   items.item_description,
                   items.create_at,
                   item_images.image1,
                   item_images.image2,
                   item_condition.condition,
                   item_categorys.category_name
            FROM items
            INNER JOIN item_images USING (item_id)
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
    public function getUserItemCount()
    {
        $result = DB::connection('mysql')->selectOne('SELECT COUNT(*) AS count FROM items WHERE user_id = :user_id', ['user_id' => \Auth::user()->id]);

        if (empty($result)) {
            return 0;
        }

        return $result->count;
    }


    public function registerUserItem()
    {

    }

    /**
     * ユーザーのアイテムを更新する
     *
     * @param $item_id
     * @param $item_name
     * @param $item_description
     * @param $category_id
     * @param $item_condition_id
     */
    public function updateUserItem($item_id, $item_name, $item_description, $category_id, $item_condition_id)
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

    public function deleteUserItem($item_id)
    {
        // TODO: Implement deleteItem() method.
    }
}
