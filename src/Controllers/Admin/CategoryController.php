<?php

namespace XuanChen\CrowdFund\Controllers\Admin;

use App\Models\Category;
use App\Models\Company;
use App\Models\Organization;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Form as WidgetsForm;
use Illuminate\Support\MessageBag;
use XuanChen\CrowdFund\Models\CrowdfundCategory;

class CategoryController extends AdminController
{

    protected $title = '分类管理';

    public function grid()
    {
        return function (Row $row) {
            $row->column(6, $this->treeView());

            $row->column(6, function (Column $column) {
                $form = new WidgetsForm();

                $form->select('company_id', '所属公司')
                     ->options(config('crowdfund.companyModel')::where('status', 1)->pluck('name', 'id'))
                     ->required();

                $form->select('parent_id', '上级分类')
                     ->options(CrowdfundCategory::selectOptions(function ($model) {
                         return $model->where('status', 1);
                     }, '一级分类'));

                $form->text('title', '分类名称')
                     ->rules('required');

                $form->textarea('remark', '分类简介')
                     ->rules('nullable');

                $form->image('cover', 'LOGO')
                     ->move('images/' . date('Y/m/d'))
                     ->removable()
                     ->uniqueName();
                $form->number('order', '排序')->default(0);
                $form->switch('status', '状态')->default(1);
                $form->action(admin_url('crowdfundcategorys'));

                $column->append((new Box('新增分类', $form))->style('success'));
            });
        };
    }

    protected function treeView()
    {

        return CrowdfundCategory::tree(function (Tree $tree) {
            $tree->disableCreate();

            $tree->branch(function ($branch) {
                $category = CrowdfundCategory::find($branch['id']);
                if ($branch['status'] == 1) {
                    $payload = "<i class='fa fa-eye text-primary'></i> ";
                } else {
                    $payload = "<i class='fa fa-eye text-gray'></i> ";
                }
                $company = $category->company ? $category->company->name : '';
                $payload .= " [ID:{$branch['id']}] - ";
                $payload .= " <strong>{$branch['title']}</strong> ";
                $payload .= " <small style='color:#999'>{$branch['description']}</small>";
                $payload .= " <small style='color:#999'>{$company}</small>";

                return $payload;
            });
        });
    }

    protected function form()
    {
        $form = new Form(new CrowdfundCategory);

        $form->select('company_id', '所属公司')
             ->options(config('crowdfund.companyModel')::where('status', 1)->pluck('name', 'id'))
             ->required();

        $form->select('parent_id', '上级分类')
             ->options(CrowdfundCategory::selectOptions(function ($model) {
                 return $model->where('status', 1);
             }, '一级分类'));

        $form->text('title', '分类名称')->rules('required');
        $form->textarea('remark', '分类简介')->rules('nullable');
        $form->image('cover', 'LOGO')
             ->move('images/' . date('Y/m/d'))
             ->removable()
             ->uniqueName();
        $form->number('order', '排序')->default(0);
        $form->switch('status', '显示')->default(1);

        return $form;
    }

}
