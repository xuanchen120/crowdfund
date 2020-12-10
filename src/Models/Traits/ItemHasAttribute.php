<?php

namespace XuanChen\CrowdFund\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

trait ItemHasAttribute
{

    /**
     * Notes: 获取商品名称
     * @Author: <C.Jason>
     * @Date  : 2019/11/20 3:20 下午
     * @return mixed
     */
    public function getOrderableName()
    {
        return $this->crowdfund->title;
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
     * Notes: 获取规格名称
     * @Author: 玄尘
     * @Date  : 2020/12/7 16:33
     * @return mixed|string
     */
    public function getItemValue()
    {
        return $this->title;
    }

}
