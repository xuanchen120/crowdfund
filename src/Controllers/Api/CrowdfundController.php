<?php

namespace XuanChen\CrowdFund\Controllers\Api;

use App\Api\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Traits\PayOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Jason\Address\Models\Address;
use Jason\Api\Api;
use XuanChen\CrowdFund\Models\CrowdfundItem;
use XuanChen\CrowdFund\Models\Crowdfund;
use XuanChen\CrowdFund\Resources\Api\CrowdfundCollection;
use XuanChen\CrowdFund\Resources\Api\CrowdfundResource;
use XuanChen\CrowdFund\Resources\Api\AddressResource;
use XuanChen\CrowdFund\Resources\Api\CrowdfundItemResource;
use Jason\Order\Item;
use Carbon\Carbon;
use Jason\Order\Facades\Order;

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
        $company_id  = $request->company_id;
        $category_id = $request->category_id;
        $handpick    = $request->handpick;

        $lists = Crowdfund::withCount(['likes'])->where('company_id', $company_id)
                          ->when($category_id, function ($q) use ($category_id) {
                              $q->where('crowdfund_category_id', $category_id);
                          })
                          ->when($handpick, function ($q) use ($handpick) {
                              $q->where('handpick', $handpick);
                          })
                          ->where('status', Crowdfund::STATUS_OPEN)
                          ->orderBy('created_at', 'desc')
                          ->paginate();

        $data = new CrowdfundCollection($lists);

        return $this->success($data);
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

        $data = [
            'info'    => new CrowdfundItemResource($info),
            'address' => AddressResource::collection(config('crowdfund.Api')::user()->addresses),
        ];

        return $this->success($data);
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

            if (!$info->canPay()) {
                return $this->failed('创建订单失败,当前状态不可支持');
            }

            if ($address_id) {
                $address = Address::find($address_id);
            }

            if (!$address) {
                return $this->failed('缺少收货地址');
            }

            if (empty($info->price)) {
                return $this->failed('缺少金额');
            }

            $orderItems = [];
            array_push($orderItems, new Item($info, 1));

            $orders = Order::user($user)
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

    /**
     * Notes: description
     * @Author: 玄尘
     * @Date  : 2020/12/3 16:33
     */
    public function like(Request $request)
    {
        $user = config('crowdfund.Api')::user();

        $crowdfund_id = $request->crowdfund_id;
        $info         = Crowdfund::find($crowdfund_id);

        if (!$info) {
            return $this->failed('未找到数据');
        }

        $user->like($info);
        $data = [
            'likes' => $info->likes()->count(),
        ];

        return $this->success($data);
    }

    /**
     * Notes: 取消关注
     * @Author: 玄尘
     * @Date  : 2020/12/3 17:02
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function unlike(Request $request)
    {
        $user = config('crowdfund.Api')::user();

        $crowdfund_id = $request->crowdfund_id;
        $info         = Crowdfund::find($crowdfund_id);

        if (!$info) {
            return $this->failed('未找到数据');
        }

        $res = $user->unlike($info);

        return $this->success('取消关注成功');
    }

}
