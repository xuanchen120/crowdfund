<?php

namespace XuanChen\CrowdFund\Models;

use XuanChen\CrowdFund\Models\Traits\BelongsToCompany;

class CrowdfundOrder extends Model
{

    use BelongsToCompany;

    public function user()
    {
        return $this->belongsTo(config('crowdfund.userModel'));
    }

}
