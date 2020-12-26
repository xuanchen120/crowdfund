<?php

namespace XuanChen\CrowdFund\Controllers\Seller;

use App\Api\Controllers\Controller;
use Illuminate\Http\Request;
use XuanChen\CrowdFund\Models\CrowdfundCategory;

class AjaxController extends Controller
{

    /**
     * Notes: 项目分类
     * @Author: 玄尘
     * @Date  : 2020/12/4 10:15
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function category(Request $request)
    {
        $user = config('crowdfund.Seller')::user();
        if (!$user->company) {
            return $this->failed('未找到企业信息');
        }

        $lists = CrowdfundCategory::shown()
                                  ->where('company_id', $user->company->id)
                                  ->select('title', 'id')
                                  ->get();

        return $this->success($lists);
    }

}
