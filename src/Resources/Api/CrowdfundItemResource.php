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
            'time'              => $this->time,
            'remark'            => $this->remark,
            'shipping'          => $this->shipping,
            'price'             => $this->price,
            'quantity'          => $this->quantity > 0 ?: '不限制',
            'type'              => $this->type,
            'created_at'        => (string)$this->created_at,
        ];
    }

}
