<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Open;
use Laravel\Lumen\Http\Request;
use Illuminate\Support\Facades\DB;
class OpenController extends BaseController
{
    public function add(Request $request)
    {
        $pass1 = $request->input('pass1');
        $pass2 = $request->input('pass2');
        $email = $request->input('email');
        var_dump($email);exit;
        $e = UserModel::where(['email' => $email])->first();
        if ($e) {
            $response = [
                'errno' => 50004,
                'msg' => '邮箱已存在'
            ];
            die(json_encode($response, JSON_UNESCAPED_UNICODE));
        }

        $pass = password_hash($pass2, PASSWORD_BCRYPT);
        if ($pass1 != $pass2) {
            $response = [
                'errno' => 50002,
                'msg' => '密码不一致'
            ];
            die(json_encode($response, JSON_UNESCAPED_UNICODE));
        }
        $data = [
            'name' => $request->input('username'),
            'email' => $email,
            'pass' => $pass
        ];
        $str = json_encode($data);
        // storage_path('key/ras_private.pem');
        $k = openssl_pkey_get_private('file://' . storage_path('key/rsa_private.pem'));
        // var_dump($k);
        $sl = openssl_private_encrypt($str, $finaltext, $k, OPENSSL_PKCS1_PADDING);
        //echo "String crypted: $finaltext";exit;
        $pos_st = base64_encode($finaltext);
        $url = 'http://api.1809a.com/open';

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
        var_dump($code);
        curl_close($ch);


    }
//    public function twoadd(){
//        $res= file_get_contents("php://input");
//        $mi=base64_decode($res);
//       // echo $data;
//        $method='AES-256-CBC';
//        $key='wanglei';
//        $option=OPENSSL_RAW_DATA;
//        $iv='1234567890qwerty';
//        $enc_str=openssl_decrypt($mi,$method,$key,$option,$iv);
//      echo $enc_str;
//    //  echo 123;
//    }
//public function sign(Request  $request){
//  // echo 123;
//     $res2=$_GET['sign'];
//   $arr=base64_decode($res2);
//    $res= file_get_contents("php://input");
//
//   // echo $data;
//    storage_path('key/ras_private.pem');
//    $k=openssl_get_publickey('file://'.storage_path('key/rsa_public_key.pem'));
//    // var_dump($k);
//    $sl=openssl_verify($res,$arr,$k,OPENSSL_ALGO_SHA1);
//  if($sl==1){
//      echo '验证签名成功';
//  }else{
//      echo '验证签名失败';
//  }
//}
//
//



}