<?php

namespace DropItems\Models\Contructs\Items;

/**
 * Interface CategoryInterface
 * @package DropItems\Models\Contructs\Items
 */

interface CategoryInterface
{
    /**
     * カテゴリーを保存する
     *
     * @param $category_name string カテゴリーの名前
     * @return boolean
     */
    public function saveCategory($category_name);

    /**
     * カテゴリーを取得する
     *
     * @return array|null
     */
    public function getCategories();
}