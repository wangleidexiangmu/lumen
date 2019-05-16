<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Laravel\Lumen\Http\Request;
class TestController extends BaseController
{
    public function add(Request $request){
        $email=$request->input('username');
            $pass=$request->input('password');
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
                return  json_encode($response);

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
        return $response;
    }
    protected function getlogintoken($uid){
        $token=substr(md5($uid.time().Str::random(10)),5,15);
        return $token;
    }
}