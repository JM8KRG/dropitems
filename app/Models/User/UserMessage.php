<?php

namespace DropItems\Models\User;

use DropItems\Models\Contructs\User\UserMessageInterface;

class UserMessage implements UserMessageInterface
{
    /**
     * メッセージを取得する
     *
     * @param $user_id
     * @param $item_id
     * @return array|null
     */
    public function getMessage($user_id, $item_id)
    {
        $result = \DB::connection('mysql')->select('
            SELECT
              message_id,
              item_id,
              message AS body,
              trade_messages.create_at,
              id AS sender_id,
              screen_name AS sender
            FROM
              trade_messages
            INNER JOIN items
              USING (item_id)
            INNER JOIN users
              ON trade_messages.send_user_id = users.id
            WHERE item_id = :item_id
            ORDER BY message_id DESC
        ', [
            'item_id'   => $item_id,
        ]);

        if (!$result) {
            return null;
        }

        $messages = $result;

        foreach ($messages as $key => $message) {
            // 送信者が自分
            if ($user_id === $message->sender_id) {
                $message->you = true;
            } else {
                $message->you = false;

            }
        }

        return $messages;
    }

    /**
     * メッセージを送信する
     *
     * @param user_id
     * @param $item_id
     * @param $message
     * @return bool
     */
    public function sendMessage($user_id, $item_id, $message)
    {
        $con = \DB::connection('mysql');

        $con->beginTransaction();

        try {

            $result = $con->insert('
                INSERT INTO trade_messages (
                  item_id,
                  message,
                  create_at,
                  send_user_id
                ) VALUES (
                    :item_id,
                    :message,
                    NOW(),
                    :user_id
                )
            ', [
                'item_id'   => $item_id,
                'message'   => $message,
                'user_id'   => $user_id,
            ]);

            if (!$result) {
                throw new \Exception('メッセージの記録に失敗');
            }

        } catch (\Exception $e) {

            $con->rollBack();

            \Log::warning($e->getMessage());

        }

        $con->commit();

        return true;
    }
}