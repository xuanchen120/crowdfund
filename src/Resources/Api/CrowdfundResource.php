<?php

namespace XuanChen\CrowdFund\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CrowdfundResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'crowdfund_id' => $this->id,
            'title'        => $this->title,
            'pictures'     => $this->pictures_url,
            'video_url'    => (string)$this->video_url,
            'amount'       => $this->amount,//目标金额
            'all_total'    => $this->all_total,//支持金额
            'all_users'    => $this->all_users,//支持人数
            'items'        => CrowdfundItemResource::collection($this->items),
            'description'  => $this->description,
            'content'      => $this->content,
            'status_text'  => $this->status_text,
            'status'       => $this->status,
            'category'     => $this->category ? $this->category->title : '',
            'endDiffDays'  => $this->end_at->diffInDays(Carbon::now()),
            'diffDays'     => $this->end_at->diffInDays($this->start_at),
            'province'     => $this->province->name,
            'city'         => $this->city->name,
            'likes'        => $this->likes_count ?? 0,
            'isLike'       => $this->isLikedBy(config('crowdfund.Api')::user()),
            'canPay'       => $this->canPay(),
            'start_at'     => (string)$this->start_at,
            'end_at'       => (string)$this->end_at,
            'created_at'   => (string)$this->created_at,
        ];
    }

}
