<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Hashids\Hashids;

class DemoController extends Controller
{
    public function index()
    {
        // 3-character prefix used as init vector with numeric key.
        return view('demo')->with([
            'prefixes' => Config::get('crypt.prefixes')
        ]);
    }

    public function crypt($string, $action)
    {
        // Set up config.
        $method = Config::get('crypt.method');
        $key = hash('sha256', Config::get('secret_key'));
        $iv = substr(hash('sha256', Config::get('secret_iv')), 0, 16) ;

        // Encrypt/Decrypt and return encrypted string/decryption result.
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
            'output' => $output
        ]);
    }

    public function obfuscate($string, $prefix)
    {
        return $prefix . '-' . str_pad(base_convert($string, 10, 6), 7, 0, STR_PAD_LEFT);
    }

    public function deobfuscate($string, $prefix)
    {
        $parts = explode('-', $string);

        return $prefix . '-' . base_convert($string[1], 6, 10);
    }
}
