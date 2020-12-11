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
    $router->post('crowdfunds/like', 'CrowdfundController@like');
    $router->post('crowdfunds/unlike', 'CrowdfundController@unlike');

    $router->get('crowdfunds/create', 'CrowdfundController@create');
    $router->post('crowdfunds', 'CrowdfundController@store');
});

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
    $router->resource('crowdfunds', 'CrowdfundController');
});
