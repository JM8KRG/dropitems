<?php

namespace DropItems\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package DropItems\Http\Controllers
 */

class HomeController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }
}
