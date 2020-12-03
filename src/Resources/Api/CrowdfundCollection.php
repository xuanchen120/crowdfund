<?php

namespace XuanChen\CrowdFund\Resources\Api;

use App\Api\Resources\BaseCollection;
use Carbon\Carbon;

class CrowdfundCollection extends BaseCollection
{

    public function toArray($request)
    {
        $lists = $this->collection->map(function ($crowdfund) {
            return [
                'crowdfund_id' => $crowdfund->id,
                'title'        => $crowdfund->title,
                'cover'        => $crowdfund->one_cover,
                'amount'       => $crowdfund->amount,//目标金额
                'total'        => $crowdfund->total,//筹集金额
                'description'  => (string)$crowdfund->description,
                'city'         => (string)$crowdfund->city->name ?? '',
                'category'     => $crowdfund->category->title,
                'status_text'  => (string)$crowdfund->status_text,
                'diffDays'     => $crowdfund->end_at->diffInDays(Carbon::now()),
                'start_at'     => $crowdfund->start_at->format('Y-m-d H:i:s'),
                'end_at'       => $crowdfund->end_at->format('Y-m-d H:i:s'),
                'created_at'   => $crowdfund->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return $lists;
    }

}
