<?php

namespace DropItems\Http\Controllers\Items;

use DropItems\Models\Items\Item;
use Illuminate\Http\Request;
use DropItems\Http\Controllers\Controller;

/**
 * アイテム情報コントローラー
 *
 * Class ItemController
 * @package Exchange\Http\Controllers\Items
 */

class ItemController extends Controller
{
    protected $item;

    function __construct(Item $item)
    {
        $this->item = $item;
    }

    // アイテムページ
    public function index($item_id)
    {
        // 特定のアイテムを取得
        $item = $this->item->getItem($item_id);

        // 情報なし
        if (!$item) {
            return view('item.item_404');
        }

        return view('item.detail', ['item' => $item]);
    }

    // 申し込む
    public function store(Request $request)
    {
        if (is_null($request->item_id)) {
            // エラーメッセージ
            return abort('403', '不正なリクエストです。');
        }

        // アイテムIDを復号化する
        $item_id = \Crypt::decrypt($request->item_id);

        // アイテム情報を取得
        $item = $this->item->getItem($item_id);

        // アイテムの存在を確認
        if (is_null($item)) {
            // エラーメッセージ
            return abort('403', '不正なリクエストです。');
        }

        // 申し込み状況を確認
        if ($this->item->isItemTransaction($item->item_id)) {
            // エラーメッセージ
            \Session::flash('warning', 'このアイテムの申し込みは終了しました。');

            return redirect()->back();
        }

        // アイテムの受取人を決定する
        $this->item->setUser($item_id, $item->seller_id);

        return dd('メッセージツールへ移動するゾ');
    }
}
