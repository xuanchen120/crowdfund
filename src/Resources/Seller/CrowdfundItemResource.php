<?php

namespace XuanChen\CrowdFund\Resources\Seller;

use Illuminate\Http\Resources\Json\JsonResource;

class CrowdfundItemResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'pictures'   => [
                'path'     => $this->pictures,
                'showpath' => $this->pictures_url,
            ],
            'time'       => $this->time,
            'remark'     => $this->remark,
            'shipping'   => $this->shipping,
            'price'      => $this->price,
            'quantity'   => $this->quantity,
            'created_at' => $this->created_at,
        ];
    }

}
