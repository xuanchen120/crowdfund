<?php

namespace XuanChen\CrowdFund\Controllers\Admin;

use App\Models\Company;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Support\MessageBag;
use XuanChen\CrowdFund\Models\Crowdfund;
use XuanChen\CrowdFund\Models\CrowdfundCategory;
use XuanChen\CrowdFund\Models\CrowdfundItem;
use Jason\Address\Models\Area;

class CrowdfundController extends AdminController
{

    protected $title = '项目众筹';

    protected function grid()
    {
        $grid = new Grid(new Crowdfund());

        $grid->column('id', '#ID#');
        $grid->column('title', '项目名称');
        $grid->column('company.name', '企业名');
        $grid->column('amount', '目标金额');
        $grid->column('status', '状态')
             ->using(Crowdfund::STATUS)
             ->label([
                 Crowdfund::STATUS_OPEN  => 'info',
                 Crowdfund::STATUS_CLOSE => 'success',
                 Crowdfund::STATUS_OVER  => 'danger',
             ]);

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Crowdfund);

        $form->tab('基础信息', function (Form $form) {
            $form->text('title', '标题')->required();

            $form->select('crowdfund_category_id', '所属分类')
                 ->options(CrowdfundCategory::where('status', 1)->pluck('title', 'id'))
                 ->required();

            $form->select('province_id', '行政省份')
                 ->options(Area::where('parent_id', 1)->pluck('name', 'id'))
                 ->load('city_id', route('ajaxes.areas.children'))
                 ->required();

            $form->select('city_id', '行政城市')
                 ->options(function ($option, $info) {
                     if ($option) {
                         return Area::whereHas('parent', function ($q) use ($info) {
                             $q->where('id', $this->province_id);
                         })->pluck('name', 'id');
                     }
                 })
                 ->required();

            $form->textarea('description', '简介')->required();

            $form->multipleImage('pictures', '封面')
                 ->move('images/' . date('Y/m/d'))
                 ->removable()
                 ->uniqueName();

            // 并设置上传文件类型
            $form->file('video', '视频')
                 ->move('videos/' . date('Y/m/d'))
                 ->removable()
                 ->rules('mimes:avi,mkv');

            $companys = config('crowdfund.companyModel')::where('status', 1)
                                                        ->pluck('name', 'id')
                                                        ->toArray();

            $form->select('company_id', '所属企业')
                 ->options($companys)
                 ->required();

            $form->number('amount', '目标金额')->default(1)->required();
            $form->date('start_at', '开始时间')->required();
            $form->date('end_at', '结束时间')->required();
            $form->ueditor('content', '详情')->required();
            $form->switch('status', '状态')->default(1);

        });

        $form->tab('项目回报', function (Form $form) {
            $form->hasMany('items', '项目回报', function (Form\NestedForm $form) {
                $form->text('title', '名称')->required();
                $form->textarea('time', '回报时间')->required();
                $form->ueditor('remark', '回报内容')->required();
                $form->textarea('shipping', '配送说明')->required();

                $form->radio('type', '类型')
                     ->options(CrowdfundItem::TYPES)
                     ->default(CrowdfundItem::TYPE_GOODS)
                     ->required();

                $form->number('price', '金额')
                     ->default(0)
                     ->required()
                     ->help('无偿不需要添加');

                $form->number('quantity', '限制人数')
                     ->default(0)
                     ->help('0为不限制')
                     ->required();
            });
        });

        $form->saving(function (Form $form) {

            if ($form->isCreating() && !isset($form->pictures) && !isset($form->video)) {
                return $this->backErrorMessage('必须上传图片或者视频');
            }

            if (!$form->items) {
                return $this->backErrorMessage('必须添加回报');
            }

        });

        return $form;
    }

    public function backErrorMessage($message)
    {
        $error = new MessageBag([
            'title'   => '错误',
            'message' => $message,
        ]);

        return back()->withInput()->with(compact('error'));
    }

}
