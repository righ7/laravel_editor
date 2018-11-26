<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index()
    {
        Admin::disablePjax();
        return Admin::content(function (Content $content) {

            $content->header('写作平台');
            $content->description('主面板');

//            $content->row('功能开发中！');

            $content->row($this->homeView());
        });
    }

    public function homeView(){
        $datas = [
            'my_earning' => [
                'img_data' => '/images/earnings.png',
                'link' => '/admin/article/my_profit',
                'name' => '我的收益'

            ],
            'my_article' => [
                'img_data' => '/images/article.png',
                'name' => '我的发文',
                'link' => '/admin/articles'
            ],
            'go_create' => [
                'img_data' => '/images/create.png',
                'name' => '发布图集',
                'link' => '/admin/article/add_pics'


            ]

        ];
        return view('home/home_view', compact('datas'));
    }


    public function index1()
    {

        return Admin::content(function (Content $content) {

            $content->header('Dashboard');
            $content->description('Description...');



            $content->row(Dashboard::title());

            $content->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });
            });
        });
    }
}
