<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Laravel\Lumen\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
class UserController extends BaseController
{
<<<<<<< HEAD
    public function login(Request $request){
        // var_dump(getcookie());
        //header("Access-Control-Allow-Origin: *");
        $res= file_get_contents("php://input");
        $data=base64_decode($res);
        storage_path('key/ras_private.pem');
        $k=openssl_get_publickey('file://'.storage_path('key/rsa_public_key.pem'));
=======
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
>>>>>>> 43f2cce131a9beb0a459fd3e7f7276902acf9e34
        // var_dump($k);
        $sl = openssl_private_encrypt($str, $finaltext, $k, OPENSSL_PKCS1_PADDING);
        //echo "String crypted: $finaltext";exit;
        $pos_st = base64_encode($finaltext);
        $url = 'http://passport.1809a.com/login';

<<<<<<< HEAD
        //echo $pass;
     // exit;
       // $pass=$request->input('pass');
        $u=DB::table('userreg')->where(['email'=>$email])->first();
        if($u){
            if(password_verify($pass,$u->pass)){
                $token=$this->getlogintoken($u->uid);
                $redis_token_key='login_token:uid:'.$u->uid;
                Redis::set($redis_token_key,$token);
                Redis::expire($redis_token_key,64800);
                $response=[
                    'errno'=>0,
                    'msg'=>'ok',
                    'data'=>[
                        'token'=>$token
                    ]
                ];
               die(json_encode($response));

            }else{
                $response=[
                    'errno'=>50007,
                    'msg'=>'登录失败'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }else{
            $response=[
                'errno'=>50004,
                'msg'=>'用户不存在'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
    }
    protected function getlogintoken($uid){
        $token=substr(md5($uid.time().Str::random(10)),5,15);
        return $token;
=======
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
>>>>>>> 43f2cce131a9beb0a459fd3e7f7276902acf9e34
    }
}