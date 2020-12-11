<?php

namespace XuanChen\CrowdFund\Controllers\Seller;

use App\Api\Controllers\Controller;
use Jason\Address\Models\Area;
use XuanChen\CrowdFund\Models\Crowdfund;
use Illuminate\Http\Request;
use XuanChen\CrowdFund\Resources\Seller\CrowdfundCollection;
use App\Seller\Resources\Area\AreaResource;
use XuanChen\CrowdFund\Resources\Seller\CrowdfundResource;
use XuanChen\CrowdFund\Requests\CrowdfundRequest;

class CrowdfundController extends Controller
{

    /**
     * Notes: 列表
     * @Author: 玄尘
     * @Date  : 2020/12/4 10:46
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $status      = $request->status;
        $category_id = $request->category_id;
        $title       = $request->title;

        $user = config('crowdfund.Seller')::user();

        $company = $user->company;

        if (!$company) {
            return $this->failed('您还没有进行企业认证。');
        }
        $lists = Crowdfund::latest()
                          ->withCount(['likes'])
                          ->where('company_id', $company->id)
                          ->when($category_id, function ($q) use ($category_id) {
                              $q->where('category_id', $category_id);
                          })
                          ->when($status, function ($q) use ($status) {
                              $q->where('status', $status);
                          })
                          ->when($title, function ($q) use ($title) {
                              $q->where('title', $title);
                          })
                          ->paginate();

        return $this->success(new CrowdfundCollection($lists));

    }

    /**
     * Notes: 添加的前置接口
     * @Author: 玄尘
     * @Date  : 2020/12/4 13:24
     */
    public function create()
    {
        $data = [
            'province' => AreaResource::collection(Area::where('parent_id', 1)->get()),
        ];

        return $this->success($data);
    }

    /**
     * Notes: 添加
     * @Author: 玄尘
     * @Date  : 2020/12/4 10:46
     */
    public function store(CrowdfundRequest $request)
    {
        try {
            $user    = config('crowdfund.Seller')::user();
            $company = $user->company;

            $data               = $request->all();
            $data['company_id'] = $company->id;

            if (empty($data['video']) && empty($data['pictures'])) {
                return $this->failed('图片和视频必须上传一种');
            }

            if (Crowdfund::create($data)) {
                return $this->success('添加成功');
            }

            return $this->failed('添加失败');
        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }

    }

    /**
     * Notes: description
     * @Author: 玄尘
     * @Date  : 2020/12/4 13:18
     */
    public function edit($crowdfund)
    {
        $info = Crowdfund::find($crowdfund);
        if (!$info) {
            return $this->failed('未找到信息');
        }

        $data = [
            'province' => AreaResource::collection(Area::where('parent_id', 1)->get()),
            'city'     => AreaResource::collection(Area::where('parent_id', $info->province_id)->get()),
            'info'     => new CrowdfundResource($info),
        ];

        return $this->success($data);
    }

    /**
     * Notes: 更新
     * @Author: 玄尘
     * @Date  : 2020/12/4 10:50
     * @param  \XuanChen\CrowdFund\Models\Crowdfund  $crowdfund
     * @param  \Illuminate\Http\Request              $request
     */
    public function update(CrowdfundRequest $request, Crowdfund $crowdfund)
    {
        $data = $request->all();
        if ($crowdfund->update($data)) {
            return $this->success('编辑成功');
        }

        return $this->failed('编辑失败');

    }

    /**
     * Notes: 删除
     * @Author: 玄尘
     * @Date  : 2020/12/4 10:47
     * @param  \XuanChen\CrowdFund\Models\Crowdfund  $crowdfund
     */
    public function destroy($crowdfund)
    {
        $info = Crowdfund::find($crowdfund);
        if (!$info) {
            return $this->failed('数据获取失败');
        }

        if ($info->delete()) {
            return $this->success('删除成功');
        }

        return $this->failed('删除失败');
    }

}
