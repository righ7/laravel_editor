<?php

namespace App\Http\Controllers\Article;

use App\Admin\Models\Article\Article;
use App\Admin\Models\Article\ArticleAlbums;

use App\Admin\Models\Article\ArticlePics;
use App\Admin\Models\Platform\AccountLimitTime;
use App\Admin\Models\Platform\PlatformAccount;
use App\Admin\Models\Platform\PlatformArticleDistribute;

use App\Http\Controllers\Controller;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use League\Flysystem\Exception;

/**
 * Class UserApiController
 */
class ArticleIssueApiController extends Controller
{

	/**
	 * 初始化
	 */
	public function __construct()
	{
		//执行父级的初始化，获取通用的参数
		parent::__construct();

	}

    public function getArticleData(Request $request)
    {

        $account_id = !empty($request['account_id'])?$request['account_id']:null;
        DB::beginTransaction();
        try {
            $result['code'] = 0;
            $result['errMsg'] = '';
            $result['data'] = [];

            $this->syncDistributeArticleType();

            if (empty($account_id))
                throw new \Exception('「account_id」不能为空!');

            $nowTime = date('Y-m-d H:i:s');
            $where['status'] = 0;
            $where['account_id'] = $account_id;
            $where['is_get'] = 0;
            $where['issue_time'] = array('ELT', $nowTime);
            // $where['article_type'] = array('NEQ', 2); // 1图集 2专辑

            if ($this->checkIssueTime($account_id)) { // 校检是否到发文时间

                $aOne = PlatformArticleDistribute::where('status',0)
                    ->where('account_id',$account_id)
                    ->where('is_get',0)
                    ->where('issue_time','<=',$nowTime)
                    ->whereIn('article_type',[1,2])
                    ->orderBy('issue_time', 'asc')
                    ->lockForUpdate()   //对数据进行了共享锁
                    ->first();
                /*
                 * 是否有该账号未领取的文章
                 *  是：设置为已领取
                 *      更新分发账号为领取的账号
                 *  否：判断账号是否参与（专辑、图集）的分发
                 * */
                if (!empty($aOne)) {
                    PlatformArticleDistribute::where("id",$aOne->id)->update(['is_get' => 1, 'update_time' => date('Y-m-d H:i:s')]);

                    DB::commit();

                    $article = Article::where('id', $aOne->article_id)->first();
                    if(!empty($article)) {
                        switch ($article->type) {
                            case 1: // 图集
                                $pics = ArticlePics::where("article_id",$aOne->article_id)
                                    ->orderBy('order_by','asc')
                                    ->orderBy('image_type','asc')
                                    ->get()->toArray();
                                $arr['id'] = $article->id;
                                $arr['type'] = 0;
                                $arr['article_type'] = 1;
                                $arr['title'] = $article->title;
                                $arr['sex'] = '';
                                $arr['issue_type'] = $aOne->issue_type;
                                $arr['content'] = $this->changePicStruct($pics);
                                $result['data'][] = $arr;
                                break;
                            case 2: // 专辑
                                $albums = ArticleAlbums::where("article_id", $article->id)->orderBy('order_by','asc')->get()->toArray();
                                $arr['id'] = $article->id;
                                $arr['type'] = 0;
                                $arr['article_type'] = 0;
                                $arr['title'] = $article->title;
                                $arr['sex'] = '';
                                $arr['issue_type'] = $aOne->issue_type;
                                $arr['content'] = $this->changeAlbumsStruct($albums);
                                $desc = $this->articleIntroduction($article['desc']);
                                array_unshift($arr['content'], $desc);
                                $result['data'][] = $arr;
                                break;
                        }
                    }
                } else{
                    DB::commit();
                    //查询账号相关数据
                    $data = PlatformAccount::where("shop_id",$account_id)->first()->toArray();
                    //判断账号是否参与（专辑、图集）的分发
                    //启用
                    if($data['is_start']==1){

                        //启用专辑（先判断专辑，后判断图集）
                        if($data['is_albums']==1 && $data['is_pics']!=1){

                            //判断专辑是否有剩余篇数
                            if($data['res_albums_num'] > 0 ){
                                $re=$this->isAlbumsArticle($data,$account_id,$is_limit=0);
                                if($re=='没有文章！'){
                                    //判断是否是无限号
                                    $limitStatus=true;
                                }else{
                                    $result=$re;
                                }

                            }else{
                                //判断是否是无限号
                                $limitStatus=true;
                            }
                        }
                        //启用图集
                        elseif ($data['is_albums']!=1 && $data['is_pics']==1){
                            //判断图集是否有剩余篇数
                            if ($data['res_pics_num'] > 0){
                                $re=$this->isPicsArticle($data,$account_id,$is_limit=0);
                                if($re=='没有文章！'){
                                    //throw new \Exception('没有文章！');
                                    //判断是否是无限号
                                    $limitStatus=true;
                                }else{
                                    $result=$re;
                                }
                            }else{
                                //判断是否是无限号
                                $limitStatus=true;
                            }
                        }
                        //专辑、图集都启用
                        elseif($data['is_albums']==1 && $data['is_pics']==1){
                            //专辑有剩余篇数
                            if($data['res_albums_num'] > 0){
                                $re=$this->isAlbumsArticle($data,$account_id,$is_limit=0);
                                if($re=='没有文章！'){
                                    //没有文章，走图集
                                    if($data['res_pics_num'] > 0){
                                        $re=$this->isPicsArticle($data,$account_id,$is_limit=0);
                                        if($re=='没有文章！'){
                                            //判断是否是无限号
                                            $limitStatus=true;
                                        }else{
                                            $result=$re;
                                        }
                                    }else{
                                        //判断是否是无限号
                                        $limitStatus=true;
                                    }

                                }else{
                                    $result=$re;
                                }
                            }
                            //图集有剩余篇数
                            else{
                                if($data['res_pics_num'] > 0){
                                    $re=$this->isPicsArticle($data,$account_id,$is_limit=0);
                                    if($re=='没有文章！'){
                                        //判断是否是无限号
                                        $limitStatus=true;
                                    }else{
                                        $result=$re;
                                    }
                                }elseif($data['res_albums_num'] == 0 && $data['res_pics_num'] == 0){
                                    //判断是否是无限号
                                    $limitStatus=true;
                                }
                            }

                        }
                        //专辑、图集都不启用
                        elseif($data['is_albums']==0 && $data['is_pics']==0){
                            //判断是否是无限号
                            $limitStatus=true;
                        }
                        //var_dump($result);
                        //var_dump($limitStatus);exit;
                        if($limitStatus==true){
                            if($data['is_limit']==1){
                                $re=$this->isLimit($account_id);
                                if($re=='没有文章！'){
                                    throw new \Exception('没有文章！');
                                }else{
                                    $result=$re;
                                }
                            }else{
                                throw new \Exception('没有文章！');
                            }
                        }

                    }else{
                        throw new \Exception('没有文章！');
                    }

                }
            }


        } catch (\Exception $e) {
            $result['code'] = 1;
            $result['errMsg'] = $e->getMessage();

        } finally {
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }

    public function isAlbumsArticle($data,$account_id,$is_limit){

        if($data['res_albums_num']==0){
            $result='没有文章！';
            return $result;
        }
        DB::beginTransaction();
        //是否有未领取的文章
        $distribute = config('article.platform_article_distribute');
        $article = config('article.article_table');
        $is_article = PlatformArticleDistribute::leftJoin($article, $article . '.id', '=', $distribute . '.article_id')
            ->where($distribute . '.account_id','-1')
            ->where($distribute . '.is_get', 0)
            ->where($distribute . '.status',0)
            ->where($article . '.type', 2)
            ->where($distribute . '.issue_time', '<=', date('Y-m-d H:i:s'))
            ->orderBy($distribute . '.issue_time', 'asc')
            ->select([
                $distribute.'.id',
                $distribute.'.article_id',
                $distribute.'.article_type',
                $distribute.'.issue_type',
                $article.'.title',
                $article.'.desc',
                $article.'.face_image',
            ])
            ->lockForUpdate()   //对数据进行了共享锁
            ->first()->toArray();

        /*
        * 有可领取文章（需做修改）：
        *  1.更改为已领取
        *  2.减掉相对应的剩余篇数
        */
        if(!empty($is_article)){
            //修改文章为领取
            PlatformArticleDistribute::where("id",$is_article['id'])
                ->update([
                    'is_get' => 1,
                    'update_time' => date('Y-m-d H:i:s'),
                    'account_id'=>$account_id
                ]);
            DB::commit();
            //获取专辑信息
            $albums = ArticleAlbums::where("article_id",$is_article['article_id'])->get();
            //修改账号的剩余篇数
            if($is_limit!=1){
                PlatformAccount::where("shop_id", $account_id)
                    ->update([
                        'res_albums_num' => $data['res_albums_num']-1
                    ]);
            }

            $arr['id'] = $is_article['article_id'];
            $arr['type'] = 0;
            $arr['article_type'] = 0;
            $arr['title'] = $is_article['title'];
            $arr['sex'] = '';
            $arr['issue_type'] = $is_article['issue_type'];
            $arr['content'] = $this->changeAlbumsStruct($albums);
            $desc = $this->articleIntroduction($is_article['desc']);
            array_unshift($arr['content'],$desc);
            $result['data'][] = $arr;
        }else{
            $result='没有文章！';
            DB::commit();
        }
        return $result;
    }

    public function isPicsArticle($data,$account_id,$is_limit){
        if($data['res_pics_num']==0){
            $result='没有文章！';
            return $result;
        }
        $wh['d.status'] = 0;
        $wh['d.account_id'] = '-1';
        $wh['d.is_get'] = 0;
        $wh['a.type'] = 1; // 图集
        //是否有未领取的文章
        $distribute = config('article.platform_article_distribute');
        $article = config('article.article_table');

        $is_pic_article = PlatformArticleDistribute::leftJoin($article, $article . '.id', '=', $distribute . '.article_id')
            ->where($distribute . '.account_id','-1')
            ->where($distribute . '.is_get', 0)
            ->where($distribute . '.status',0)
            ->where($article . '.type', 1)
            ->where($distribute . '.issue_time', '<=', date('Y-m-d H:i:s'))
            ->orderBy($distribute . '.issue_time', 'asc')
            ->select([
                $distribute.'.id',
                $distribute.'.article_id',
                $distribute.'.article_type',
                $distribute.'.issue_type',
                $article.'.title',
                $article.'.desc',
                $article.'.face_image',
            ])
            ->lockForUpdate()   //对数据进行了共享锁
            ->first()->toArray();
        /*
         * 有可领取文章（需做修改）：
         *  1.更改为已领取
         *  2.减掉相对应的剩余篇数
         */
        if(!empty($is_pic_article)){
            //修改文章为领取
            PlatformArticleDistribute::where("id",$is_pic_article['id'])
                ->update([
                    'is_get' => 1,
                    'update_time' => date('Y-m-d H:i:s'),
                    'account_id'=>$account_id
                ]);
            //获取图集信息
            $pics = ArticlePics::where("article_id",$is_pic_article['article_id'])
                ->orderBy('order_by','asc')
                ->orderBy('image_type','asc')
                ->get()
                ->toArray();
            //修改账号的剩余篇数
            if($is_limit!=1){
                PlatformAccount::where("shop_id", $account_id)
                ->update([
                    'res_pics_num' => $data['res_pics_num']-1
                ]);
            }


            $arr['id'] = $is_pic_article['article_id'];
            $arr['type'] = 0;
            $arr['article_type'] = 1;
            $arr['title'] = $is_pic_article['title'];
            $arr['sex'] = '';
            $arr['issue_type'] = $is_pic_article['issue_type'];
            $arr['content'] = $this->changePicStruct($pics);
            $result['data'][] = $arr;
        }else{
            $result='没有文章！';
        }
        return $result;
    }

    private function changePicStruct($pics)
    {
        $tem = []; //临时存放数组
        $lists = [];
        $goods_id_arr = [];
        foreach ($pics as $item) {
            $goods_id_arr[] = $item['goods_id'];
        }

        foreach ($pics as $pic) {
            if (empty($tem) && $pic['image_type'] == 1) {
                $tem = $pic;
                continue;
            }
            if ($tem['image_type'] == 1 && $pic['image_type'] == 2 && $tem['goods_id'] == $pic['goods_id']) {
                $arr['goods_id'] = $pic['product_id'] ?? '';
                $arr['goods_link'] = '';
                $arr['goods_name'] = $tem['title'];
                $arr['main_description'] = $tem['describe'];
                $arr['vice_description'] = $pic['describe'];
                $arr['main_picture'] = $this->translateImageUrl($tem['image']);
                $arr['vice_picture'] = $this->translateImageUrl($pic['image']);
                $lists[] = $arr;
                unset($tem);
                continue;
            }
        }

        // 存日志 => 调试
        // $file  = 'log.txt';
        // $log = [
        //     'type' => '图集',                        // 请求数据
        //     'relevance_data' => $pics  ?? 'EMPTY',  // article 关联表数据
        //     'remote_data' => $goodsData ?? 'EMPTY', // 公共库请求回来的商品数据
        //     'result' => $lists ?? 'EMPTY'           // 最终返回结果
        // ];
        // file_put_contents($file, json_encode($log,JSON_UNESCAPED_UNICODE)."\n\r",FILE_APPEND);

        return $lists;
    }


    private function checkIssueTime($account_id)
    {
        $now = date('H:i:s');
        $week = date('w') + 1;
        $data = AccountLimitTime::where('shop_id',$account_id)
            ->where('week',$week)
            ->where('status',1)
            ->where('limit_issue_time_start','<=',$now)
            ->where('limit_issue_time_end','>=',$now)
            ->first();

        if(empty($data)){
            return true;
        }else{
            return false;
        }
    }

    private function changeAlbumsStruct($albums)
    {
        $lists = [];

        foreach($albums as $album){
            $arr['goods_id'] = $album['product_id'] ?? '';
            $arr['goods_link'] = $album['goods_url'] ?? '';
            $arr['goods_name'] = $album['title'] ?? '';
            $arr['main_description'] = $album['describe'] ?? '';
            $arr['main_picture'] = $this->translateImageUrl($album['image'] ?? '');
            $lists[] = $arr;
        }
        return $lists;
    }

    //图片转换
    private function translateImageUrl($img)
    {
        if(empty($img))
            return $img;

        if(strstr($img,'Uploads')){
            return 'http://platform.youdnr.com'.$img;
        }

        return $img;
    }

    // 专辑导语补充

    private function articleIntroduction($content){
        $arr['detail_type'] = 1;
        $arr['goods_id'] = '';
        $arr['goods_link'] = '';
        $arr['goods_name'] = '';
        $arr['main_description'] = $content ?? '';
        $arr['main_picture'] = '';
        return $arr;
    }
    // 首图补充
    private function articleFirstImg($content){
        $arr['detail_type'] = 2;
        $arr['goods_link'] = '';
        $arr['goods_name'] = '';
        $arr['main_description'] = '';
        $arr['main_picture'] = $content ?? '';
        return $arr;
    }

    private function syncDistributeArticleType()
    {
        $distributes = PlatformArticleDistribute::where('article_type',0)->select(['id','article_id'])->get()->toArray();
        if(!empty($distributes)){
            foreach ($distributes as $distribute) {
                $article_type = Article::where("id",$distribute['article_id'])->value('type');
                if (!empty($article_type)){
                    PlatformArticleDistribute::where("id",$distribute['id'])->update(['article_type' => $article_type]);
                }
            }
        }

    }

    public function isLimit($account_id){

        $distribute = config('article.platform_article_distribute');
        $article = config('article.article_table');
        DB::beginTransaction();
        $is_article = PlatformArticleDistribute::leftJoin($article, $article . '.id', '=', $distribute . '.article_id')
            ->where($distribute . '.account_id','-1')
            ->where($distribute . '.is_get', 0)
            ->where($distribute . '.status',0)
            ->where($distribute . '.issue_time', '<=', date('Y-m-d H:i:s'))
            ->orderBy($distribute . '.issue_time', 'asc')
            ->select([
                $distribute.'.id',
                $distribute.'.article_id',
                $distribute.'.issue_type',
                $article.'.type',
                $article.'.title',
                $article.'.desc',
                $article.'.face_image',
            ])
            ->lockForUpdate()   //对数据进行了共享锁
            ->first()
            ->toArray();

        /*
        * 有可领取文章（需做修改）：
        *  1.更改为已领取
        *  2.剩余篇数没有减
        */
        if(!empty($is_article)){
            //修改文章为领取
            PlatformArticleDistribute::where("id" ,$is_article['id'])
                ->update([
                    'is_get' => 1,
                    'update_time' => date('Y-m-d H:i:s'),
                    'account_id'=>$account_id
                ]);
            DB::commit();
            //获取专辑/图集信息
            if($is_article['type']==2){
                $articleData = ArticleAlbums::where("article_id",$is_article['article_id'])->orderBy('order_by','asc')
                    ->get()->toArray();
            }elseif ($is_article['type']==1){
                $articleData = ArticlePics::where("article_id",$is_article['article_id'])
                    ->orderBy('order_by','asc')
                    ->orderBy('image_type','asc')
                    ->get()->toArray();
            }

            $arr['id'] = $is_article['article_id'];
            $arr['type'] = 0;
            $arr['title'] = $is_article['title'];
            $arr['sex'] = '';
            $arr['issue_type'] = $is_article['issue_type'];

            if($is_article['type']==2){
                $arr['article_type'] = 0;
                $arr['content'] = $this->changeAlbumsStruct($articleData);
            }elseif ($is_article['type']==1){
                $arr['article_type'] = 1;
                $arr['content'] = $this->changePicStruct($articleData);
            }
            $result['data'][] = $arr;
        }else{
            $result='没有文章！';
            DB::commit();
        }
        return $result;
    }

    public function writeDistributeStatu(Request $request)
    {
        $account_id = !empty($request['account_id'])?$request['account_id']:null;
        $article_id = !empty($request['article_id'])?$request['article_id']:null;
        $status = !empty($request['status'])?$request['status']:-1;
        $draft_id = !empty($request['draft_id'])?$request['draft_id']:"";
        $fail_cause = !empty($request['fail_cause'])?$request['fail_cause']:"";
        $platform_article_status = !empty($request['platform_article_status'])?$request['platform_article_status']:-1;

        try {
            $result['code'] = 0;
            $result['errMsg'] = '';
            $result['msg'] = '';

            if (empty($account_id))
                throw new \Exception('「account_id」不能为空!');
            if (empty($article_id))
                throw new \Exception('「article_id」不能为空!');
            if ($status == -1)
                throw new \Exception('「status」不能为空!');

            $where['account_id'] = $account_id;
            $where['article_id'] = $article_id;
            $update['status'] = $status;
            $update['draft_id'] = $draft_id;
            $update['platform_article_status'] = $platform_article_status;
            $update['update_time'] = date('Y-m-d H:m:s');
            $update['fail_cause'] = $fail_cause ?? '';

            $sign = PlatformArticleDistribute::where('account_id',$account_id)->where('article_id',$article_id)->update($update);

            // 发布成功、自动提交标题
            if($status == 1){
                $user_id = Article::where("id",$article_id)->value('user_id');
                if(!empty($user_id))
                    $temai_uid = Administrator::where('id',$user_id)->value('temai_uid');
                if(!empty($temai_uid)){
                    $this->getTitle($temai_uid,$article_id);
                }
            }

            if(!empty($sign)){
                $result['msg'] = '状态更新成功！';
                $result['status'] = $status;
            }
        } catch (\Exception $e) {
            $result['code'] = 1;
            $result['errMsg'] = $e->getMessage();
        } finally {
            exit(json_encode($result, JSON_UNESCAPED_UNICODE));
        }
    }

    // 重置一小时前已领取但未回写状态数据
    public function resetDistributeStatus()
    {
        try {
            $where['is_get'] = 1;
            $where['status'] = 0;
            $where['update_time'] = array('elt', date('Y-m-d H:m:s', strtotime('-1 hours')));
            PlatformArticleDistribute::where('is_get',1)->where('status',0)
                ->where('update_time','<=',date('Y-m-d H:m:s', strtotime('-1 hours')))
                ->update([
                    'update_time' => date('Y-m-d H:m:s'),
                    'is_get' => 0
                ]);
            echo '操作成功！';
        } catch (\Exception $e) {
            echo '操作失败！';
        }
    }

    public function getTitle($temai_uid, $article_id)
    {
        $title = Article::where('id',$article_id)->value('title');

        if(!empty($title)){
            $post_data = array(
                'temai_user_id' => $temai_uid,
                'title' => "$title"
            );

            $response = $this->send_post("http://tm.youdnr.com/api/temai/article/submitarticletitle", $post_data);

            $response = json_decode($response);
            $data['msg'] = $response->msg;
            $data['status'] = $response->status;
            $data['is_exist'] = $response->is_exist;
            /*
             * is_exist：1，说明其他的用户提交了这个标题，如果是2的话，是自己提交过这个标题
             * { "msg": "添加成功！",  "status": 0,  "is_exist": 0}
             */
            if ($data['status'] == 0 && $data['is_exist'] == 0) {
                Article::where('id',$article_id)
                    ->update([
                        'is_exist' => 2
                    ]);
            } elseif ($data['status'] == 0 && $data['is_exist'] == 2) {
                Article::where('id',$article_id)
                    ->update([
                        'is_exist' => 2
                    ]);
            } elseif ($data['status'] == 0 && $data['is_exist'] == 1) {
                Article::where('id',$article_id)
                    ->update([
                        'is_exist' => 1,
                        'exist_msg' => $data['msg']
                    ]);
            }
        }
//        $this->ajaxReturn($data);
    }

    private function send_post($url, $post_data) {
        $postdata = http_build_query($post_data);
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