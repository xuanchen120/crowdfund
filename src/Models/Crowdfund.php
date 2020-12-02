<?php

namespace XuanChen\CrowdFund\Models;

use Illuminate\Database\Eloquent\Model;
use XuanChen\CrowdFund\Models\Traits\HasCovers;

class Crowdfund extends Model
{

    use HasCovers;

    protected $guarded = [];

    protected $dates   = [
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
     * Notes: 关联店铺
     * @Author: 玄尘
     * @Date  : 2020/12/2 11:27
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store()
    {
        return $this->belongsTo(config('crowdfund.store'));
    }

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
