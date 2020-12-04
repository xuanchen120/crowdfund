<?php

namespace XuanChen\CrowdFund\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCollection extends ResourceCollection
{

    /**
     * Notes: 规范所有页面的分页格式
     * @Author: <C.Jason>
     * @Date  : 2020/4/6 4:44 下午
     * @return array
     */
    protected function page()
    {
        return [
            'current'    => $this->currentPage(),
            'total_page' => $this->lastPage(),
            'per_page'   => $this->perPage(),
            'has_more'   => $this->hasMorePages(),
            'total'      => $this->total(),
        ];
    }

}
