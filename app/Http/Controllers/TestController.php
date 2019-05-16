<?php

namespace App\Http\Controllers;

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
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }else{
            $response=[
                'errno'=>400005,
                'msg'=>'请先登录'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

    }

}