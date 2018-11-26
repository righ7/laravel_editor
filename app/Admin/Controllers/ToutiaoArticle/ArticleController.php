<?php

namespace App\Admin\Controllers\ToutiaoArticle;

use App\Admin\Models\Article\Article;
use App\Admin\Models\Article\ArticleAlbums;
use App\Admin\Models\Article\ArticleCategory;
use App\Admin\Models\Platform\PlatformAccount;
use App\Admin\Models\Platform\PlatformArticleDistribute;
use App\Admin\Models\Platform\PlatformPermission;
use App\Admin\Repositories\Article\ArticleRepository;
use App\Admin\Requests\ArticleApiRequest;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//头条专辑控制器
class ArticleController extends Controller
{

    protected $articleRepository;
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
        parent::__construct();
    }
    /**
     * Index interface.
     *
     * @return Content
     */

    //创建专辑的文章页面
    public function createAblumContent()
    {
        Admin::disablePjax();
        return Admin::content(function (Content $content) {

            $content->header('发布专辑');
            $content->description('发布专辑');

            $content->body(view('article.toutiao.publish_ablum'));
        });
    }
    public function getGoodsDataView(){

        return view('article.goods_data_view');
    }

    public function getGoodsDataApi(ArticleApiRequest $request){

        $url = !empty($request['url'])?$request['url']:null;
        if(!empty($url)){
            $url_arr = $this->getUrlKeyValue($url);

            if(!empty($url_arr['id'])){
                $taobao_id = $url_arr['id'];
                $taobao_data = file_get_contents('http://baseinfo.youdnr.com/api/get_goods_base_detail?NumIids='.$taobao_id);
                $taobao_data = json_decode($taobao_data,true);

                if(!empty($taobao_data['data'])){
                    $data = $taobao_data['data'];
                    $status= 0;
                    $msg = '';
                }
                else{
                    $data = [];
                    $status= 3;
                    $msg = '该商品已下架或不存在!';
                }

            }
            else{
                $data = [];
                $status= 2;
                $msg = '该链接无效，请输入正确的淘宝/天猫的商品链接!';
            }
        }
        else{
            $data = [];
            $status= 1;
            $msg = '请输入url进行查询!';
        }
        $result['data'] = $data;
        $result['status'] = $status;
        $result['msg'] = $msg;
        return response()->json($result);
    }

    function getUrlKeyValue($url)
    {
        $result = array();
        $mr     = preg_match_all('/(\?|&)(.+?)=([^&?]*)/i', $url, $matchs);
        if ($mr !== false) {
            for ($i = 0; $i < $mr; $i++) {
                $result[$matchs[2][$i]] = $matchs[3][$i];
            }
        }
        return $result;
    }


    public function SaveArticle(ArticleApiRequest $request){
        $data = !empty($request['data'])?$request['data']:null;

        $data = json_decode($data,true);
        $user = Admin::user();

        if(!empty($data)) {
            $article['title'] = $data['title'];
            $article['desc'] = $data['leads'];
            $article['type'] = !empty($data['articleType'])?$data['articleType']:7;
            $article['face_image'] = $data['firstImg'];
            $article['status'] = $data['saveType'];   //文章保存状态   0删除    1：已审核   2:草稿    3:待审核  4:未通过
            $article['article_number'] = date('YmdHis') . rand(1000, 9999);
            $article['article_type'] = 1;
            $article['update_time'] = strtotime('now');
            $article['updated_at'] = date('Y-m-d H:i:s');
            $content = $data['content'];

            $detail_content = [];
            if(!empty($content)){
                $detail_content = $this->saveContent($content);
                if(!empty($detail_content)){
                    if(is_array($detail_content) === false){
                        $status = -1;
                        $msg = '文章内容为空，不能保存';
                        $data = [];
                        return $this->GetApiJson($msg,$status,$data);
                    }
                }
            }
            if( $article['status'] > 0 && empty($detail_content)){

                $status = -2;
                $msg = '发布文章时内容不能为空！';
                $data = [];
                return $this->GetApiJson($msg,$status,$data);
            }

            if(!empty($data['id'])){
                $article_model = Article::where('id',$data['id'])->first();
                $update_result = $this->articleRepository->update($article_model,$article);
                if($update_result === true){
                    $article_id = $data['id'];
                    $user_id = $article_model->user_id;
                }
                else{
                    $article_id = 0;
                    $user_id = 0;
                }
            }
            else{
                $article['user_id'] = $user->id;
                $article['plan_online_time'] = !empty($data['publish_time'])?strtotime($data['publish_time']):strtotime('now');
                $article['create_time'] = strtotime('now');
                $article['is_exist'] = 0;
                $article['exist_msg'] = "";
                $article['reject_reason'] = "";
                $article['created_at'] = date('Y-m-d H:i:s');
                $article_id = Article::insertGetId($article);
                $user_id = $user->id;
            }

            if($article_id>0){
                if(!empty($detail_content)){
                    $article_albums = ArticleAlbums::where('article_id',$article_id)->select(['id','article_id','order_by'])->get();

                    foreach ($detail_content as $kkk=>$vvv){
                        $vvv['article_id'] = $article_id;
                        $vvv['user_id'] = $user_id;
                        $vvv['order_by'] = $kkk+1;
                        $vvv['updated_at'] = date('Y-m-d H:i:s');
                        $vvv['update_time'] = strtotime('now');
                        $vvv['updated_at'] = date('Y-m-d H:i:s');
                        $albums = $article_albums->where('order_by',$vvv['order_by'])->first();
                        if(!empty($albums)){
                            $detail_id = $albums->id;
                            ArticleAlbums::where('article_id',$article_id)->where('id',$detail_id)->update($vvv);
                        }
                        else{
                            $vvv['create_time'] = strtotime('now');
                            $vvv['created_at'] = date('Y-m-d H:i:s');
                            ArticleAlbums::insertGetId($vvv);
                        }
                    }
                    ArticleAlbums::where('article_id',$article_id)->where('order_by','>',count($detail_content))->delete();
                }
            }

            if($article['status'] == 3){
                $article_user = Administrator::where('id',$user_id)->first();
                if($article_user->is_avoid_audit == 1){
                    if(!empty($article_id)){

                        Article::where('id',$article_id)->update(['status'=>1,'update_time' => strtotime('now'),'updated_at'=>date('Y-m-d H:i:s')]);

                        if($article_user->direct_issue == 1){
                            $accounts = PlatformPermission::where('user_id',$user_id)->get()->toArray();
                            $issue_time = Article::where('id',$article_id)->value('plan_online_time');
                            if(!empty($accounts)){
                                $list = array();
                                foreach ($accounts as $k => $account) { // 数据转换存入平台分发表
                                    $list[$k]['article_id'] = $article_id;
                                    $list[$k]['account_id'] = $account['shop_id'];
                                    $list[$k]['platform_id'] = $account['platform_id'];
                                    $list[$k]['article_type'] = $article['type'];
                                    $list[$k]['status'] = 0;
                                    $list[$k]['is_get'] = 0;
                                    $list[$k]['issue_type'] = $article_user->direct_draft == 1 ? 0 : 1;
                                    $list[$k]['fail_cause'] = '';
                                    $list[$k]['issue_time'] = !empty($issue_time) ? date('Y-m-d H:i:s',$issue_time):date('Y-m-d H:i:s');
                                    $list[$k]['create_time'] = date('Y-m-d H:i:s');
                                    $list[$k]['update_time'] = date('Y-m-d H:i:s');
                                }
                                if (!empty($list)) {
                                    $count = PlatformArticleDistribute::where("article_id",$article_id)->count();
                                    if(!$count){
                                        $z = rand(0,count($list)-1);
                                        PlatformArticleDistribute::insert($list[$z]);
                                    }
                                }
                            }
                            else{
                                //判断是否有开启的账号 is_start=1
                                $toutiaoAccounts = PlatformAccount::where('shop_id','!=',"")->where('status',1)->where('is_start',1)->where('platform',5)->get()->toArray();
                                $list = array();
                                if(!empty($toutiaoAccounts)){
                                    $list['article_id'] = $article_id;
                                    $list['account_id'] = -1;
                                    $list['platform_id'] = 5;
                                    $list['article_type'] = $article['type'];
                                    $list['status'] = 0;
                                    $list['is_get'] = 0;
                                    $list['issue_type'] = $article_user->direct_draft == 1 ? 0 : 1;
                                    $list['fail_cause'] = '';
                                    $list['issue_time'] = !empty($issue_time) ? date('Y-m-d H:i:s',$issue_time):date('Y-m-d H:i:s');
                                    $list['create_time'] = date('Y-m-d H:i:s');
                                    $list['update_time'] = date('Y-m-d H:i:s');

                                    if (!empty($list)) {
                                        $count = PlatformArticleDistribute::where("article_id",$article_id)->count();
                                        if(!$count){
                                            //$z = rand(0,count($list)-1);
                                            PlatformArticleDistribute::insert($list);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $status = 0;
            $msg = '成功！';
            $data = [];
            return $this->GetApiJson($msg,$status,$data);

        }
        else{
            $status = -4;
            $msg = '发文内容不能为空';
            $data = [];
            return $this->GetApiJson($msg,$status,$data);
        }
    }



    function saveContent($content){
        $detail_content = [];
        if(!empty($content)){
            foreach ($content as $k=>$v){
                $detail['detail_type'] = $v['type'];
                $detail['goods_id'] = 0;
                $detail['image'] = $v['img'];
                $detail['describe'] = $v['describe'];
                if(!empty($v['link']) && $v['link'] != ""){
                    $url_arr = $this->getUrlKeyValue($v['link']);
                    $detail['goods_id'] = $url_arr['id'];
                    $detail['product_id'] =$url_arr['id'];
                }
                else{
                    $detail['product_id']  = "";
                }
                $detail['goods_url'] = $v['link'];
                $detail['title'] = $v['goods_name'];
                $detail['shop_name'] = $v['shop_name'];
                $detail['price'] = $v['price'];

                $detail_content[] = $detail;
            }
        }
        if(!empty($detail_content)){
            return $detail_content;
        }
        else{
            return [];
        }
    }

    public function saveArticleImg(ArticleApiRequest $request){
        $img = !empty($request['img'])?$request['img']:null;

        if(!empty($img)){
            $user = Admin::user()->user_login;
            $file = 'TaobaoArticle';
            $rank_name = base64_encode($user);
            $result_data = $this->saveImg($img,$file,$rank_name);
            $msg = $result_data['msg'];
            $error = $result_data['status'];
            $url_top = env('APP_URL', 'http://kolplatform.youdnr.com');
            $url = $url_top.'/'.$result_data['url'];
        }
        else{
            $msg = '图片不能为空';
            $error ='-4';
            $url = "";
        }

        $result['msg'] = $msg;
        $result['error'] = $error;
        $result['url'] = $url;

        return json_encode($result);
    }

    public function editAblum(Article $article){
        $article_id = $article->id;
        $articleAlbum = ArticleAlbums::where('article_id',$article_id)->orderBy('order_by','asc')->get();
        $article_data = array();
        if(!empty($article_id)){
            $article_data['article_id'] = $article_id;
            $article_data['title'] = $article->title;
            $article_data['face_image'] = $article->face_image;
            $article_data['desc'] = $article->desc;
            if(count($articleAlbum)>0){
                $content_list = [];
                foreach ($articleAlbum as $k=>$v){
                    $content = array();
                    $content['content_id'] = $v->id;
                    $content['detail_type'] = $v->detail_type;
                    $content['product_id'] = $v->product_id;
                    $content['title'] = $v->title;
                    $content['goods_url'] = $v->goods_url;
                    $content['image'] = $v->image;
                    $content['describe'] = $v->describe;
                    $content['shop_name'] = $v->shop_name;
                    $content['price'] = $v->price;
                    $content['order_by'] = $v->order_by;
                    $content_list[] = $content;
                }
                $article_data['content'] = $content_list;
            }
            else{
                $article_data['content'] = [];
            }
        }

        $data = $article_data;
        return Admin::content(function (Content $content) use($data) {

            $content->header('淘宝文章');
            $content->description('文章编辑');
            $content->body(view('article.toutiao.edit_ablum',compact('data')));
        });

    }
}
