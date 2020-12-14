<?php

namespace XuanChen\CrowdFund\Events;

use Illuminate\Queue\SerializesModels;
use Jason\Order\Models\Order;

class CrowdfundOrderRefund
{

    use  SerializesModels;

    public $order;

    public $user;

    public $request;

    /**
     * CrowdfundOrderRefund constructor.
     * @param \Jason\Order\Order $order
     */
    public function __construct(Order $order, $user)
    {
        $this->order = $order;
        $this->user  = $user;
    }

}
