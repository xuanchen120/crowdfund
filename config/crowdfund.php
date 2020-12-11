<?php

return [
    'userModel'    => App\Models\User::class,
    'companyModel' => App\Models\Company::class,
    'Api'          => '\Api',
    'Seller'       => '\Api',

    'code_text' => [
        0 => '关闭',
        1 => '进行中',
        2 => '即将上线',
        3 => '已成功',
        4 => '已结束',
    ],
];
