<?php

namespace XuanChen\CrowdFund\Models;

use XuanChen\CrowdFund\Models\Traits\BelongsToCompany;
use XuanChen\CrowdFund\Models\Traits\HasCovers;

class Crowdfund extends Model
{

    use HasCovers,
        BelongsToCompany;

    protected $dates = [
        'start_at',
        'end_at',
    ];

    const STATUS_OPEN  = 1;
    const STATUS_CLOSE = 0;

    const STATUS = [
        self::STATUS_OPEN  => '开启',
        self::STATUS_CLOSE => '关闭',
    ];

    /**
     * Notes: 关联授权商品
     * @Author: 玄尘
     * @Date  : 2020/11/30 14:37
     */
    public function items()
    {
        return $this->hasMany(CrowdfundItem::class);
    }

}
