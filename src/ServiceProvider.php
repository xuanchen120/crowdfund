<?php

namespace Xuanchen\CrowdFund;

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class ServiceProvider extends LaravelServiceProvider
{

    /**
     * Notes: 部署时加载
     * @Author: 玄尘
     * @Date  : 2020/12/1 9:32
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/crowdfund.php' => config_path('crowdfund.php')]);
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
        }
        $this->setRoute();
    }

    /**
     * Notes: 设置路由
     * @Author: 玄尘
     * @Date  : 2020/12/2 15:08
     */
    public function setRoute()
    {
        //总后台
        Route::group([
            'prefix'     => config('admin.route.prefix'),
            'namespace'  => 'XuanChen\CrowdFund\Controllers\Admin',
            'middleware' => config('admin.route.middleware'),
        ], function (Router $router) {
            $router->resource('crowdorders', 'OrderController');
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
            $router->post(config('crowdfund.routers.api.crowdfunds') . '/like', 'CrowdfundController@like');
            $router->post(config('crowdfund.routers.api.crowdfunds') . '/unlike', 'CrowdfundController@unlike');
            $router->Resource(config('crowdfund.routers.api.crowdfunds'), 'CrowdfundController');
        });

        //企业后台
        Route::group([
            'prefix'     => config('seller.route.prefix'),
            'namespace'  => 'XuanChen\CrowdFund\Controllers\Seller',
            'middleware' => config('seller.route.need_auth'),
        ], function (Router $router) {
            $router->Resource(config('crowdfund.routers.api.crowdfunds'), 'CrowdfundController');
        });
    }

    /**
     * 部署时加载
     * @Author:<Leady>
     * @Date  :2020-11-20T12:30:20+0800
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/crowdfund.php', 'crowdfund');
    }

}
