<?php

namespace DropItems\Http\Controllers;

use DropItems\Models\Items\Item;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package DropItems\Http\Controllers
 */

class HomeController extends Controller
{
    protected $item;

    function __construct(Item $item)
    {
        $this->middleware('auth');

        $this->item = $item;
    }

    public function index()
    {
        // アイテムを取得する
        $items_list = $this->item->getItems(10);

        return view('home', ['items' => $items_list]);
    }
}
