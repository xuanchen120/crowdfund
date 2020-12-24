<?php

namespace XuanChen\CrowdFund\Controllers\Admin;

use App\Admin\Actions\Order\OrderCancel;
use App\Admin\Actions\Order\OrderDeliver;
use App\Admin\Actions\Order\OrderPaid;
use App\Models\Company;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Support\MessageBag;
use XuanChen\CrowdFund\Models\Crowdfund;
use XuanChen\CrowdFund\Models\CrowdfundCategory;
use XuanChen\CrowdFund\Models\CrowdfundItem;
use Jason\Address\Models\Area;
use XuanChen\CrowdFund\Controllers\Actions\Refund;

class CrowdfundController extends AdminController
{

    protected $title = '项目众筹';

    protected function grid()
    {
        $grid = new Grid(new Crowdfund());
        $grid->model()->withCount('items')->latest();

        $grid->actions(function ($actions) {
            $actions->disableView();

            if ($actions->row->code == 4) {
                $actions->add(new Refund);
            }

        });

        $grid->filter(function (Grid\Filter $filter) {
            $filter->column(1 / 2, function (Grid\Filter $filter) {
                $filter->like('title', '项目名称');
                $filter->like('company.name', '企业名');
            });

            $filter->column(1 / 2, function (Grid\Filter $filter) {
                $filter->equal('category.id', '分类')
                       ->select(CrowdfundCategory::where('status', 1)->pluck('title', 'id'));

                $filter->equal('handpick', '精选')->radio([
                    '' => '全部',
                    1  => '是',
                    0  => '否',
                ]);
            });
        });

        $grid->column('id', '#ID#');
        $grid->column('title', '项目名称');
        $grid->column('company.name', '企业名');
        $grid->column('category.title', '分类');
        $grid->column('amount', '目标金额');
        $grid->column('status', '状态')
             ->using(Crowdfund::STATUS)
             ->label([
                 Crowdfund::STATUS_OPEN   => 'success',
                 Crowdfund::STATUS_CLOSE  => 'info',
                 Crowdfund::STATUS_REFUND => 'error',
             ]);

        $grid->column('回报数量')->display(function () {
            return $this->items_count;
        });

        $grid->column('状态码')
             ->display(function () {
                 return $this->code_text;
             });

        $grid->column('支持人数')->display(function () {
            return $this->all_users;
        });

        $grid->column('支持金额')->display(function () {
            return $this->all_total;
        });

        $grid->column('handpick', '精选')
             ->bool();

        $grid->column('start_at', '开始时间');
        $grid->column('end_at', '结束时间');
        $grid->column('created_at', '添加时间');

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
                 ->move('images/crowdfund/' . date('Y/m/d'))
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
            $form->datetime('start_at', '开始时间')->required();
            $form->datetime('end_at', '结束时间')->required();
            $form->ueditor('content', '详情')->required();
            $form->switch('status', '状态')->default(1);
            $form->switch('handpick', '精选')->default(0);

        });

        $form->tab('项目回报', function (Form $form) {
            $form->hasMany('items', '项目回报', function (Form\NestedForm $form) {
                $form->text('title', '名称')->required();
                $form->multipleImage('pictures', '封面')
                     ->move('images/crowdfund/items/' . date('Y/m/d'))
                     ->removable()
                     ->uniqueName();

                $form->textarea('time', '回报时间')->required();
                $form->textarea('remark', '回报内容')->required();
                $form->textarea('shipping', '配送说明')->required();

                $form->number('price', '金额')
                     ->default(0)
                     ->required();

                $form->number('quantity', '限制人数')
                     ->default(0)
                     ->help('0为不限制')
                     ->required();
            });
        });

        $form->saving(function (Form $form) {
            if (request()->has('title')) {
                $form->start_at = Carbon::parse($form->start_at)->startOfDay()->addMinute();
                $form->end_at   = Carbon::parse($form->end_at)->endOfDay();

                if ($form->isCreating() && empty($form->pictures) && empty($form->video)) {
                    return $this->backErrorMessage('必须上传图片或者视频');
                }

                $items       = request()->items;
                $items_count = empty($items) ? 0 : count($items);
                if (!$items_count) {
                    return $this->backErrorMessage('必须添加回报');
                }

                $remove = 0;

                foreach ($items as $key => $item) {
                    if ($item['_remove_'] == 1) {
                        $remove++;
                    }
                }

                if ($remove == $items_count) {
                    return $this->backErrorMessage('必须添加回报');
                }

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
