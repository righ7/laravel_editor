<?php
/**
 * 我的发文 - 顶部文章状态选择
 * Done is better that Perfect.
 */
namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;


class ArticleStatus extends AbstractTool
{

    private $type;

    public function __construct($type)
    {
        $this->type = $type; // 1 特卖 2头条 [用于我的发文路由判断]
    }

    protected function script(){
        $url = Request::fullUrlWithQuery(['article_status' => '_article_status_']);

        return <<<EOT

$('input:radio.user-article_status').change(function () {

    var url = "$url".replace('_article_status_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        Admin::script($this->script());

        $options = [
            '2' => '草稿',
            '3' => '审核中',
            '4' => '未通过',
            '1' => '已通过',
            '5' => '发布结果',
        ];

        $type = $this->type;

        return view('admin.tools.article_status', compact('options','type'));
    }
}