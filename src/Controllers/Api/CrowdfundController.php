<?php

namespace XuanChen\CrowdFund\Controllers\Api;

use App\Api\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use XuanChen\CrowdFund\Models\CrowdfundItem;
use XuanChen\CrowdFund\Models\Crowdfund;
use XuanChen\CrowdFund\Resources\Api\CrowdfundCollection;
use XuanChen\CrowdFund\Resources\Api\CrowdfundResource;
use XuanChen\CrowdFund\Resources\Api\CrowdfundItemResource;

class CrowdfundController extends Controller
{

    /**
     * Notes: 项目列表
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

    /***
     * Notes: 显示详情
     * @Author: 玄尘
     * @Date  : 2020/12/3 8:14
     * @param \XuanChen\CrowdFund\Models\Crowdfund $crowdfund
     * @return mixed
     */
    public function show($crowdfund)
    {
        $crowdfund = Crowdfund::find($crowdfund);
        if (!$crowdfund) {
            return $this->failed('未找到数据');
        }

        return $this->success(new CrowdfundResource($crowdfund));
    }

    /**
     * Notes: 参加项目
     * @Author: 玄尘
     * @Date  : 2020/12/3 8:15
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $crowdfund_item_id = $request->crowdfund_item_id;
        $info              = CrowdfundItem::where('id', $crowdfund_item_id)->first();
        dd($info);

    }

}
