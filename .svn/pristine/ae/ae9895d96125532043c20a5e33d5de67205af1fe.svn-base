<?php

namespace App\Admin\Controllers\Article;

use App\Admin\Models\Article\DayArticleApi;
use App\Admin\Models\BaseInfo\ArticleAll;
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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class AuthorRankController extends Controller
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
            $content->header('达人排行');
            $content->description(' ');
            $content->body(view('article.TemaiArticle.author_rank'));
        });
    }

    public function authorData(Request $request){
        $code = 0;
        $errMsg = '';
        $data = [];
        $result=[];
        $date_swicth=$request->date_swicth;
        $page             = $request->page ?? 1;
        $page_count       = $request->page_count ?? 10;
        $start=($page-1)*$page_count;
        $minutes = Carbon::now()->addMinutes(720);
        if ($date_swicth=='7'){
            $cache=Cache::get('rank_week');
            if (!$cache){

                $data=$this->dbData($date_swicth);
                Cache::put('rank_week', $data, $minutes);
            }else{
                $data=$cache;
            }
        } else if ($date_swicth=='30'){
            $cache=Cache::get('rank_month');
            if (!$cache){

                $data=$this->dbData($date_swicth);
                Cache::put('rank_month', $data, $minutes);
            }else{
                $data=$cache;
            }
        } else{
            $data=$this->dbData($date_swicth);
        }

        $total=count($data);
        $data=array_slice($data,$start,$page_count);
        return response()->json([
            'code'   => $code,
            'errMsg' => $errMsg,
            'data'   => $data,
            'total'  => $total,
        ]);
    }

    public function dbData($date_swicth){
        $where = [];
        if($date_swicth!='1'){
            array_push($where, ['behot_time', '>=', date('Y-m-d',strtotime("-{$date_swicth} day"))]);
            array_push($where, ['behot_time', '<', date('Y-m-d',strtotime('+1 day'))]);
        }
        else{
            array_push($where, ['behot_time', '>=', date('Y-m-d',strtotime("-{$date_swicth} day"))]);
            array_push($where, ['behot_time', '<', date('Y-m-d',strtotime('0 day'))]);
        }
        array_push($where, ['create_user_id', '!=', 0]);
        array_push($where, ['create_user_id', '!=', null]);
        //        dd($where);
        $data= ArticleAll::select('create_user_id',DB::raw('SUM(go_detail_count) as detail_sum'))
            ->where($where)
            ->groupBy('create_user_id')
            ->orderBy('detail_sum','desc')
            ->get()
            ->toArray();
        return $data;
    }
}
