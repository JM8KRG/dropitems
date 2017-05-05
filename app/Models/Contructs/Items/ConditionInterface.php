<?php

namespace DropItems\Models\Contructs\Items;

/**
 * Interface ConditionInterface
 * @package DropItems\Models\Contructs\Items
 */

interface ConditionInterface
{
    /**
     * アイテムの状態を取得する
     *
     * @return array|null
     */
    public function getConditions();
}