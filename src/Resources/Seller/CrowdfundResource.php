<?php

namespace XuanChen\CrowdFund\Resources\Seller;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CrowdfundResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'title'                 => $this->title,
            'crowdfund_category_id' => $this->crowdfund_category_id,
            'pictures'              => $this->pictures,
            'video'                 => $this->video,
            'amount'                => $this->amount,//目标金额
            'items'                 => CrowdfundItemResource::collection($this->items),
            'description'           => $this->description,
            'content'               => $this->content,
            'status'                => $this->status,
            'province_id'           => $this->province_id,
            'city_id'               => $this->city_id,
            'likes'                 => $this->likes_count,
            'start_at'              => (string)$this->start_at,
            'end_at'                => (string)$this->end_at,
            'created_at'            => (string)$this->created_at,
        ];
    }

}
