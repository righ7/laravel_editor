<?php

namespace App\Admin\Controllers\Article;

use App\Admin\Models\Article\DayArticleApi;
use App\Admin\Models\BaseInfo\ArticleAll;
use App\Admin\Models\BaseInfo\ArticleProductAll;
use App\Admin\Repositories\Base\ArticleAllRepository;
use Illuminate\Http\Request;
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
use Illuminate\Support\Facades\DB;

class ArticleTemaiGoodArticleController extends Controller
{
    //use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    protected $ArticleAllRepository;
    public function __construct(ArticleAllRepository $ArticleAllRepository)
    {
        parent::__construct();
        $this->ArticleAllRepository = $ArticleAllRepository;
    }

    public function index()
    {
        Admin::disablePjax();
        return Admin::content(function (Content $content) {
            $content->header('特卖好文');
            $content->description(' ');
            $content->body(view('article.TemaiArticle.temai_goods_article'));
        });
    }

    public function articleData(Request $request){
        $code = 0;
        $errMsg = '';
        $data = [];
        $order_by='behot_time';
        $input = json_decode($request->searchArr, true);
        $title            =     $input['title'] ?? '';
        $author           =     $input['author_id'] ?? '';
        $article_type     =     $input['article_type'] ?? '';
        $product_id       =     $input['product_id'] ?? '';
        $plate            =     $input['plate'] ?? '';
        $onlinetime_start =     $request->online_time[0] ?? '';
        $onlinetime_end   =     $request->online_time[1] ?? '';
        $read             =     $input['read'] ?? '';
        $comments         =     $input['comments'] ?? '';
        $order_type       =     $input['order_type'] ?? '';
        $limit            =     $request->page_count ?? 10;

        $where = [];
        if (!empty($title)) {
            array_push($where, ['title', 'like', "%{$title}%"]);
        }

        if (!empty($author)){
            array_push($where, ['create_user_id', '=', $author]);
        }

        if (!empty($plate)) {
            array_push($where, ['source', '=', $plate]);
        }

        if(!empty($onlinetime_start)){
            array_push($where, ['behot_time', '>=', $onlinetime_start]);
        }

        if (!empty($article_type) || $article_type=='0'){
            if ($article_type!=2){
                array_push($where, ['type', '=', $article_type]);
            }
        }

        if(!empty($onlinetime_end)){
            array_push($where, ['behot_time', '<', date('Y-m-d',strtotime($onlinetime_end .'+1 day'))]);
        }

        if (!empty($read)){
            array_push($where, ['go_detail_count', '>', $read]);
        }
        if (!empty($comments)){
            array_push($where, ['comments_count', '>', $comments]);
        }
        if (!empty($order_type)){
            if ($order_type==2){
                $order_by='comments_count';
            }else if ($order_type==1){
                $order_by='go_detail_count';
            }
        }
        if (!empty($product_id)){
            $article_ids=ArticleProductAll::select('article_id')->where('product_id', '=', $product_id)->get()->toArray();
            $aticleid_arr=[];
            foreach ($article_ids as $k=>$v){
                array_push($aticleid_arr,$v['article_id']);
            }
//            dd($aticleid_arr);
            $sql= ArticleAll::where($where)->whereIn('article_id', $aticleid_arr)->orderBy( $order_by,'desc')->paginate($limit);
        }else{
            $sql= ArticleAll::where($where)->orderBy( $order_by,'desc')->paginate($limit);
        }


        $data = $sql;
        return response()->json([
            'code'   => $code,
            'errMsg' => $errMsg,
            'data'   => $data,
        ]);
    }

}
