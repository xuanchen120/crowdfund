<?php

namespace XuanChen\CrowdFund\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jason\Order\Models\Order;
use Jason\Order\Models\OrderItem;
use XuanChen\CrowdFund\Models\Traits\BelongsToCrowdfund;
use Jason\Order\Contracts\ShouldOrder;
use XuanChen\CrowdFund\Models\Traits\HasCovers;
use XuanChen\CrowdFund\Models\Traits\ItemHasAttribute;

class CrowdfundItem extends Model implements ShouldOrder
{

    use BelongsToCrowdfund,
        HasCovers,
        ItemHasAttribute,
        SoftDeletes;

    protected $casts = [
        'pictures' => 'array',
    ];

    public function crowdfund()
    {
        return $this->belongsTo(Crowdfund::class);
    }

    /**
     * Notes: 是否可以购买
     * @Author: 玄尘
     * @Date  : 2020/12/4 11:09
     * @return mixed
     */
    public function canPay()
    {
        return $this->crowdfund->canPay();
    }

    /**
     * Notes: 关联订单商品表
     * @Author: 玄尘
     * @Date  : 2020/12/4 11:10
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function orderitem()
    {
        return $this->morphOne(OrderItem::class, 'item');

    }

    /**
     * Notes: 支持
     * @Author: 玄尘
     * @Date  : 2020/12/4 11:11
     */
    public function getAllUsersAttribute()
    {
        return Order::whereHas('items', function ($q) {
                $q->where('item_type', get_class($this))->where('item_id', $this->id);
            })->whereIn('state', [
                Order::ORDER_PAID,
                Order::ORDER_DELIVER,
                Order::ORDER_DELIVERED,
                Order::ORDER_SIGNED,
            ])->count() ?? 0;
    }

    /**
     * Notes: 支持金额
     * @Author: 玄尘
     * @Date  : 2020/12/4 11:11
     */
    public function getAllTotalAttribute()
    {
        return Order::whereHas('items', function ($q) {
                $q->where('item_type', get_class($this))->where('item_id', $this->id);
            })->whereIn('state', [
                Order::ORDER_PAID,
                Order::ORDER_DELIVER,
                Order::ORDER_DELIVERED,
                Order::ORDER_SIGNED,
            ])->sum('amount') ?? 0;
    }

}
