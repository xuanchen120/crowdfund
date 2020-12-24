<?php

namespace XuanChen\CrowdFund\Controllers\Seller;

use App\Api\Controllers\Controller;
use App\Models\Coupon;
use Jason\Address\Models\Area;
use XuanChen\CrowdFund\Models\Crowdfund;
use Illuminate\Http\Request;
use XuanChen\CrowdFund\Models\CrowdfundItem;
use XuanChen\CrowdFund\Requests\CrowdfundItemRequest;
use XuanChen\CrowdFund\Resources\Seller\CrowdfundCollection;
use App\Seller\Resources\Area\AreaResource;
use XuanChen\CrowdFund\Resources\Seller\CrowdfundItemResource;
use XuanChen\CrowdFund\Resources\Seller\CrowdfundResource;
use XuanChen\CrowdFund\Requests\CrowdfundRequest;

class CrowdfundController extends Controller
{

    /**
     * Notes: 列表
     * @Author: 玄尘
     * @Date  : 2020/12/4 10:46
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $status      = $request->status;
        $category_id = $request->category_id;
        $title       = $request->title;
        $perPage     = $request->perPage ?? 15;

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
                          ->when(!empty($status), function ($q) use ($status) {
                              $q->where('status', $status);
                          })
                          ->when($title, function ($q) use ($title) {
                              $q->where('title', $title);
                          })
                          ->paginate($perPage);

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

            if ($info = Crowdfund::create($data)) {

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
     * @Date  : 2020/12/18 15:15
     * @param \XuanChen\CrowdFund\Models\Crowdfund $crowdfund
     * @return mixed|\XuanChen\CrowdFund\Models\Crowdfund
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
     * @param \XuanChen\CrowdFund\Models\Crowdfund $crowdfund
     * @param \Illuminate\Http\Request             $request
     */
    public function update(CrowdfundRequest $request, $crowdfund)
    {
        $data = $request->all();
        $info = Crowdfund::find($crowdfund);
        if (!$info) {
            return $this->failed('数据获取失败');
        }

        if ($info->update($data)) {
            return $this->success('编辑成功');
        }

        return $this->failed('编辑失败');

    }

    /**
     * Notes: 删除
     * @Author: 玄尘
     * @Date  : 2020/12/18 15:20
     * @param $crowdfund
     * @return mixed
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

    /**
     * Notes: 回报列表
     * @Author: 玄尘
     * @Date  : 2020/12/18 15:18
     * @param \Illuminate\Http\Request $request
     * @param                          $crowdfund_id
     * @return mixed
     */
    public function items(Request $request, $crowdfund_id)
    {
        $info = Crowdfund::find($crowdfund_id);
        if (!$info) {
            return $this->failed('未查到数据');
        }

        return $this->success(CrowdfundItemResource::collection($info->items));
    }

    /**
     * Notes: 添加回报
     * @Author: 玄尘
     * @Date  : 2020/12/18 15:20
     * @param                                                   $crowdfund_id
     * @param \XuanChen\CrowdFund\Requests\CrowdfundItemRequest $request
     * @return mixed
     */
    public function createItem($crowdfund_id, CrowdfundItemRequest $request)
    {
        $info = Crowdfund::find($crowdfund_id);
        if (!$info) {
            return $this->failed('未查到数据');
        }

        if ($info->items()->create($request->all())) {
            return $this->success('添加成功');
        }

        return $this->failed('添加失败');
    }

    /**
     * Notes: 编辑回报-获取信息
     * @Author: 玄尘
     * @Date  : 2020/12/18 15:19
     * @param $item_id
     * @return mixed
     */
    public function itemShow($item_id)
    {
        $info = CrowdfundItem::find($item_id);
        if (!$info) {
            return $this->failed('未查到数据');
        }

        return $this->success(new CrowdfundItemResource($info));
    }

    /**
     * Notes: 修改回报
     * @Author: 玄尘
     * @Date  : 2020/12/18 15:19
     * @param                                                   $item_id
     * @param \XuanChen\CrowdFund\Requests\CrowdfundItemRequest $request
     * @return mixed
     */
    public function itemStore($item_id, CrowdfundItemRequest $request)
    {
        $info = CrowdfundItem::find($item_id);
        if (!$info) {
            return $this->failed('未查到数据');
        }

        if ($info->update($request->all())) {
            return $this->success('编辑成功');
        }

        return $this->failed('编辑失败');
    }

    /**
     * Notes: 删除回报
     * @Author: 玄尘
     * @Date  : 2020/12/18 15:19
     * @param $item_id
     * @return mixed
     */
    public function delItem($item_id)
    {
        $info = CrowdfundItem::find($item_id);
        if (!$info) {
            return $this->failed('未查到数据');
        }

        if ($info->delete()) {
            return $this->success('删除成功');
        }

        return $this->failed('删除失败');
    }

}
