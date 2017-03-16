<?php

namespace DropItems\Http\Controllers\User;

use DropItems\Models\User\User;
use Illuminate\Http\Request;
use DropItems\Http\Controllers\Controller;

class UserItemController extends Controller
{
    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * 出品中の物品を表示する
     */
    public function index(Request $request)
    {
        // ページ番号
        $page = $request->input('p') != null ? $request->input('p'):1;

        // アイテムの件数
        $total = $this->user->getUserItemInstance()->getUserItemCount();

        // アイテムを取得
        $list = $this->user->getUserItemInstance()->getUserItem($page, $total, 2);

        // ページャー
        $pager = $this->user->getUserItemInstance()->getUserItemListPager($page, $total, 2);

        return view('user.items', ['items' => $list, 'pager' => $pager]);
    }

    /**
     * 出品情報を更新する
     */
    public function update(Request $request)
    {
        // バリデーション
        $flag = $this->validate($request, [
            'item_id'   => 'required|numeric',
            'item_name' => 'required|max:50',
        ]);

        // バリデーションエラー

    }
}
