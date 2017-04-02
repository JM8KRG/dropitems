<?php

namespace DropItems\Http\Controllers\User;

use Illuminate\Http\Request;
use DropItems\Http\Controllers\Controller;

class ItemUploader extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * アップロードページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('item.upload');
    }


    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'item_name'          => 'required|max:50',
            'item_description'   => 'required|max:500',
            'category_id'        => 'required|numeric',
            'condition_id'       => 'required|numeric',
            'images.*'           => 'required|file|image',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->getMessages());
        }


    }
}
