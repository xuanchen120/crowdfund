<?php

return [
    'userModel'  => 'App\Models\User::class',
    'storeModel' => 'App\Models\Store::class',
    
    //后台管理路由
    'routers'    => [
        'admin' => [
            'crowdfunds' => 'crowdfunds',
        ],
        'api'   => [
            'crowdfunds' => 'crowdfunds',
        ],
        'agent' => [

        ],
    ],
];
