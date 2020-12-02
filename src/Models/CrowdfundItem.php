<?php

namespace XuanChen\CrowdFund\Models;

use Illuminate\Database\Eloquent\Model;
use XuanChen\CrowdFund\Models\Traits\BelongsToCrowdfund;

class CrowdfundItem extends Model
{

    use BelongsToCrowdfund;

    protected $guarded = [];

    public function crowdfund()
    {
        return $this->belongsTo(Crowdfund::class);
    }

}
