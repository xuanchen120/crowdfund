<?php

namespace XuanChen\CrowdFund\Resources\Seller;

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
                'description'  => $crowdfund->description ?? '',
                'created_at'   => $crowdfund->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return $lists;
    }

}
