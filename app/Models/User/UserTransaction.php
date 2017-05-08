<?php

namespace DropItems\Models\User;

use DropItems\Models\Contructs\User\UserTransactionInterface;
use DB;

class UserTransaction implements UserTransactionInterface
{
    /**
     * 取引リストを取得
     *
     * @param $user_id int ユーザーID
     * @return null|\stdClass
     */
    public function getUserTransaction($user_id)
    {
        $result = DB::connection('mysql')->select('
            SELECT
              items.item_id,
              items.name,
              users.screen_name AS buyer_name,
              transactions.create_at,
              transactions.completed_at
            FROM transactions
            INNER JOIN items USING (item_id)
            INNER JOIN users
              ON transactions.buyer_id = users.id
            WHERE 
              transactions.seller_id = :user_id
        ', [
                'user_id' => $user_id,
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