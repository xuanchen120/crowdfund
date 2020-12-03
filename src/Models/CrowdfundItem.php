<?php

namespace XuanChen\CrowdFund\Models;

use XuanChen\CrowdFund\Models\Traits\BelongsToCrowdfund;
use Jason\Order\Contracts\ShouldOrder;

class CrowdfundItem extends Model implements ShouldOrder
{

    use BelongsToCrowdfund;

    const TYPE_GOODS   = 1;
    const TYPE_SUPPORT = 2;

    const TYPES = [
        self::TYPE_GOODS   => '有偿',
        self::TYPE_SUPPORT => '无偿',
    ];

    public function crowdfund()
    {
        return $this->belongsTo(Crowdfund::class);
    }

    public function getTypeTextAttribute()
    {
        return self::TYPES[$this->type] ?? '未知';
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

}
