<?php

namespace XuanChen\CrowdFund\Models;

use Illuminate\Database\Eloquent\Model;

class CrowdfundOrder extends Model
{

    public function user()
    {
        return $this->belongsTo(config('crowdfund.userModel'));
    }

    /**
     * Notes: 关联店铺
     * @Author: 玄尘
     * @Date  : 2020/12/2 11:27
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store()
    {
        return $this->belongsTo(config('crowdfund.store'));
    }

}
