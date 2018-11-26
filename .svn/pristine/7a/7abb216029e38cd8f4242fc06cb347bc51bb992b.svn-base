<?php

namespace App\Admin\Controllers\Article;

use App\Admin\Models\Article\DayArticleApi;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Layout\Row;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ArticleDayGoodArticleController extends Controller
{
    //use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */



    public function index()
    {
        Admin::disablePjax();
        return Admin::content(function (Content $content) {
            $content->header('好文');
            $content->description(' ');
            $content->body(view('article.DayGoods.day_goods_article'));
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        return Admin::grid(DayArticleApi::class, function (Grid $grid) {

            //$grid->id('序号')->sortable();
            $grid->title('标题')->display(function ($name) {
                return "<a href='$this->display_url' target='_blank'>$name</a>";
            });
            $grid->type('类型')->display(function ($released) {
                return $released=='1' ? '专辑' : '图集';
            });
            //$grid->coming_from('来源');
            $grid->source('频道');
            $grid->go_detail_count('阅读数');
            $grid->comments_count('评论数');
            $grid->behot_time('文章发布时间');
            $grid->d('#');
            $grid->d('#');
            $grid->expandFilter();
            $grid->disableRowSelector();
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->filter(function($filter){


                    $filter->where(function ($query) {
                        if ($this->input == 1) {
                            file_get_contents("http://www.baidu.com");
                        } elseif ($this->input == 2) {
                            file_get_contents("http://www.baidu.com");
                        } else {
                            file_get_contents("http://www.baidu.com");
                        }
                    },'')->select([
                        '0' => '全网',
                        '1' => '自有',
                        '2' => '内容',
                    ]);


            });

        });
    }

}
