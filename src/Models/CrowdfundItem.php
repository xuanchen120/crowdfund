<?php

namespace XuanChen\CrowdFund\Models;

use Illuminate\Database\Eloquent\Model;

class CrowdfundItem extends Model
{

    protected $guarded = [];

    public function crowdfund()
    {
        return $this->belongsTo(Crowdfund::class);
    }

}
