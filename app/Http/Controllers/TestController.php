<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
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

=======
use Illuminate\Support\Facades\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redis;
class TestController extends BaseController
{
    public function aj(Request $request){
        $token=$_GET['token'];
       // var_dump($token);
        $uid=$_GET['uid'];
        //判断token是否为空
        if(empty($token)||empty($uid)){
            $response=[
                'errno'=>400002,
                'msg'=>'参数不完整'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        //验证是否有效
        $key='login_token:uid:'.$uid;
     //  var_dump($key);
        $local_token=Redis::get($key);
       // var_dump($local_token);
        if($local_token){
            if($token==$local_token){
                $content='token:'.$token.'uid:'.$uid;
                $time=time();
                $str = $time . $content . "\n";
                file_put_contents("logs/login.log", $str, FILE_APPEND);
                $response=[
                    'error'=>0,
                    'msg'=>'ok'
                ];
                die(json_encode($response));
            }else{
                $response=[
                    'errno'=>400004,
                    'msg'=>'token无效'
                ];
>>>>>>> 43f2cce131a9beb0a459fd3e7f7276902acf9e34
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }else{
            $response=[
<<<<<<< HEAD
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
=======
                'errno'=>400005,
                'msg'=>'请先登录'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

    }

>>>>>>> 43f2cce131a9beb0a459fd3e7f7276902acf9e34
}