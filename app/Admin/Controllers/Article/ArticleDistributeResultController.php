<?php

namespace App\Admin\Controllers\Article;

use App\Admin\Extensions\Actions\PlatformArticleDistributeAction;
use App\Admin\Models\Article\Article;
use App\Admin\Models\Auth\User;
use App\Admin\Models\Platform\PlatformArticleDistribute;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Request;

class ArticleDistributeResultController extends Controller
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
            ->header('分发结果')
            ->description('分发结果')
            ->body($this->grid());
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PlatformArticleDistribute);

        $c = config('table_column_transform.editor.platform_article_distribute');

        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableRowSelector();

        $grid->filter(function($filter) use ($c){
            $filter->column(1/2, function ($filter) use($c){
                $filter->like('article.title','标题');
                /*$filter->where(function ($query) {
                    $user_login = $this->input;
                    $query->leftJoin('article', 'platform_article_distribute.article_id', '=', 'article_id')
                        ->leftJoin('cmf_users', 'article.user_id', '=', 'cmf_users.id')
                        ->where('cmf_users.user_login', 'like', "%$user_login%")
                        ->select('platform_article_distribute.*');
                }, '作者');*/
                $filter->equal('platform_id', '平台')->select([
                    4 => '特卖后台',
                    5 => '头条号',
                ]);
                $filter->like('account_id','账户');
                $filter->between('issue_time', '预计发布时间')->datetime();
            });
            $filter->column(1/2, function ($filter) use ($c){
                $filter->equal('article_type', '文章类型')->select($c['article_type']);
                $filter->equal('status', '发布状态')->select($c['status']);
                $filter->equal('platform_article_status', '平台文章状态')->select($c['platform_article_status']);
            });
        });

        $grid->model()->orderBy('update_time','desc');

        $grid->article_id('文章ID')->sortable();
        $grid->article()->title('标题')->sortable();
        $grid->article()->user_id('作者')->sortable()->display(function($user_id){
            return User::where('id',$user_id)->value('user_login');
        });
        $grid->platform()->platform_name('平台名')->sortable();
        $grid->account_id('账户名')->sortable();
        $grid->article_type('发文类型')->sortable()->display(function($article_type) use ($c){
            $text = $c['article_type'][$article_type] ?? '未知';
            switch ($article_type){
                case 1:
                case 6:
                    return "<div class=\"ivu-tag ivu-tag-blue ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
                case 2:
                case 7:
                    return "<div class=\"ivu-tag ivu-tag-cyan ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
            }
            return "<div class=\"ivu-tag ivu-tag-orange ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">其他</span></div>";
        });
        $grid->status('发布状态')->sortable()->display(function($status) use ($c) {
            $text = $c['status'][$status] ?? '未知';
            switch($status ?? -1){
                case 0:
                    return "<div class=\"ivu-tag ivu-tag-primary ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
                case 1:
                    return "<div class=\"ivu-tag ivu-tag-success ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
                case 2:
                    return "<div class=\"ivu-tag ivu-tag-error ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
            }
            return "<div class=\"ivu-tag ivu-tag-warning ivu-tag-checked\"><span class=\"ivu-tag-text ivu-tag-color-white\">$text</span></div>";
        });
        $grid->platform_article_status('平台文章状态')->sortable()->display(function($platform_article_status) use ($c){
            $text =  $c['platform_article_status'][$platform_article_status] ?? '未知';
            switch ($platform_article_status ?? -1){
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
        $grid->fail_cause('失败原因')->sortable();
        $grid->issue_time('预计发布时间')->sortable();
        $grid->update_time('实际发布时间')->sortable()->display(function(){
            return $this->create_time != $this->update_time ? $this->update_time->toDateTimeString() : '';
        });

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();

            $actions->append(new PlatformArticleDistributeAction($actions->row));
        });

        return $grid;
    }

    public function delete($id){
        $d = PlatformArticleDistribute::findOrFail($id);
        Article::where('id', $d->article_id)->update(['status' => '2']);
        $d->delete();
        return response()->json([
            'message' => '驳回成功 !',
            'status' => true,
        ]);
    }
}
