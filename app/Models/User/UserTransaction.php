<?php

namespace DropItems\Models\User;

use DropItems\Models\Contructs\User\UserTransactionInterface;
use DB;

class UserTransaction implements UserTransactionInterface
{
    /**
     * 取引リストを取得
     *
     * @return null|\stdClass
     */
    public function getUserTransaction()
    {
        $result = DB::connection('mysql')->select('
            SELECT items.item_id,
                   items.item_name,
                   item_images.image1,
                   seller.id AS seller_id,
                   seller.name AS seller_name,
                   buyer.name AS buyer_name,
                   transactions.transaction_id,
                   transactions.transaction_at,
                   transactions.completed_at
            FROM transactions
            INNER JOIN items USING (item_id)
            WHERE buyer_user_id = :buyer_id', [
                'buyer_id' => \Auth::user()->id,
        ]);

        // 結果なし
        if (empty($result)) {
            return null;
        }

        $transactions = new \stdClass();
        foreach ($result as $transaction) {
            // 取引完了日時が空
            if (is_null($transaction->completed_at)) {
                $transactions->trading[] = $transaction;
            }else{
                $transactions->history[] = $transaction;
            }
        }

        return $transactions;
    }
}