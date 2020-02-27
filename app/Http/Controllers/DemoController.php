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
        $key = hash('sha256', Config::get('secret_key'));
        $iv = substr(hash('sha256', Config::get('secret_iv')), 0, 16) ;

        switch ($action) {
            case 'encrypt':
                $output = base64_encode(openssl_encrypt($string, $method, $key, 0, $iv));
                break;

            case 'decrypt':
                $output = openssl_decrypt(base64_decode($string), $method, $key, 0, $iv);
                break;
            
            default:
                $output = null;
                break;
        }

        return response()->json([
            'data' => $output
        ]);
    }
}
