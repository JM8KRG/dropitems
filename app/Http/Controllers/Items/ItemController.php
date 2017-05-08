<?php

namespace DropItems\Http\Controllers\Items;

use DropItems\Models\Items\Item;
use DropItems\Models\User\User;
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

    protected $user;

    function __construct(Item $item, User $user)
    {
        $this->middleware('auth');

        $this->user = $user;

        $this->item = $item;
    }

    /**
     * アイテム詳細
     *
     * @param $item_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index($item_id)
    {
        $button = true;

        // 特定のアイテムを取得
        $item = $this->item->getItem($item_id);

        // 該当するアイテムなし
        if (!$item) {
            return redirect()->action('HomeController@index');
        }

        // アイテムが非公開設定
        if($item->status === 1) {
            $button = false;
        }

        // 申し込み状況を確認
        if ($this->item->isItemTransaction($item_id)) {
            $button = false;
        }

        return view('item.detail', ['item' => $item, 'use_button' => $button]);
    }

    /**
     * 受け取り申請
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (is_null($request->item_id)) {
            // エラーメッセージ
            return abort('403', '不正なリクエストです。');
        }

        // アイテムIDを復号化する
        $item_id = \Crypt::decrypt($request->item_id);

        // アイテムの存在を確認
        if (!$this->item->isExistItem($item_id)) {
            // エラーメッセージ
            return abort('403', '不正なリクエストです。');
        }

        // 申し込み状況を確認
        if ($this->item->isItemTransaction($item_id)) {
            // エラーメッセージ
            \Session::flash('danger', 'このアイテムの申し込みは終了しました。');

            return redirect()->back();
        }

        // 出品者のIDを取得
        $seller_id = $this->item->getItem($item_id)->seller_id;

        // 自己申請
        if ($seller_id === $this->user->getUserId()) {
            // エラーメッセージ
            \Session::flash('danger', '自分で出品したアイテムに受け取り申請はできません。');

            return redirect()->back();
        }

        // アイテムの受取人を決定する
        $result = $this->item->setUser($item_id, $seller_id, $this->user->getUserId());

        if (!$result) {
            // エラーメッセージ
            \Session::flash('danger', '申請途中にエラーが発生しました。');

            return redirect()->back();
        }

        // メッセージツールへ
        return redirect()->action('User\UserMessageController@index', ['item_id' => $item_id]);
    }
}
