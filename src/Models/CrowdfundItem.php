<?php

namespace XuanChen\CrowdFund\Models;

use XuanChen\CrowdFund\Models\Traits\BelongsToCrowdfund;

class CrowdfundItem extends Model
{

    use BelongsToCrowdfund;

    public function crowdfund()
    {
        return $this->belongsTo(Crowdfund::class);
    }

}
