<?php

namespace App\Api\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;

class CrowdfundResource extends JsonResource
{

    public function toArray($request)
    {
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
    }

}
