<?php

namespace Xuanchen\CrowdFund;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

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
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    /**
     * Notes: 部署时加载
     * @Author: 玄尘
     * @Date  : 2020/12/11 16:50
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/crowdfund.php', 'crowdfund');
    }

}
