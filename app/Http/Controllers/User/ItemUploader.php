<?php

namespace DropItems\Http\Controllers\User;

use DropItems\Models\User\User;
use Illuminate\Http\Request;
use DropItems\Http\Controllers\Controller;

class ItemUploader extends Controller
{

    protected $user;

    function __construct(User $user)
    {
        $this->middleware('auth');

        $this->user = $user;
    }

    /**
     * アップロードページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // カテゴリーを取得する
        $categories = $this->user->getCategoryInstanse()->getCategories();

        return view('item.upload', [
            'categories'    => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'item_name'          => 'required|max:50',
            'item_description'   => 'required|max:500',
            'condition_id'       => 'required|numeric',
            'category_id'        => 'required|numeric',
            'images'             => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->getMessages());
        }

        // 画像は存在するか確認

        dd($request->all());
    }


    /**
     * 画像アップロード
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function uploadImages(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'file' => 'required|image',
        ]);

        if ($validator->fails()) {
            return \Response::json('error', 400);
        }

        // 画像
        $image = $request->file('file');

        // 拡張子を取得
        $ext = '.'.$image->getClientOriginalExtension();

        // ファイル名
        $name = date('Ymd_H_i_s_').str_random(16).$ext;

        // ファイル移動
        $upload_success = $image->move(public_path('storage/images'), $name);

        // アップロード成功
        if ($upload_success) {
            return \Response::json(['status' => 'success', 'name' => $name], 200);
        }

        return \Response::json(['status' => 'error'], 400);
    }
}
