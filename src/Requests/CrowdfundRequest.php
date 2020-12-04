<?php

namespace XuanChen\CrowdFund\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrowdfundRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title'                 => 'required',
            'crowdfund_category_id' => 'required',
            'province_id'           => 'required',
            'city_id'               => 'required',
            'description'           => 'required',
            'content'               => 'required',
            'amount'                => 'required',
            'start_at'              => 'required',
            'end_at'                => 'required',
            'status'                => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'                 => '项目标题必须填写',
            'crowdfund_category_id.required' => '分类必须选择',
            'province_id.required'           => '省份必须选择',
            'city_id.required'               => '城市必须选择',
            'description.required'           => '简介必须填写',
            'pictures.required'              => '企业经营范围必须填写',
            'amount.required'                => '目标金额必须填写',
            'start_at.required'              => '开始时间必须填写',
            'end_at.required'                => '结束时间必须填写',
            'content.required'               => '详情范围必须填写',
            'status.required'                => '状态必须填写',
        ];
    }

}
