<?php

namespace XuanChen\CrowdFund\Models;

use XuanChen\CrowdFund\Models\Traits\BelongsToCompany;
use XuanChen\CrowdFund\Models\Traits\HasCovers;
use Jason\Address\Traits\HasArea;
use Overtrue\LaravelLike\Traits\Likeable;

class Crowdfund extends Model
{

    use HasCovers,
        BelongsToCompany,
        HasArea,
        Likeable;

    protected $dates = [
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'pictures' => 'array',
    ];

    const STATUS_OPEN  = 1;
    const STATUS_CLOSE = 0;
    const STATUS_OVER  = 2;

    const STATUS = [
        self::STATUS_OPEN  => '开启',
        self::STATUS_CLOSE => '关闭',
        self::STATUS_OVER  => '完成',
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

    public function getStatusTextAttribute()
    {
        return self::STATUS[$this->status] ?? '未知';
    }

    public function category()
    {
        return $this->belongsTo(CrowdfundCategory::class, 'crowdfund_category_id');
    }

}
