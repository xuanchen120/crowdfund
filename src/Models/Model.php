<?php

namespace XuanChen\CrowdFund\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;

class Model extends \Illuminate\Database\Eloquent\Model
{

    use DefaultDatetimeFormat;

    protected $guarded = [];

    /**
     * Notes: 正常显示的数据
     * @Author: <C.Jason>
     * @Date  : 2020/11/9 3:05 下午
     * @param $query
     * @return mixed
     */
    public function scopeShown($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Notes: 不显示的数据
     * @Author: <C.Jason>
     * @Date  : 2020/11/9 3:06 下午
     * @param $query
     * @return mixed
     */
    public function scopeUnShown($query)
    {
        return $query->where('status', 0);
    }

}
