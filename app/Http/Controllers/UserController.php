<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Laravel\Lumen\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
class UserController extends BaseController
{
    public function login(Request $request){
        // var_dump(getcookie());
        $res= file_get_contents("php://input");
        $data=base64_decode($res);
        storage_path('key/ras_private.pem');
        $k=openssl_get_publickey('file://'.storage_path('key/rsa_public_key.pem'));
        // var_dump($k);
        $sl=openssl_public_decrypt($data,$finaltext,$k,OPENSSL_PKCS1_PADDING);
        //echo $finaltext;exit;
       // var_dump(json_decode($finaltext,true));exit;
       $json=json_decode($finaltext,true);
       //var_dump($json);
        $email=$json['email'];
        $pass=$json['pass'];
       // echo $email;

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
                echo (json_encode($response));
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
    }
}