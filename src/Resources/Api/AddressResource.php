<?php

namespace XuanChen\CrowdFund\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'address_id' => $this->id,
            "user_id"    => $this->user_id,
            "name"       => $this->name,
            "mobile"     => $this->mobile,
            "province"   => $this->province->name,
            "city"       => $this->city->name,
            "district"   => $this->district->name,
            "address"    => $this->address,
            "created_at" => (string)$this->created_at,
        ];
    }

}
