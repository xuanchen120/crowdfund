<?php

namespace XuanChen\CrowdFund\Resources\Api;

use Carbon\Carbon;
use XuanChen\CrowdFund\Resources\BaseCollection;

class CrowdfundCollection extends BaseCollection
{

    public function toArray($request)
    {

        return [
            'data' => $this->collection->map(function ($crowdfund) {
                return [
                    'crowdfund_id' => $crowdfund->id,
                    'title'        => $crowdfund->title,
                    'cover'        => $crowdfund->one_cover,
                    'amount'       => $crowdfund->amount,//目标金额
                    'all_total'    => $crowdfund->all_total,//筹集金额
                    'all_users'    => $crowdfund->all_users,//筹集金额
                    //                'description'  => (string)$crowdfund->description,
                    'city'         => (string)$crowdfund->city->name ?? '',
                    'category'     => $crowdfund->category->title,
                    'status_text'  => $crowdfund->status_text,
                    'status'       => $crowdfund->status,
                    'diffDays'     => $crowdfund->end_at->diffInDays(Carbon::now()),
                    'openDiffDays' => $crowdfund->diffForHumans(),
                    'likes'        => $crowdfund->likes_count,
                    //                    'start_at'     => $crowdfund->start_at->format('Y-m-d H:i:s'),
                    //                    'end_at'       => $crowdfund->end_at->format('Y-m-d H:i:s'),
                    //                    'created_at'   => $crowdfund->created_at->format('Y-m-d H:i:s'),
                ];
            }),
            'page' => $this->page(),
        ];

    }

}
