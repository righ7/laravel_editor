<?php

namespace App\Admin\Controllers\Article;

use App\Admin\Models\Article\ArticleSensitiveWord;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ArticleSensitiveWordController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('敏感词管理');
            $content->description('敏感词列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('敏感词管理');
            $content->description('创建敏感词');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('敏感词管理');
            $content->description('修改敏感词');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(ArticleSensitiveWord::class, function (Grid $grid) {

            $grid->id('序号')->sortable();
            $grid->keywords('敏感词');
            $grid->type('类型')->display(function ($released) {
                return $released==1 ? '标题' : '内容';
            });

            $grid->expandFilter();

            $grid->filter(function($filter){

                // 在这里添加字段过滤器
                $filter->column(1/2, function ($filter) {
                    $filter->like('keywords', '关键词');
                });

                $filter->column(1/2, function ($filter) {
                    $filter->where(function ($query) {
                        if ($this->input == 1) {
                            $query->whereIn('type', [1]);
                        } elseif ($this->input == 2) {
                            $query->whereIn('type', [2]);
                        } else {
                            $query->whereIn('type', [1, 2]);
                        }
                    }, '类型')->select([
                        '0' => '全部',
                        '1' => '标题',
                        '2' => '内容',
                    ]);
                });

                // 去掉默认的id过滤器
                $filter->disableIdFilter();


            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ArticleSensitiveWord::class, function (Form $form) {

            $form->hidden('id', 'ID');

            $form->text('keywords', '关键词');
            $form->select('type','文章类型')->options([1 => '标题', 2 => '内容']);
            $form->hidden('keywords_type', '关键词类别')->value(0);
            $form->hidden('created_at', '创建时间');
            $form->hidden('updated_at', '更新时间');
        });
    }


}
