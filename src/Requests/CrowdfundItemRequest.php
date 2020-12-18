<?php

namespace XuanChen\CrowdFund\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrowdfundItemRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title'    => 'required',
            'pictures' => 'required',
            'time'     => 'required',
            'remark'   => 'required',
            'shipping' => 'required',
            'price'    => 'required',
            'quantity' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'    => '项目回报标题必须填写',
            'pictures.required' => '缺少图片',
            'time.required'     => '缺少回报时间',
            'remark.required'   => '缺少回报说明',
            'shipping.required' => '缺少配送说明',
            'price.required'    => '缺少价格',
            'quantity.required' => '缺少限制人数',
        ];
    }

}
