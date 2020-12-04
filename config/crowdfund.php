<?php

return [
    'userModel'    => App\Models\User::class,
    'companyModel' => App\Models\Company::class,
    'Api'          => '\Api',
    'Seller'       => '\Api',

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
