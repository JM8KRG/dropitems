<?php

namespace DropItems\Http\Controllers\User;

use DropItems\Models\Items\Item;
use DropItems\Models\User\User;
use Illuminate\Http\Request;
use DropItems\Http\Controllers\Controller;

class UserItemController extends Controller
{
    protected $user;

    protected $item;

    function __construct(User $user, Item $item)
    {
        $this->middleware('auth');

        $this->user = $user;

        $this->item = $item;
    }

    /**
     * アイテムを表示する
     */
    public function index(Request $request)
    {
        // ページ番号
        $page = $request->input('p') != null ? $request->input('p') : 1;

        // アイテムの件数
        $total = $this->user->getUserItemInstance()->getUserItemCount($this->user->getUserId());

        // アイテムを取得
        $list = $this->user->getUserItemInstance()->getUserItem($this->user->getUserId(), $page, $total, 15);

        // ページャー
        $pager = $this->user->getUserItemInstance()->getUserItemListPager($page, $total, 15);

        return view('item.my_items', ['items' => $list, 'pager' => $pager]);
    }

    /**
     * 出品状態を更新する
     *
     * @param $item_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateItemStatus($item_id)
    {
        $result = $this->user->getUserItemInstance()->updateUserItemStatus($this->user->getUserId(), $item_id);

        // 更新エラー
        if (!$result) {
            \Session::flash('danger', '出品状態の更新に失敗しました。');

            return redirect()->action('User\UserItemController@index');
        }

        return redirect()->action('User\UserItemController@index');
    }

    /**
     * アイテムを削除する
     *
     * @param $item_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyItem($item_id)
    {
        // アイテムは取引中か
        if ($this->item->isItemTransaction($item_id)) {
            \Session::flash('danger', '取引中のアイテムのため削除できません。');

            return redirect()->action('User\UserItemController@index');
        }

        $result = $this->user->getUserItemInstance()->deleteUserItem($this->user->getUserId(), $item_id);

        if (!$result) {
            \Session::flash('danger', 'アイテムの削除に失敗しました。');

            return redirect()->action('User\UserItemController@index');
        }

        return redirect()->action('User\UserItemController@index');
    }
}
