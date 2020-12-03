<?php

return [
    'userModel'    => App\Models\User::class,
    'companyModel' => App\Models\Company::class,

    //后台管理路由
    'routers'      => [
        'admin' => [
            'crowdfunds' => 'crowdfunds',
        ],
        'api'   => [
            'crowdfunds' => 'crowdfunds',
        ],
    ],
];
