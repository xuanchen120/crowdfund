<?php

namespace XuanChen\CrowdFund\Models;

use Carbon\Carbon;
use Jason\Order\Models\Order;
use Jason\Order\Models\OrderItem;
use XuanChen\CrowdFund\Models\Traits\BelongsToCrowdfund;
use Jason\Order\Contracts\ShouldOrder;
use XuanChen\CrowdFund\Models\Traits\HasCovers;

class CrowdfundItem extends Model implements ShouldOrder
{

    use BelongsToCrowdfund, HasCovers;

    protected $casts = [
        'pictures' => 'array',
    ];

    public function crowdfund()
    {
        return $this->belongsTo(Crowdfund::class);
    }

    /**
     * Notes: 获取商品名称
     * @Author: <C.Jason>
     * @Date  : 2019/11/20 3:20 下午
     * @return mixed
     */
    public function getOrderableName()
    {
        return $this->title;
    }

    /**
     * Notes: 获取商品库存
     * @Author: <C.Jason>
     * @Date  : 2019/11/20 3:21 下午
     * @param null $options
     * @return mixed
     */
    public function getOrderableStock($options = null)
    {
        return 99999;
    }

    /**
     * Notes: 扣除库存方法
     * @Author: <C.Jason>
     * @Date  : 2019/11/20 3:21 下午
     * @param      $stock
     * @param null $options
     * @return mixed
     */
    public function deductStock($stock, $options = null)
    {

    }

    /**
     * Notes: 增加库存方法
     * @Author: <C.Jason>
     * @Date  : 2019/11/20 3:21 下午
     * @param      $stock
     * @param null $options
     * @return mixed
     */
    public function addStock($stock, $options = null)
    {

    }

    /**
     * Notes: 获取卖家ID
     * @Author: <C.Jason>
     * @Date  : 2020/9/23 3:55 下午
     * @return mixed
     */
    public function getSellerIdentifier()
    {
        return $this->crowdfund->company_id;
    }

    /**
     * Notes: 获取卖家type
     * @Author: <C.Jason>
     * @Date  : 2020/9/23 3:55 下午
     * @return mixed
     */
    public function getSellerTypeentifier()
    {
        return 'App\Models\Company';
    }

    /**
     * Notes: 获取商品主键
     * @Author: <C.Jason>
     * @Date  : 2020/9/23 3:57 下午
     * @return mixed
     */
    public function getItemIdentifier()
    {
        return $this->id;
    }

    /**
     * Notes: 获取商品单价
     * @Author: <C.Jason>
     * @Date  : 2020/9/23 3:58 下午
     * @return mixed
     */
    public function getItemPrice()
    {
        return $this->price;
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
    public function orderItem()
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
        ])->count();
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
        ])->sum('amount');
    }

}
