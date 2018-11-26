<?php

namespace App\Admin\Controllers\Article;

use App\Admin\Extensions\Actions\ArticleAction;
use App\Admin\Extensions\Tools\ArticleStatus;
use App\Admin\Models\Article\Article;
use App\Admin\Models\Article\ArticleAlbums;
use App\Admin\Models\Article\ArticlePics;
use App\Admin\Requests\ArticleApiRequest;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class TtMyPublishController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('我的发文 - 头条')
            ->description('我的发文 - 头条')
            ->body($this->grid());
    }

    public function audit(Request $request, $id)
    {
        $status = $request->status ?? 3;
        $article = Article::findOrFail($id);
        $article->status = $status;
        $article->save();
        return response()->json([
            'message' => '更新成功 !',
            'status' => true,
        ]);
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article);

        $status = Request::get('article_status') ?? 2;

        $arr = [6, 7];

        $article_config = config('table_column_transform.editor.article');
        $distribute_config = config('table_column_transform.editor.platform_article_distribute');

        $grid->tools(function ($tools) use ($status) {
            if (!in_array($status, [2, 4])) { // 非草稿、未通过禁止删除
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            }
            $tools->append(new ArticleStatus(2));
        });

        $grid->disableCreateButton();
        $grid->disableExport();

        if ($status != 5) {
            $grid->model()->where('status', $status);
            $grid->model()->where('user_id', Admin::user()->id);
            $grid->model()->whereIn('type', $arr); // 只图集、专辑
            $grid->model()->orderBy('update_time', 'desc');
        } else { // 发布结果
            $grid->model()->leftJoin(DB::raw('platform_article_distribute as b'), 'article.id', '=', 'b.article_id')
                ->where('article.status', 1)
                ->where('article.user_id', Admin::user()->id)
                ->whereIn('article.type', $arr)// 只图集、专辑
                ->orderBy('article.update_time', 'desc')
                ->select('article.*', 'b.status as d_status', 'b.platform_article_status', 'b.fail_cause', 'b.is_get');
        }

        $grid->id('Id')->sortable();
        $grid->title('标题')->sortable();
        $grid->column('商品数')->display(function () {
            switch ($this->type) {
                case 6:
                    $text = ArticlePics::where('product_id', '!=', 0)->where('article_id', $this->id)->count(DB::raw('distinct(product_id)'));
                    break;
                case 7:
                    $text = ArticleAlbums::where('product_id', '!=', 0)->where('article_id', $this->id)->count(DB::raw('distinct(product_id)'));
                    break;
            }
            return $text;
        });
        $grid->type('文章类型')->sortable()->display(function () {
            if($this->type == 6)
                return "<div class=\"ivu-tag ivu-tag-blue ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">头条图集</span></div>";
            if($this->type == 7)
                return "<div class=\"ivu-tag ivu-tag-cyan ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">头条专辑</span></div>";
            return "<div class=\"ivu-tag ivu-tag-orange ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">其他</span></div>";
        });

        if (in_array($status, [4])) {
            $grid->reject_reason('驳回原因')->sortable();
        }

        if (in_array($status, [5])) {
            $grid->d_status('状态')->display(function () use($distribute_config) {
                $text = $distribute_config['status'][$this->d_status] ?? '未分发';
                switch($this->d_status ?? -1){
                    case 0:
                        return "<div class=\"ivu-tag ivu-tag-primary ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
                    case 1:
                        return "<div class=\"ivu-tag ivu-tag-success ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
                    case 2:
                        return "<div class=\"ivu-tag ivu-tag-error ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
                }
                return "<div class=\"ivu-tag ivu-tag-warning ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
            });
            $grid->platform_article_status('平台状态')->display(function () use($distribute_config) {
                $text = $distribute_config['platform_article_status'][$this->platform_article_status] ?? '暂无';
                switch ($this->platform_article_status ?? -1){
                    case 0:
                        return "<div class=\"ivu-tag ivu-tag-cyan ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
                    case 1:
                        return "<div class=\"ivu-tag ivu-tag-orange ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
                    case 2:
                        return "<div class=\"ivu-tag ivu-tag-red ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
                    case 3:
                        return "<div class=\"ivu-tag ivu-tag-green ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
                }
                return "<div class=\"ivu-tag ivu-tag-default ivu-tag-checked\"><span class=\"ivu-tag-text\">$text</span></div>";
            });
            $grid->fail_cause('失败原因');
        }

        $grid->plan_online_time('计划上线时间')->sortable()->display(function () {
            return date('Y-m-d H:i:s', $this->plan_online_time) ?? '';
        });
        $grid->create_time('创建时间')->sortable()->display(function () {
            return date('Y-m-d H:i:s', $this->create_time) ?? '';
        });
        $grid->update_time('更新时间')->sortable()->display(function () {
            return date('Y-m-d H:i:s', $this->update_time) ?? '';
        });

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
            $actions->append(new ArticleAction($actions->row));
        });

        $grid->filter(function ($filter) {
            $filter->like('title', '标题');
            $filter->equal('type', '类型')->select([
                6 => '头条图集',
                7 => '头条专辑'
            ]);
            // 格式如何转换成时间戳？？
            // $filter->between('plan_online_time', '计划上线时间')->datetime();
        });
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article);
        return $form;
    }


}
