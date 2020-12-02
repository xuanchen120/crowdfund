<?php

namespace XuanChen\CrowdFund\Controllers\Api;

use App\Api\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use XuanChen\CrowdFund\Models\Crowdfund;
use XuanChen\CrowdFund\Resources\Api\CrowdfundCollection;

class CrowdfundController extends Controller
{

    /**
     * Notes: 文章列表
     * @Author: <C.Jason>
     * @Date  : 2020/11/12 3:17 下午
     */
    public function index(Request $request)
    {
        $company_id = $request->company_id;

        $lists = Crowdfund::latest()
                          ->shown()
                          ->where('company_id', $company_id)
                          ->where('status', 1)
                          ->paginate();

        return $this->success(new CrowdfundCollection($lists));
    }

}
