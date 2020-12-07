<?php

namespace XuanChen\CrowdFund\Models;

use Carbon\Carbon;
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

    const STATUS_CLOSE   = 0;
    const STATUS_OPEN    = 1;
    const STATUS_COMING  = 2;
    const STATUS_SUCCESS = 3;
    const STATUS_OVER    = 4;

    const STATUS = [
        self::STATUS_CLOSE   => '关闭',
        self::STATUS_OPEN    => '进行中',
        self::STATUS_COMING  => '即将上线',
        self::STATUS_SUCCESS => '已成功',
        self::STATUS_OVER    => '已结束',
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

    /**
     * Notes: 关联分类
     * @Author: 玄尘
     * @Date  : 2020/12/4 8:09
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(CrowdfundCategory::class, 'crowdfund_category_id');
    }

    /**
     * Notes: 是否可以支持
     * @Author: 玄尘
     * @Date  : 2020/12/7 8:59
     * @return bool
     */
    public function canPay()
    {
        return in_array($this->status, [self::STATUS_OPEN]) && $this->end_at->gt(Carbon::now());
    }

    /**
     * Notes: 支持人数
     * @Author: 玄尘
     * @Date  : 2020/12/4 11:42
     */
    public function getAllUsersAttribute()
    {
        return $this->items->sum('all_users');
    }

    /**
     * Notes: 支持金额
     * @Author: 玄尘
     * @Date  : 2020/12/4 11:42
     */
    public function getAllTotalAttribute()
    {
        return $this->items->sum('all_total');
    }

    /**
     * Notes: 倒计时
     * @Author: 玄尘
     * @Date  : 2020/12/4 16:57
     */
    public function diffForHumans()
    {
        if ($this->start_at->gt(Carbon::now())) {
            $seconds = (int)$this->start_at->diffInSeconds(Carbon::now(), true);

            $duration = '';

            if ($seconds <= 0) {
                return $duration . '0秒';
            }

            [$day, $hour, $minute, $second] = explode(' ', gmstrftime('%j %H %M %S', $seconds));

            $day -= 1;

            if ($day > 0) {
                $duration .= (int)$day . '天';
            }
            if ($hour > 0) {
                $duration .= (int)$hour . '小时';
            }

            if ($minute > 0) {
                $duration .= (int)$minute . '分钟';
            }

            if ($second > 0) {
                $duration .= (int)$second . '秒';
            }

            return $duration;
        }

        return '0秒';

    }

}
