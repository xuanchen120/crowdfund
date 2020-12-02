<?php

namespace XuanChen\CrowdFund\Resources\Api;

use App\Api\Resources\BaseCollection;

class CrowdfundCollection extends BaseCollection
{

    public function toArray($request)
    {
        $lists = $this->collection->map(function ($crowdfund) {
            return [
                'crowdfund_id' => $crowdfund->id,
                'title'        => $crowdfund->title,
                'cover'        => $crowdfund->cover_url,
                'amount'       => $crowdfund->amount,
                'description'  => (string)$crowdfund->description,
                'status_text'  => (string)$crowdfund->status_text,
                'start_at'     => $crowdfund->start_at->format('Y-m-d H:i:s'),
                'end_at'       => $crowdfund->end_at->format('Y-m-d H:i:s'),
                'created_at'   => $crowdfund->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return $lists;
    }

}
