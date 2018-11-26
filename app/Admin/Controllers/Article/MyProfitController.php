<?php

namespace App\Admin\Controllers\Article;

use App\Admin\Models\Article\DayArticleApi;
use Encore\Admin\Auth\Database\Administrator;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyProfitController extends Controller
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
            $content->header('我的收益');
            $content->description(' ');
            $content->body(view('article.MyProfit.index'));
        });
    }
    public function all()
    {
        Admin::disablePjax();
        return Admin::content(function (Content $content) {
            $content->header('全部收益');
            $content->description(' ');
            $content->body(view('article.MyProfit.all'));
        });
    }
    public function getRevenueInitialData(Request $request){
        $page_index = $request['page_index'] ?? 0;
        $page_count = $request['page_size'];
        $serachArr = json_decode(htmlspecialchars_decode($request['searchArr']),true);
        $initialtime = $request['initialtime'];
        //var_dump($initialtime);exit();
        $url='https://tm.youdnr.com/api/temai/article/get_article_effect';
        $uid = Admin::user()->id;
        $temai_user_id=DB::table('cmf_users')->where('id', $uid)->value('temai_uid');

        if ($temai_user_id==null){
            $result=null;
            exit($result);
        }
        if ($serachArr!=null){
            $post_data = array(
                "temai_user_id" => $temai_user_id,
                "page" => $page_index,
                "page_count" => $page_count,
                "title" => !empty($serachArr['title'])?$serachArr['title']:null,
                "type" => !empty($serachArr['type'])?(int)$serachArr['type']:null,
                "order_status" => !empty($serachArr['order_status'])?(int)$serachArr['order_status']:null,
                "start_time" => !empty($initialtime[0])?$initialtime[0]:$serachArr['time'][0],
                "end_time" => !empty($initialtime[1])?$initialtime[1]:$serachArr['time'][1]
            );
        }else{
            $post_data = array(
                "temai_user_id" => $temai_user_id,
                "page" => $page_index,
                "page_count" => $page_count,
                "start_time" => !empty($initialtime[0])?$initialtime[0]:null,
                "end_time" => !empty($initialtime[1])?$initialtime[1]:null
            );
        }
        $curl='https://tm.youdnr.com/api/temai/article/getUserincome?temai_user_id='.$temai_user_id;
        $result=json_decode($this->send_post($url,$post_data),true);
        $recprice=json_decode($this->send_post($curl),true);
        $result['recprice']=$recprice['data'];
        //var_dump($recprice['data']);exit();

        exit(json_encode($result));
    }
    public function getAllInitialData(Request $request){
        $page_index = $request['page_index'] ?? 0;
        $page_count = $request['page_size'];
        $serachArr = json_decode(htmlspecialchars_decode($request['searchArr']),true);
        $initialtime = $request['initialtime'];
        $url='https://tm.youdnr.com/api/temai/article/get_article_effect';

        if ($serachArr!=null){
            $post_data = array(
                "page" => $page_index,
                "page_count" => $page_count,
                "title" => !empty($serachArr['title'])?$serachArr['title']:null,
                "type" => !empty($serachArr['type'])?(int)$serachArr['type']:null,
                "order_status" => !empty($serachArr['order_status'])?(int)$serachArr['order_status']:null,
                "start_time" => !empty($initialtime[0])?$initialtime[0]:$serachArr['time'][0],
                "end_time" => !empty($initialtime[1])?$initialtime[1]:$serachArr['time'][1]
            );
        }else{
            $post_data = array(
                "page" => $page_index,
                "page_count" => $page_count,
                "start_time" => !empty($initialtime[0])?$initialtime[0]:null,
                "end_time" => !empty($initialtime[1])?$initialtime[1]:null
            );
        }
        $result=json_decode($this->send_post($url,$post_data),true);

        exit(json_encode($result));
    }
    public function orderDetail()
    {
        Admin::disablePjax();
        return Admin::content(function (Content $content) {
            $content->header('订单详情');
            $content->description(' ');
            $content->body(view('article.MyProfit.orderDetail'));
        });
    }

        public function getOrderData(Request $request){
        $article_id = $request['article_id'] ?? '';
        $page_index = $request['page_index'] ?? 0;
        $page_count = $request['page_size'];
        $serachArr = json_decode(htmlspecialchars_decode($request['searchArr']),true);
        $url='https://tm.youdnr.com/api/temai/article/get_order_effect';
        if ($serachArr!=null){
            if ($serachArr['disabledGroup']=='按订单开始时间'){
                $time_status=1;
            }else{
                $time_status=2;
            }
            $post_data = array(
                "article_id"=>$article_id,
                "page" => $page_index,
                "page_count" => $page_count,
                "goods_id" => !empty($serachArr['goodsid'])?$serachArr['goodsid']:null,
//                "title" => !empty($serachArr['title'])?$serachArr['title']:null,
                "time_status" => $time_status,
                "start_time" => !empty($serachArr['time'][0])?$serachArr['time'][0]:null,
                "end_time" => !empty($serachArr['time'][1])?$serachArr['time'][1]:null
            );
        }else{
            $post_data = array(
                "article_id"=>$article_id,
                "page" => $page_index,
                "page_count" => $page_count
            );
        }
        //var_dump($post_data);exit();
        $result=$this->send_post($url,$post_data);
        exit($result);
    }
    public function send_post($url,$post_data='') {
        if ($post_data){
            $postdata = http_build_query($post_data);
        }
        else{
            $postdata = '';
        }
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
}
