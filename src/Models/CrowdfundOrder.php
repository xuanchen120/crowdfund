<?php

namespace XuanChen\CrowdFund\Models;

use Illuminate\Database\Eloquent\Model;

class CrowdfundOrder extends Model
{

    public function user()
    {
        return $this->belongsTo(config('crowdfund.userModel'));
    }

}
