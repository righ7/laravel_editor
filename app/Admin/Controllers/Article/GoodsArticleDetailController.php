<?php

namespace App\Admin\Controllers\Article;

use App\Admin\Models\Article\Article;
use App\Admin\Models\Article\ArticlePics;
use App\Admin\Models\Article\DayArticleApi;
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
use Carbon\Carbon;

class GoodsArticleDetailController extends Controller
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
        return view('article.TemaiArticle.article_detail');
    }

    public function getData(Request $request){
        $code = 0;
        $errMsg = '';
        $data = [];
        $article_id = $request->article_id ?? '';

        $where = [];

        $data= ArticleProductAll::where('article_id','=',$article_id)
            ->get()->toArray();
        return response()->json([
            'code'   => $code,
            'errMsg' => $errMsg,
            'data'   => $data,
        ]);
    }
    public function copyAll(Request $request){
        try{
            $code = 0;
            $errMsg = '';
            $title = $request->title ?? '';
            $article_type = $request->article_type ?? '';
            $product_data = $request->data ?? [];
            $user_id=Admin::user()->id;
            $data=[];
            if ($article_type == 0){
                $data['user_id'] = $user_id;
                $data['article_number']  =  date('YmdHis').rand(1000, 9999);
                $data['title']             =  "【复制】".$title;
                $data['type']              =  1;   //图集
                $data['article_type']    = 0;
                $data['status']           =  2;
                $data['create_time']     =   Carbon::now()->timestamp;
                $data['update_time']     =   Carbon::now()->timestamp;
                $data['updated_at']     =   date("Y-m-d H:i:s");
                $data['created_at']     =   date("Y-m-d H:i:s");
                $article_id=Article::insertGetId($data);
                if (!empty($article_id)){
                    if (!empty($product_data)){
                        foreach ($product_data as $k=>$v){
                            $picsData=[];
                            $post_data=[];
                            $post_data['goods_ids']=$v['product_id'];
                            $post_data['fuzzy_des']=1;
                            $post_data['type_level']=3;
                            $post_data['tool_type']=0;
                            $post_data['des_count']=1;
                            $api_description=$this->curlGet("https://baseinfo.youdnr.com/api/info/getgoodsinfo","post",$post_data);
                            $api_description=json_decode($api_description);
                            if ($api_description->data[0]){
                                $main_description=$api_description->data[0]->main_description;
                                $vice_description=$api_description->data[0]->vice_description;
                            }
                            if(!empty($v['main_description'])){

                                $picsData['image']       =  $v['main_picture'];
                                $picsData['describe']    =  $main_description;
                                $picsData['image_type'] =  1;           //1 主图 2副图
                                $picsData['title']       =   $v['product_title'];
                                $picsData['user_id']     =  $user_id;
                                $picsData['article_id'] =  $article_id;
                                $picsData['product_id']  =  $v['product_id'] ;
                                $picsData['order_by']   =  $k;
                                $picsData['updated_at']     =   date("Y-m-d H:i:s");
                                $picsData['created_at']     =   date("Y-m-d H:i:s");
                            }
                            if(!empty($v['vice_description'])){
                                $picsData['image']       =   $v['vice_picture'];
                                $picsData['describe']    =  $vice_description;
                                $picsData['image_type'] =  2;           //1 主图 2副图
                                $picsData['title'] = '';
                                $picsData['user_id']    =  $user_id;
                                $picsData['article_id'] =  $article_id;
                                $picsData['product_id']  = $v['product_id'] ;
                                $picsData['order_by']   =  $k;
                                $picsData['updated_at']     =   date("Y-m-d H:i:s");
                                $picsData['created_at']     =   date("Y-m-d H:i:s");
                            }
                            $article_pics=ArticlePics::insert($picsData);
                        }
                    }
                }
            }else{

            }
        }catch (\Exception $e) {
            $code = 1;
            $errMsg = $e->getMessage();
        } finally {
            return response()->json([
                'code'   => $code,
                'errMsg' => $errMsg,
            ]);
        }
    }
    public function copySingle(Request $request){
        try{
            $code = 0;
            $errMsg = '';
            $article_type = $request->article_type ?? '';
            $product_data = $request->data ?? [];
            $user_id=Admin::user()->id;
            $data=[];
            if ($article_type == 0){
                $data['user_id'] = $user_id;
                $data['article_number']  =  date('YmdHis').rand(1000, 9999);
                $data['title']             =  "【复制】".date("Y-m-d H:i:s");
                $data['type']              =  1;   //图集
                $data['article_type']    = 0;
                $data['status']           =  2;
                $data['create_time']     =   Carbon::now()->timestamp;
                $data['update_time']     =   Carbon::now()->timestamp;
                $data['updated_at']     =   date("Y-m-d H:i:s");
                $data['created_at']     =   date("Y-m-d H:i:s");
                $article_id=Article::insertGetId($data);
                if (!empty($article_id)){
                    if (!empty($product_data)){
                        foreach ($product_data as $k=>$v){
                            $picsData=[];
                            $picsData1=[];
                            $post_data=[];
                            $post_data['goods_ids']=$v['product_id'];
                            $post_data['fuzzy_des']=1;
                            $post_data['type_level']=3;
                            $post_data['tool_type']=0;
                            $post_data['des_count']=1;
                            $api_description=$this->curlGet("https://baseinfo.youdnr.com/api/info/getgoodsinfo","post",$post_data);
                            $api_description=json_decode($api_description);
                            if ($api_description->data[0]){
                                $main_description=$api_description->data[0]->main_description;
                                $vice_description=$api_description->data[0]->vice_description;
                            }

                            if(!empty($v['main_description'])){
                                $picsData['image']       =  $v['main_picture'];
                                $picsData['describe']    =  $main_description??'';
                                $picsData['image_type']  =  1;           //1 主图 2副图
                                $picsData['title']       =  $v['product_title'];
                                $picsData['user_id']     =  $user_id;
                                $picsData['article_id']  =  $article_id;
                                $picsData['product_id']  =  $v['product_id'] ;
                                $picsData['order_by']    =  $k;
                                $picsData['updated_at']  =  date("Y-m-d H:i:s");
                                $picsData['created_at']  =  date("Y-m-d H:i:s");
                            }
                            if (!empty($v['vice_description'])){
                                $picsData1['image']       =  $v['vice_picture'];
                                $picsData1['describe']    =  $vice_description??'';
                                $picsData1['image_type']  =  2;           //1 主图 2副图
                                $picsData1['title']       =  $v['product_title'];
                                $picsData1['user_id']     =  $user_id;
                                $picsData1['article_id']  =  $article_id;
                                $picsData1['product_id']  =  $v['product_id'] ;
                                $picsData1['order_by']    =  $k;
                                $picsData1['updated_at']  =  date("Y-m-d H:i:s");
                                $picsData1['created_at']  =  date("Y-m-d H:i:s");
                            }
//                            else{
//                                if(!empty($api_description->data[0]->img)){
//                                    $picsData1['image']       =   $api_description->data[0]->img[1];
//                                    $picsData1['describe']    =  $vice_description;
//                                    $picsData1['image_type'] =  2;           //1 主图 2副图
//                                    $picsData1['title'] = '';
//                                    $picsData1['user_id']    =  $user_id;
//                                    $picsData1['article_id'] =  $article_id;
//                                    $picsData1['product_id']  = $v['product_id'];
//                                    $picsData1['order_by']   =  $k;
//                                    $picsData1['updated_at']     =   date("Y-m-d H:i:s");
//                                    $picsData1['created_at']     =   date("Y-m-d H:i:s");
//                                }
//                            }

                            $article_pics=ArticlePics::insert([$picsData,$picsData1]);
                        }
                    }
                }
            }else{

            }
        }catch (\Exception $e) {
            $code = 1;
            $errMsg = $e->getMessage();
        } finally {
            return response()->json([
                'code'   => $code,
                'errMsg' => $errMsg,
            ]);
        }
    }
    public function curlGet($url,$method,$post_data = 0){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }elseif($method == 'get'){
            curl_setopt($ch, CURLOPT_HEADER, 0);
        }
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
