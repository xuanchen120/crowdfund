<?php

namespace XuanChen\CrowdFund\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToCompany
{

    /**
     * Notes: 关联企业
     * @Author: 玄尘
     * @Date  : 2020/12/2 11:27
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(config('crowdfund.companyModel'));
    }

}
