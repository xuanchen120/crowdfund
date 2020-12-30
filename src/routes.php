<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

//总后台
Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => 'XuanChen\CrowdFund\Controllers\Admin',
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->resource('crowdfunds', 'CrowdfundController');
    $router->resource('crowdfundcategorys', 'CategoryController');
});

//手机端
Route::group([
    'prefix'     => config('api.route.prefix'),
    'namespace'  => 'XuanChen\CrowdFund\Controllers\Api',
    'middleware' => config('api.route.middleware_auth'),
], function (Router $router) {
    $router->get('ajax/crowdfundcategory', 'AjaxController@category');
    $router->post('crowdfunds/subscribe', 'CrowdfundController@subscribe');
    $router->post('crowdfunds/unsubscribe', 'CrowdfundController@unsubscribe');

    $router->get('crowdfunds/create', 'CrowdfundController@create');
    $router->post('crowdfunds', 'CrowdfundController@store');
});

//手机端
Route::group([
    'prefix'     => config('api.route.prefix'),
    'namespace'  => 'XuanChen\CrowdFund\Controllers\Api',
    'middleware' => config('api.route.middleware_guess'),
], function (Router $router) {
    $router->get('ajax/crowdfundcategory', 'AjaxController@category');
    $router->get('crowdfunds', 'CrowdfundController@index');
    $router->get('crowdfunds/{crowdfund}', 'CrowdfundController@show');
});

//企业后台
Route::group([
    'prefix'     => config('seller.route.prefix'),
    'namespace'  => 'XuanChen\CrowdFund\Controllers\Seller',
    'middleware' => config('seller.route.need_auth'),
], function (Router $router) {
    $router->get('ajax/crowdfundcategory', 'AjaxController@category');

    $router->get('crowdfunds/{crowdfund}/items', 'CrowdfundController@items');              //回报列表
    $router->post('crowdfunds/createitem/{crowdfund}', 'CrowdfundController@createItem');   //添加回报
    $router->get('crowdfunds/itemshow/{item}', 'CrowdfundController@itemShow');             //查看回报
    $router->post('crowdfunds/itemstore/{item}', 'CrowdfundController@itemStore');          //编辑回报
    $router->delete('crowdfunds/itemdel/{item}', 'CrowdfundController@delItem');            //删除回报

    $router->resource('crowdfunds', 'CrowdfundController');
});
