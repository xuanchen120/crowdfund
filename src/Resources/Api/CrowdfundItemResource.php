<?php

namespace XuanChen\CrowdFund\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CrowdfundItemResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'crowdfund_item_id' => $this->id,
            'title'             => $this->title,
            'pictures'          => $this->pictures_url,
            'time'              => $this->time,
            'remark'            => $this->remark,
            'shipping'          => $this->shipping,
            'price'             => $this->price,
            'quantity'          => $this->quantity > 0 ? $this->quantity : '不限制',
            'all_users'         => $this->all_users,
            'all_total'         => $this->all_total,
            'canPay'            => $this->canPay(),
            'created_at'        => (string)$this->created_at,
        ];
    }

}
