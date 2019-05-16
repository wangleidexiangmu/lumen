<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//$app->get('/', [
//    'as' => 'open',
//    'open' => 'App\Http\Controllers\OpenController@open'
//]);
//$router->group(['prefix' => 'open/'], function() use ($router) {
//    $router->get('/','OpenController@open'); //get all the routes
//
//});
$router->post('add', 'OpenController@add');//非对称
$router->options('add',function () use ($router) {
    return '';
});
$router->post('twoadd', 'OpenController@twoadd');//对称
//签名
$router->post('sign', 'OpenController@sign');
$router->post('login', 'UserController@login');//非对称
<<<<<<< HEAD
$router->post('add', 'TestController@add');//登录
=======
$router->options('login',function () use ($router) {
    return '';
});//非对称
$router->get('aj', 'TestController@aj');//ajax
>>>>>>> 43f2cce131a9beb0a459fd3e7f7276902acf9e34
