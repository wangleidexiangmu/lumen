<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Laravel\Lumen\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
class UserController extends BaseController
{
    public function login(Request $request)
    {

        $data = [
            'email'=>$_POST['name'],
            'pass'=>$_POST['pwd'],
        ];
        //  var_dump($data);exit;
        $str = json_encode($data);
        // storage_path('key/ras_private.pem');
        $k = openssl_pkey_get_private('file://' . storage_path('key/rsa_private.pem'));
        // var_dump($k);
        $sl = openssl_private_encrypt($str, $finaltext, $k, OPENSSL_PKCS1_PADDING);
        //echo "String crypted: $finaltext";exit;
        $pos_st = base64_encode($finaltext);
        $url = 'http://passport.wangleiseven.top/login';

        //创建一个新curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $pos_st);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:text/plain'
        ]);
        $res = curl_exec($ch);
        $code = curl_errno($ch);
        //var_dump($code);
        curl_close($ch);
    }
}