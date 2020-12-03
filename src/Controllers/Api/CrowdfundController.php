<?php

namespace XuanChen\CrowdFund\Controllers\Api;

use App\Api\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Traits\PayOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Jason\Address\Models\Address;
use XuanChen\CrowdFund\Models\CrowdfundItem;
use XuanChen\CrowdFund\Models\Crowdfund;
use XuanChen\CrowdFund\Resources\Api\CrowdfundCollection;
use XuanChen\CrowdFund\Resources\Api\CrowdfundResource;
use XuanChen\CrowdFund\Resources\Api\CrowdfundItemResource;
use Jason\Order\Order;
use Jason\Order\Item;

class CrowdfundController extends Controller
{

    use PayOrder;

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
                          ->where('start_at', '<=', Carbon::now()->format('Y-m-d'))
                          ->where('end_at', '>=', Carbon::now()->format('Y-m-d'))
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
     * Notes: 参加项目-获取信息
     * @Author: 玄尘
     * @Date  : 2020/12/3 9:02
     * @param \Illuminate\Http\Request $request
     */
    public function create(Request $request)
    {
        $crowdfund_item_id = $request->crowdfund_item_id;
        $info              = CrowdfundItem::find($crowdfund_item_id);

        return $this->success(new CrowdfundItemResource($info));
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
        $price             = $request->price ?? 0;
        $remark            = $request->remark ?? '';
        $address_id        = $request->address_id ?? '';

        try {
            $user = config('crowdfund.Api')::user();

            $info = CrowdfundItem::find($crowdfund_item_id);

            if ($info->type == CrowdfundItem::TYPE_SUPPORT) {
                $info->price = $price;
            }

            if ($address_id) {
                $address = Address::find($address_id);
            }

            if ($info->type == CrowdfundItem::TYPE_GOODS && !$address) {
                return $this->failed('缺少收货地址');
            }

            if (empty($info->price)) {
                return $this->failed('缺少金额');
            }

            $orderItems = [];
            array_push($orderItems, new Item($info, 1));

            $orders = (new Order)->user($user)
                                 ->address($address)
                                 ->remark($remark)
                                 ->type(2)
                                 ->create($orderItems);

            $trade_no = $this->AddPayments($orders);

            return $this->success([
                'trade_no' => $trade_no,
            ]);
        } catch (\Exception $e) {
            return $this->failed('下单失败 ' . $e->getmessage());
        }
    }

}
