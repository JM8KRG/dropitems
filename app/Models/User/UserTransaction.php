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
              transactions.seller_id = :seller_id OR 
              transactions.buyer_id = :buyer_id
        ', [
                'seller_id' => $user_id,
                'buyer_id' => $user_id,
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

    /**
     * 取引を完了する
     *
     * @param $item_id
     * @param $seller_id
     * @return boolean
     */
    public function closeUserTransaction($item_id, $seller_id)
    {
        $con = DB::connection('mysql');

        $con->beginTransaction();

        try {

            $result = $con->update('
                UPDATE transactions
                SET completed_at = NOW()
                WHERE 
                  item_id = :item_id AND
                  seller_id = :user_id
            ', [
                'item_id'   => $item_id,
                'user_id'   => $seller_id,
            ]);

            if (!$result) {
                throw new \Exception('完了処理に失敗しました。');
            }

        } catch (\Exception $exception) {

            $con->rollBack();

            \Log::warning($exception->getMessage());

            return false;

        }

        $con->commit();

        return true;
    }
}
