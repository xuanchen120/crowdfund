<?php

namespace XuanChen\CrowdFund\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CrowdfundResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'crowdfund_id' => $this->id,
            'title'        => $this->title,
            'pictures'     => $this->pictures_url,
            'video_url'    => $this->video_url,
            'amount'       => $this->amount,
            'items'        => CrowdfundItemResource::collection($this->items),
            'description'  => (string)$this->description,
            'status_text'  => (string)$this->status_text,
            'start_at'     => (string)$this->start_at,
            'end_at'       => (string)$this->end_at,
            'created_at'   => (string)$this->created_at,
        ];
    }

}
