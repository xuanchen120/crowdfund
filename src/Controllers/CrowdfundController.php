<?php

namespace XuanChen\CrowdFund\Controllers;

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
        $grid->column('store.name', '店铺名');
        $grid->column('amount', '目标金额');
        $grid->status('状态')->switch([
            'on'  => ['value' => 1, 'text' => '开启', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
        ]);

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Crowdfund);

        $form->text('title', '标题')->required();

        $form->image('cover', '封面')
             ->move('images/' . date('Y/m/d'))
             ->removable()
             ->uniqueName();

        $stores = Store::where('status', Store::STATUS_SUCCESS)
                       ->pluck('name', 'id')
                       ->toArray();

        $form->select('store_id', '所属店铺')
             ->options($stores)
             ->required();

        $form->number('amount', '目标金额')->default(1)->required();
        $form->date('start_at', '开始时间')->required();
        $form->date('end_at', '结束时间')->required();
        $form->switch('status', '状态')->default(1);

        $form->hasMany('items', '项目回报', function (Form\NestedForm $form) {
            $form->text('title', '名称');
            $form->textarea('time', '回报时间');
            $form->textarea('content', '回报内容');
            $form->textarea('shipping', '配送说明');
            $form->number('price', '金额');
            $form->number('quantity', '限制人数')->help('0为不限制');
        });

        return $form;
    }

}
