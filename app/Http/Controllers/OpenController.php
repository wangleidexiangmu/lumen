<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Open;
use Laravel\Lumen\Http\Request;
use Illuminate\Support\Facades\DB;
class OpenController extends BaseController
{
    public function open()
    {
        $res= file_get_contents("php://input");
        $data=base64_decode($res);
        storage_path('key/ras_private.pem');
        $k=openssl_get_publickey('file://'.storage_path('key/rsa_public_key.pem'));
        // var_dump($k);
        $sl=openssl_public_decrypt($data,$finaltext,$k,OPENSSL_PKCS1_PADDING);
       // echo "String crypted: $finaltext";
       // echo 123;
      //var_dump(json_decode($finaltext,true));exit;
        $uid=DB::table('userreg')->insert(json_decode($finaltext,true));
        if($uid){
            $response=[
                'errno'=>0,
                'msg'=>'ok'
            ];
        }else{
            $response=[
                'errno'=>50003,
                'msg'=>'注册失败'
            ];
        }
        die(json_encode($response));

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