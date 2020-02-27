<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class DemoController extends Controller
{
    public function index()
    {
        return view('demo');
    }

    public function crypt($string, $action)
    {
        $method = Config::get('crypt.method');

    }
}
