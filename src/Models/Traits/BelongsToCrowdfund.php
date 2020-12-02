<?php

namespace XuanChen\CrowdFund\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use XuanChen\CrowdFund\Models\Crowdfund;

trait BelongsToCrowdfund
{

    public function crowdfund(): BelongsTo
    {
        return $this->belongsTo(Crowdfund::class);
    }

}
