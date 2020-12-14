<?php

namespace XuanChen\CrowdFund\Controllers\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Jason\Order\Models\Order;
use Encore\Admin\Facades\Admin;
use XuanChen\CrowdFund\Events\CrowdfundOrderRefund;

class Refund extends RowAction
{

    public $name = '退款';

    public function handle(Model $model)
    {
        try {
            $orders = Order::where('state', Order::ORDER_PAID)
                           ->whereHas('items', function ($q) use ($model) {
                               $q->where('item_type', 'XuanChen\CrowdFund\Models\CrowdfundItem')
                                 ->whereIn('item_id', $model->items()->pluck('id')->toArray());
                           })->get();

            $admin = Admin::user();

            if ($orders->isNotEmpty()) {
                foreach ($orders as $order) {
                    event(new CrowdfundOrderRefund($order, $admin));
                }

                return $this->response()->success('操作成功')->refresh();
            } else {
                return $this->response()->error('操作失败，没有可操作的订单')->refresh();
            }
        } catch (\Exception $e) {
            return $this->response()->error($e->getMessage())->refresh();
        }

    }

    public function dialog()
    {
        $this->confirm('您确定要退款吗');
    }

}
