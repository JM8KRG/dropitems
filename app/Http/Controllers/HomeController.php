<?php

namespace DropItems\Http\Controllers;

use Sentinel;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package DropItems\Http\Controllers
 */

class HomeController extends Controller
{
    function __construct()
    {

    }

    public function index()
    {
        if (Sentinel::check() === false) {
            return redirect()->action('Sentinel\LoginController@index');
        }

        return view('home');
    }
}
