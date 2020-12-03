<?php

namespace XuanChen\CrowdFund\Controllers\Admin;

use App\Models\Company;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use XuanChen\CrowdFund\Models\Crowdfund;

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

            $form->textarea('description', '简介')->required();

            $form->image('cover', '封面')
                 ->move('images/' . date('Y/m/d'))
                 ->removable()
                 ->uniqueName();

            $companys = config('crowdfund.companyModel')::where('status', 1)
                                                        ->pluck('name', 'id')
                                                        ->toArray();

            $form->select('company_id', '所属企业')
                 ->options($companys)
                 ->required();

            $form->number('amount', '目标金额')->default(1)->required();
            $form->date('start_at', '开始时间')->required();
            $form->date('end_at', '结束时间')->required();
            $form->switch('status', '状态')->default(1);
            $form->ueditor('content', '详情');
        });

        $form->tab('项目回报', function (Form $form) {
            $form->hasMany('items', '项目回报', function (Form\NestedForm $form) {
                $form->text('title', '名称');
                $form->textarea('time', '回报时间');
                $form->textarea('content', '回报内容');
                $form->textarea('shipping', '配送说明');
                $form->number('price', '金额')->default(1);
                $form->number('quantity', '限制人数')->default(1)->help('0为不限制');
            });
        });

        return $form;
    }

}
