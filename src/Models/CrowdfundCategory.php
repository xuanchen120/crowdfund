<?php

namespace XuanChen\CrowdFund\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use XuanChen\CrowdFund\Models\Traits\BelongsToCompany;

class CrowdfundCategory extends Model
{

    use AdminBuilder,
        BelongsToCompany,
        ModelTree;
    
}
