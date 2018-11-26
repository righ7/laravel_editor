<?php

namespace App\Admin\Controllers\TeMaiArticle;

use App\Admin\Models\Article\Article;
use App\Admin\Models\BaseInfo\TemaiProductInfo;
use App\Admin\Models\Article\ArticlePics;
use App\Admin\CommonMethod\CArticle;
use App\Admin\Requests\ArticleApiRequest;
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
use Carbon\Carbon;

class AdminArticleController extends Controller
{
    public function index()
    {
        Admin::disablePjax();
        $items=array();
        $items=\GuzzleHttp\json_encode($items);
        $title='';
        $article_id='';
        return Admin::content(function (Content $content) use($items,$title,$article_id) {

            $content->header('发布图集');
            $content->description('添加');

            $content->body(view('portal.Pics.add_pics',compact('items','title','article_id')));
        });
    }

    //编辑图集
    public function editPics(Article $article)
    {
        Admin::disablePjax();
        $article_id = $article->id;

        $article_title=$article->title;
        //获取图集文章数据
        $articlePics = ArticlePics::where('article_id', $article_id)->orderBy('order_by', 'asc')->get()->toArray();

        $articlePics_array = [];
        $arrGoodsId_new = [];
        $arrProductId_new = [];

        if(!empty($article_id)){

            foreach ($articlePics as $kkk => $vvv) {
                $arrProductId_new[] = $vvv['product_id'];
                $arrGoodsId_new[] = $vvv['goods_id'];
                if($vvv['image_type'] ==1)
                {
                    $articlePics_array[$vvv['product_id']][0] = $vvv;
                }
                else
                {
                    $articlePics_array[$vvv['product_id']][1] = $vvv;
                }
            }

            //整合后的id
            $product_ids=array_unique($arrProductId_new);
            $arrGoodsId_new = array_unique($arrGoodsId_new);
            $post_data = array(
                'product_ids' => $product_ids
            );

            //获取产品价格、销量等数据
            $arrProduct_data = $this->send_post('http://baseinfo.youdnr.com/api/getgoodspricefromid', $post_data);
            $arrProduct_data = json_decode($arrProduct_data, true);
            $arrProduct = $arrProduct_data['data'];

        }

        //判断文章是否有产品

        if(empty($product_ids)){
           // header('location:/admin/articles');    //支持页面回跳
            $items=array();
            $items=json_encode($items);
            $title=$article_title;
            return Admin::content(function (Content $content) use($items,$title,$article_id) {

                $content->header('发布图集');
                $content->description('添加');

                $content->body(view('portal.Pics.add_pics',compact('items','title','article_id')));
            });

           // exit;
        }

        //公共库获取商品数据
        $ids='';
        foreach ($product_ids as $kk=>$vv){
            $ids.=$vv.',';
        }
        $ids=$newstr = substr($ids,0,strlen($ids)-1);
        $dataArr=$this->getGoodsData($ids,0);
        //整理赋值
        foreach ($dataArr as $k=>$v){
            $imagesArr[$v['product_id']]=$v;
        }


        $items=array();
        $goodsDatas=array();
        $index=0;
        //整合前端items数组数据
        foreach ($product_ids as $k=>$v){
            $product_id = $v;

            if(!empty($articlePics_array[$product_id])){

                $arrEntry_all = $articlePics_array[$product_id];
                foreach ($arrEntry_all as $key11=>$arrEntry){

                    //副图
                    if ($arrEntry['image_type'] == 2) {
                        $goodsDatas[$v]['sub_describe'] = $arrEntry['describe'] ?? '';
                        //图片处理
                        if(strstr($arrEntry['image'],'Uploads') && strstr($arrEntry['image'],'http')===false){
                            $goodsDatas[$v]['sub_pic'] ="http://platform.youdnr.com".$arrEntry['image'];
                        }else{
                            $goodsDatas[$v]['sub_pic'] =$arrEntry['image'];
                        }

                        $goodsDatas[$v]['sub_describe_recommend'] = $arrEntry['describe'] ?? '';
                    }

                    //主图
                    if ($arrEntry['image_type'] == 1) {
                        $goodsDatas[$v]['main_describe'] = $arrEntry['describe'] ?? '';
                        //图片处理
                        if(strstr($arrEntry['image'],'Uploads') && strstr($arrEntry['image'],'http')===false){
                            $goodsDatas[$v]['main_pic'] ="http://platform.youdnr.com".$arrEntry['image'];
                        }else{
                            $goodsDatas[$v]['main_pic'] = $arrEntry['image'];
                        }
                        $goodsDatas[$v]['title'] = $arrEntry['title'];
                        $goodsDatas[$v]['getDescribeNumber'] = -1;
                        $goodsDatas[$v]['getSubDescribeNumber'] = -1;
                        $goodsDatas[$v]['getTitleNumber'] = -1;
                        $goodsDatas[$v]['getChangeGoodsDescribe'] = [];
                        $goodsDatas[$v]['getChangeGoodsSubDescribe'] = [];
                        $goodsDatas[$v]['getChangeGoodsTitle'] = [];
                        $goodsDatas[$v]['product_id'] = $arrEntry['product_id'];

                        $goodsDatas[$v]['images']=$imagesArr[$v]['images'];

                        $goodsDatas[$v]['main_describe_recommend'] = $arrEntry['describe'] ?? '';
                        $goodsDatas[$v]['title_recommend'] = $arrEntry['title'] ?? '';

                        $items[$index]['goods_id'] = $arrEntry['product_id'];
                        $items[$index]['goods_url'] = $arrProduct[$arrEntry['product_id']]['goods_url'];
                        if (!empty($arrProduct[$arrEntry['product_id']]['commation_rate'])) {
                            $items[$index]['commission_rate'] = $arrProduct[$arrEntry['product_id']]['commation_rate'];
                        }
                        if (!empty($arrProduct[$arrEntry['product_id']]['price'])) {
                            $items[$index]['price'] = $arrProduct[$arrEntry['product_id']]['price'] / 100;
                        }
                        $items[$index]['shop_name'] = $arrProduct[$arrEntry['product_id']]['shop_name'];
                        $items[$index]['sell_num'] = $arrProduct[$arrEntry['product_id']]['sell_num'];
                        $items[$index]['id'] = $arrEntry['goods_id'];
                    }
                }

                $items[$index]['goodsDatas']=$goodsDatas[$v];
            }



            $index++;

        }


            $items=json_encode($items);
            $title=$article_title;

            return Admin::content(function (Content $content) use($items,$title,$article_id) {

                $content->header('发布图集');
                $content->description('添加');

                $content->body(view('portal.Pics.add_pics',compact('items','title','article_id')));
            });

    }

    function send_post($url, $post_data) {
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

    //平台标题重复率检测
    public function checkArticleTitle(Request $request){
        $title=$request->title;
        $article_id=$request->article_id ?? '';

        if(empty($article_id)){
            $re=DB::table('article')
                ->where("title",$title)
                ->value('title');
        }else{
           // DB::connection()->enableQueryLog(); // 开启查询日志
            $re=DB::table('article')->where([
                ['title',$title],
                ['id','!=',$article_id]
            ])->value('title');
           // $queries = DB::getQueryLog(); // 获取查询日志

        }
        if(empty($re)){
            $return['code']=0;
        }else{
            $return['code']=1;
            $return['title']=$re;
        }
        return json_encode($return);
    }

    //获取商品id
    public function getSelectGoodsPreData(){
        $data = request()->all();
        $url=$data['link'];
        $arr = explode("\n", $url);
        $ids='';
        foreach ($arr as $k=>$v){
            $urlArr = explode("id=", $v);
            $ids.=$urlArr[1].',';
        }
        $ids=$newstr = substr($ids,0,strlen($ids)-1);
        return json_encode($ids);
    }
    //发布图集：插入选择的商品
    public function getSelectGoodsWaitData(){
        $data = request()->all();
        $strSelectProductId=$data['select_product_id'];
        $type = !empty($data['type'])?$data['type']:0;

        $arrReturn=$this->getGoodsData($strSelectProductId,$type);

        $arrTitleReturn=$this->waitTitle($strSelectProductId);


        $return = array(
            'CODE' => 'ok',
            'DATA' => $arrReturn,
            'waitTitle'=>$arrTitleReturn
        );
        return json_encode($return);
    }
    protected function selectGoodsWaitData($product_id){
        $strSelectProductId=$product_id;
        $arrReturn=$this->getGoodsData($strSelectProductId,0);

        $arrTitleReturn=$this->waitTitle($strSelectProductId);


        $return = array(
            'CODE' => 'ok',
            'DATA' => $arrReturn,
            'waitTitle'=>$arrTitleReturn
        );
        return $return;
    }
    //获取商品数据
    public function getGoodsData($strSelectProductId,$type){
        if(!empty($strSelectProductId)){
            $arrData = $this->getGoodsDescribeById($strSelectProductId,$type);


            $arrReturn = array();
            $arrEntry = array();
            foreach ($arrData->data as $key => $objEntry) {

                //$objEntry = $arrData->data;
                $arrEntry['main_describe'] = $objEntry->main_description[0];
                if(empty($objEntry->main_description[1])){
                    $arrEntry['main_describe_recommend'] = '';
                }else{
                    $arrEntry['main_describe_recommend'] = $objEntry->main_description[1];
                }
                $arrEntry['sub_describe'] = $objEntry->vice_description[0];
                if(empty($objEntry->vice_description[1])){
                    $arrEntry['sub_describe_recommend'] ='';
                }else{
                    $arrEntry['sub_describe_recommend'] = $objEntry->vice_description[1];
                }
                $arrEntry['product_id'] = $objEntry->goods_id;
                $arrEntry['is_exact'] = $objEntry->is_exact;
                foreach ($objEntry->img as $k => $arrEntryImg) {
                    $arrEntry['images'][$k] = $arrEntryImg;
                }
                $arrReturn[$key] = $arrEntry;
            }

        }

        return $arrReturn;
    }
    //获取商品标题
    public function waitTitle($strSelectProductId){
        if (!empty($strSelectProductId)) {
            $arrTitleData = $this->getGoodsTitlesById($strSelectProductId);
            $arrTitleReturn = array();
            $idArr=explode(',',$strSelectProductId);
            foreach ($arrTitleData->data as $key => $objEntry) {

                $arrTitleEntry = array();

                if(empty($objEntry) || count($objEntry)==1){
                    $arrTitleEntry['title'] = $objEntry[0];
                    $arrTitleEntry['title_recommend'] = $objEntry[0];
                }else{
                    $arrTitleEntry['title'] = $objEntry[0];
                    $arrTitleEntry['title_recommend'] = $objEntry[1];
                }
                $arrTitleEntry['product_id'] = $key;
                $title_recommend_more = array();
                foreach ($objEntry as $k => $arrEntrys) {
                    if($k>=2){
                        $title_recommend_more[$k] = $arrEntrys;
                    }
                }
                $arrTitleEntry['title_recommend_more'] = array_values($title_recommend_more);
                $arrTitleReturn[$key] = $arrTitleEntry;
            }
            foreach ($idArr as $k=>$v){
                if (!isset($arrTitleReturn[$v])){
                    $title=TemaiProductInfo::where('product_id',$v)->value('name');
                    $title=mb_substr($title,0,20,'utf-8');
                    $arrTitleReturn[$v]['product_id']=$v;
                    $arrTitleReturn[$v]['title']= $title;
                    $arrTitleReturn[$v]['title_recommend']='';
                    $arrTitleReturn[$v]['title_recommend_more']=[];
                }
            }
//            if(empty($arrTitleReturn)){
//                $arrTitleReturn[]['title'] = TemaiProductInfo::where('product_id',$strSelectProductId)->value('name');
//                $arrTitleReturn[]['title_recommend']='0';
//                $arrTitleReturn[]['title_recommend_more']  = [];
//            }


        }
        return $arrTitleReturn;
    }
    /**
     * 获取换一换产品标题
     * @param $arrSelectProductId
     * @return array|mixed
     */
    public function getChangeGoodsTitle(Request $request)
    {
        $strSelectProductId = $request->goods_id;
        if (empty($strSelectProductId)) {
            return array();
        }

        $strGetUrl = "http://baseinfo.youdnr.com/api/goods/get_goods_article_title?";
        $strGetUrl .= 'goods_id=' . $strSelectProductId;
        $arrGoodsData = file_get_contents($strGetUrl);
        $arrData = json_decode($arrGoodsData);

        $arrReturn = array();
        foreach ($arrData->data as $key => $objEntry) {
            foreach ($objEntry as $k => $entry) {
                $arrReturn['title'][] = $entry;
            }
        }
        if (empty($arrReturn)) {
            $return = array(
                'CODE' => 'EMPTY',
                'DATA' => array(),
            );
            return json_encode($return);
        }
        $return = array(
            'CODE' => 'ok',
            'DATA' => $arrReturn['title'],
        );

        return json_encode($return);

    }

    /**
     * 获取换一换产品描述
     * @param $arrSelectProductId
     * @return array|mixed
     */
    public function getChangeGoodsDescribe(Request $request)
    {

        $strSelectProductId = $request->goods_id;
        $type  = !empty($request->type)?$request->type:0;
        //$strSelectProductId = '3306765314485781151';

        if (empty($strSelectProductId)) {
            return array();
        }

        $strGetUrl = 'https://baseinfo.youdnr.com/api/info/getgoodsinfo?';
        $strGetUrl .= 'goods_ids=' . $strSelectProductId . '&fuzzy_des=1&type_level=3&tool_type='.$type.'&des_count=' . '10';
        $arrGoodsData = file_get_contents($strGetUrl);
        $arrData = json_decode($arrGoodsData);

        $arrReturn = array();
        $resultFlag = true;
        foreach ($arrData->data as $key => $objEntry) {

            if(!empty($objEntry->main_description)){
                foreach ($objEntry->main_description as $k => $entry) {

                    if ($entry == 'null') {
                        $resultFlag = false;
                        break;
                    }
                    $arrReturn['main_describe'][] = $entry;
                }
            }else{
                $arrReturn['main_describe'][] = '';
            }

        }
        if (empty($arrReturn)) {
            $return = array(
                'CODE' => 'EMPTY',
                'DATA' => array(),
            );
            return json_encode($return);
        }
        $return = array(
            'CODE' => 'ok',
            'DATA' => $arrReturn['main_describe'],
        );
        return json_encode($return);

    }

    /**
     * 获取换一换产品副图描述
     * @param $arrSelectProductId
     * @return array|mixed
     */
    public function getChangeGoodsSubDescribe(Request $request)
    {
        $strSelectProductId =  $request->goods_id;
        //$strSelectProductId =  '3306765314485781151';

        if (empty($strSelectProductId)) {
            return array();
        }

        $strGetUrl = 'https://baseinfo.youdnr.com/api/info/getgoodsinfo?';
        $strGetUrl .= 'goods_ids=' . $strSelectProductId . '&fuzzy_des=1&type_level=3&tool_type=0&des_count=' . '10';
        $arrGoodsData = file_get_contents($strGetUrl);
        $arrData = json_decode($arrGoodsData);
//dd($arrData);
        $arrReturn = array();
        $resultFlag = true;
        foreach ($arrData->data as $key => $objEntry) {
            foreach ($objEntry->vice_description as $k => $entry) {
                if ($entry == 'null') {
                    $resultFlag = false;
                    break;
                }
                $arrReturn['vice_description'][] = $entry;
            }
        }
        if (!$resultFlag) {
            $return = array(
                'CODE' => 'EMPTY',
                'DATA' => array(),
            );
            return json_encode($return);
        }
        $return = array(
            'CODE' => 'ok',
            'DATA' => $arrReturn['vice_description'],
        );
        return json_encode($return);

    }

    //检测敏感词，返回提示
    public function checkContentSensitiveWord(Request $request)
    {
//
        $data =  $request->params;
        $dataArr=$data['goods_datas'];

        //$dataArr =  $request->goods_datas;

        //读取敏感词 内容
        $sensitiveWordArr= DB::table('article_sensitive_word')->where([
            ['keywords_type',0],
            ['type',2]
        ])->select('keywords')->get()->toArray();
        foreach ($sensitiveWordArr as $k=>$v){
            $arrSensitiveWord[]=$v->keywords;
        }


        $arrReturn = array();
        if (!empty($dataArr)) {
            $findMainDescribeResultFlag   = false;
            $findSubDescribeResultFlag   = false;
            $findTitleDescribeResultFlag = false;
            //echo '<pre>';
            $wordArr='';
            foreach ($dataArr as $key => $entry) {

                $findMainDescribeResult = $this->checkFindTextBySensitiveWord($entry['main_describe'], $arrSensitiveWord);

                //var_dump($findMainDescribeResult);
                if (!empty($findMainDescribeResult)) {
                    $wordArr.=$findMainDescribeResult.'、';
                    $arrReturn['main_des_'.$entry['product_id']] = $findMainDescribeResult;
                    $findMainDescribeResultFlag   = true;
                }else{
                    $arrReturn['main_des_'.$entry['product_id']] = '';
                }
                $findSubDescribeResult = $this->checkFindTextBySensitiveWord($entry['sub_describe'], $arrSensitiveWord);
                //    var_dump($findSubDescribeResult);
                if (!empty($findSubDescribeResult)) {
                    $wordArr.=$findSubDescribeResult.'、';
                    $arrReturn['sub_des_'.$entry['product_id']] = $findSubDescribeResult;
                    $findSubDescribeResultFlag   = true;
                }else{
                    $arrReturn['sub_des_'.$entry['product_id']] = '';
                }
                $findTitleResult = $this->checkFindTextBySensitiveWord($entry['title'], $arrSensitiveWord);
                //    var_dump($findTitleResult);
                if (!empty($findTitleResult)) {
                    $wordArr.=$findTitleResult;
                    $findTitleDescribeResultFlag   = true;
                    $arrReturn['title_'.$entry['product_id']] = $findTitleResult;
                }else{
                    $arrReturn['title_'.$entry['product_id']] = '';
                }
            }
        }
//        var_dump($findMainDescribeResultFlag);
//        var_dump($findSubDescribeResultFlag);
//        var_dump($findTitleDescribeResultFlag);

//        exit;
        if ($findTitleDescribeResultFlag || $findMainDescribeResultFlag || $findSubDescribeResultFlag) {
            $return = array(
                'CODE' => 'SENSITIVE_WORD',
                'DATA' => $arrReturn,
                'word' => $wordArr,
            );
        } else {

            $return = array(
                'CODE' => 'NO_SENSITIVE_WORD',
            );
        }
        return json_encode($return);
    }

    //敏感词校验
    public function checkFindTextBySensitiveWord($strText,$arrSensitiveWord){

        if(empty($strText)){
            return '';
        }
        if(empty($arrSensitiveWord)){
            return '';
        }
        $findFlag = false;
        $strResult = '';

        foreach($arrSensitiveWord as $key=>$str){

            if(!empty($str)){
                $re=strstr($strText,$str);
                if($re){
                    $findFlag = true;
                    $strResult = $str;
                    break;
                }
            }

        }

        return $strResult;
    }

    //清除敏感词
    public function changeSensitiveWord(Request $request){
        $data =  $request->params;
        $dataArr=$data['goods_datas'];


        //读取敏感词 内容
        $sensitiveWordArr= DB::table('article_sensitive_word')->where([
            ['keywords_type',0],
            ['type',2]
        ])->select('keywords')->get()->toArray();
        foreach ($sensitiveWordArr as $k=>$v){
            $arrSensitiveWord[]=$v->keywords;
        }

        if(!empty($dataArr)){
            foreach ($dataArr as $key => $entry) {
                $arrReturn[$key]=$entry;
                $arrReturn[$key]['main_describe'] = $this->deleteTextBySensitiveWord($entry['main_describe'], $arrSensitiveWord);
                $arrReturn[$key]['sub_describe'] = $this->deleteTextBySensitiveWord($entry['sub_describe'], $arrSensitiveWord);

                $arrReturn[$key]['title'] = $this->replaceTextBySensitiveWord($entry['title'], $arrSensitiveWord);

            }
        }

        $return = array(
            'CODE' => 'ok',
            'DATA' => $arrReturn,
        );
        return json_encode($return);

    }
    //清除敏感词
    function deleteTextBySensitiveWord($strText,$arrSensitiveWord){

        if(empty($strText)){
            return '';
        }
        if(empty($arrSensitiveWord)){
            return '';
        }
        // $arrText = explode("，",$strText);
        $strText = $strText." ";
        $preg = '/(.*?)(，|。|！|,|!|\s)/i';//匹配img标签的正则表达式
        preg_match_all($preg, $strText, $arrText);//这里匹配所有的img
        $strResultText = '';
        //var_dump($arrText);
        foreach($arrText[0] as $key=>$str){

            if(!empty($str)){
                $findResult = $this->findTextBySensitiveWord($str,$arrSensitiveWord);
                if($findResult){
                    continue;
                }
                $strResultText .=trim($str);
            }

        }

        return !empty($strResultText)?$strResultText:'';
    }

    /**替换敏感词文本**/
    function replaceTextBySensitiveWord($strText,$arrSensitiveWord){

        if(empty($strText)){
            return '';
        }
        // var_dump($arrSensitiveWord);
        if(empty($arrSensitiveWord)){
            return '';
        }
        foreach($arrSensitiveWord as $key=>$str){
            if(!empty($str)){
                if(strstr($strText,$str)){
                    $strText = str_replace($str,"",$strText);
                }
            }

        }
        $strText=mb_substr($strText,0,20,'utf-8');
        return $strText;
    }
    //清除敏感词
    function findTextBySensitiveWord($strText,$arrSensitiveWord){

        if(empty($strText)){
            return '';
        }
        if(empty($arrSensitiveWord)){
            return '';
        }
        $findFlag = false;
        foreach($arrSensitiveWord as $key=>$str){
            if(!empty($str)){
                if(strstr($strText,$str)){
                    $findFlag = true;
                    break;
                }
            }

        }
        return $findFlag;
    }

    //提交审核
    public function auditArticle(Request $request){
        $arrDatas=$request;
        $data =  $request->params;
        $goodsArr=$data['goodsArr'];
        $articleTitle=$data['articleTitle'];

        if(empty($articleTitle)){
            $return = array(
                'CODE' => 'error',
                'DATA' => '提交参数缺失！',
            );
            return json_encode($return);
        }
        if(count($goodsArr) < 10){
            $return = array(
                'CODE' => 'error',
                'DATA' => '至少要添加10个图集宝贝模块才能提交审核！',
            );
            return json_encode($return);
        }
        /**
         * 免审核代码
         * 需要修改的字段， $article_id
         * 用户是免审核，直接跳过审核步骤，将数据存入分发表
         */
        $user_id=Admin::user()->id;
        $user= DB::table('cmf_users')->where([
            ['id',$user_id],
        ])->select()->get()->first();

        //存草稿
        $article_id=$this->saveArticle($data);
        $rs = CArticle::dataCheck($article_id);
        if($rs=='true'){
            if ($user->is_avoid_audit == 1) { // 判断用户是否免审核
                $rsArticle = CArticle::avoidAudit($article_id);
            }else{
                //待审核
                $arrSave = array();
                $arrSave['status'] = 3;//0 删除 1已审核 2草稿 3待审核 4未通过
                $arrSave['update_time'] =  Carbon::now()->timestamp;
                if (!empty($articleTitle)) {
                    $arrSave['title'] = $articleTitle;
                }
                $arrConn = array();
                $arrConn['id'] = $article_id;
                $arrConn['user_id'] = Admin::user()->id;
                $rsArticle = DB::table('article')->where($arrConn)->update($arrSave);
                if($rsArticle){
                    $rsArticle='true';
                }
            }
//            if ($user->is_avoid_audit == 1) { // 判断用户是否免审核
//
//                //DB::connection()->enableQueryLog();
//                $res=DB::table('article')->where("id", $article_id)
//                    ->update([
//                        'status' => 1,
//                        'update_time' =>  Carbon::now()->timestamp,
//                    ]);
//
//                //print_r(DB::getQueryLog());
//                //dd($res);
//                if($user->direct_issue == 1){
//                    $accounts = DB::table('platform_permission')
//                        ->where("user_id",$user_id)
//                        ->select()->get()->toArray();
//
//                    $issue_time = DB::table('article')
//                        ->where("id",$article_id)
//                        ->value('plan_online_time');
//
//                    if(!empty($accounts)){
//                        foreach ($accounts as $k => $account) { // 数据转换存入平台分发表
//                            $list[$k]['article_id'] = $article_id;
//                            $list[$k]['account_id'] = $account->shop_id;
//                            $list[$k]['platform_id'] = $account->platform_id;
//                            $list[$k]['status'] = 0;
//                            $list[$k]['is_get'] = 0;
//                            $list[$k]['article_type'] = 1;//1 图集
//                            $list[$k]['issue_type'] = $user->direct_draft == 1 ? 0 : 1;
//                            $list[$k]['fail_cause'] = '';
//                            $list[$k]['issue_time'] = !empty($issue_time) ? date('Y-m-d H:i:s',$issue_time):date('Y-m-d H:i:s');
//                            $list[$k]['create_time'] = date('Y-m-d H:i:s');
//                            $list[$k]['update_time'] = date('Y-m-d H:i:s');
//
//                        }
//
//
//                        if (!empty($list)) {
//                            $count = DB::table('platform_article_distribute')->where("article_id",$article_id)->count();
//
//                            if(!$count){
//                                $z = rand(0,count($list)-1);
//                                DB::table('platform_article_distribute')->insert($list[$z]);
//                            }
//                        }
//
//                    }else{
//                        $temaiAccounts = $this->platformAccountArray();
//
//                        //判断是否有开启的特卖号
//                        if(!empty($temaiAccounts)){
//                            $list['article_id'] = $article_id;
//                            $list['account_id'] = -1;
//                            $list['platform_id'] = 4;
//                            $list['status'] = 0;
//                            $list['is_get'] = 0;
//                            $list['article_type'] = 1;//1 图集
//                            $list['issue_type'] = $user->direct_draft == 1 ? 0 : 1;
//                            $list['fail_cause'] = '';
//                            $list['issue_time'] = !empty($issue_time) ? date('Y-m-d H:i:s',$issue_time):date('Y-m-d H:i:s');
//                            $list['create_time'] = date('Y-m-d H:i:s');
//                            $list['update_time'] = date('Y-m-d H:i:s');
//
//                            if (!empty($list)) {
//
//                                $count = DB::table('platform_article_distribute')->where("article_id",$article_id)->count();
//                                //var_dump($count);
//                                if(!$count){
//                                    //$z = rand(0,count($list)-1);
//                                    DB::table('platform_article_distribute')->insert($list);
//                                }
//                            }
//
//                        }
//
//                    }
//
//
//                }
////var_dump($article_id);
//                $arrConn = array();
//                $arrConn['id'] = $article_id;
//                $arrConn['user_id'] =Admin::user()->id;
//                $arrSave = array();
//                $arrSave['status'] = 1;//0 删除 1已审核 2草稿 3待审核 4未通过
//                $arrSave['update_time'] =  Carbon::now()->timestamp;
//                if (!empty($articleTitle)) {
//                    $arrSave['title'] = $articleTitle;
//                }
//                $rsArticle = DB::table('article')->where($arrConn)->update($arrSave);
//                //var_dump($rsArticle);exit;
//            } else {
//                //待审核
//                $arrSave = array();
//                $arrSave['status'] = 3;//0 删除 1已审核 2草稿 3待审核 4未通过
//                $arrSave['update_time'] =  Carbon::now()->timestamp;
//                if (!empty($articleTitle)) {
//                    $arrSave['title'] = $articleTitle;
//                }
//                $arrConn = array();
//                $arrConn['id'] = $article_id;
//                $arrConn['user_id'] = Admin::user()->id;
//                $rsArticle = DB::table('article')->where($arrConn)->update($arrSave);
//            }
        }else{
            $return = array(
                'CODE' => 'error',
                'DATA' => $rs,
                'article_id'=>$article_id
            );
            return json_encode($return);
        }


        if ($rsArticle == 'true') {
            $return = array(
                'CODE' => 'success',
                'DATA' => '操作成功！',
                'article_id'=>$article_id
            );
        }else{
            $return = array(
                'CODE' => 'error',
                'DATA' => '操作失败！',
                'article_id'=>$article_id
            );
        }

        return json_encode($return);
    }

    /**
     * 返回平台特卖号账户数组
     * @return mixed
     */
    private function platformAccountArray()
    {
//        $where['shop_id'] = array('exp', 'IS NOT NULL ');
//        $where['status'] = 1;
//        $where['is_start'] = 1;//开启
//        $where['platform'] = 4;//特卖号
        $where=[
//            ['shop_id',array('exp', 'IS NOT NULL ')],
            ['status',1],
            ['is_start',1],
            ['platform',4]
        ];

        $res=DB::table('platform_account')->where($where)->first();
        return $res;
    }

    //预览
    public function setArticleStatus(){
        $type='add';
        return view('portal.Pics.preview',compact('type'));
    }
    public function setArticleEditStatus(){
        $type='edit';
        return view('portal.Pics.preview',compact('type'));
    }
    //存草稿(旧)
    public function saveArticlePics1(Request $request){
        $data = $request->params;
        $goodsArr=$data['goodsArr'];
        $title=$data['articleTitle'];
        $planTime=$data['planTime'];//定时发布时间
        $article_id=$data['article_id'];//文章id


        if(empty($planTime)){
            $planOnlineTime=time();
        }else{
            $planOnlineTime=strtotime($planTime);
        }
        //用户id
        $user_id=Admin::user()->id;

        $arrArticleData['user_id']          =  $user_id;
        $arrArticleData['article_number']  =  date('YmdHis').rand(1000, 9999);
        $arrArticleData['title']             =  $title;
        $arrArticleData['type']              =  1;   //图集
        $arrArticleData['plan_online_time'] = $planOnlineTime;//定时发布时间
        $arrArticleData['article_type']    = 0;
        $arrArticleData['status']           =  2;   //草稿   C('ARTICLE_STATUS.DRAFT');
        $arrArticleData['create_time']     =   Carbon::now()->timestamp;
        $arrArticleData['update_time']     =   Carbon::now()->timestamp;
        $arrArticleData['updated_at']     =   date("Y-m-d H:i:s");


        //存文章表，状态为：草稿
        if(empty($article_id)){
            $arrArticleData['created_at']     =   date("Y-m-d H:i:s");
            $article_id=DB::table("article")->insertGetId($arrArticleData);
//       var_dump($article_id);exit;
            if(!empty($article_id)){
                //存描述
                $strOrderBy = 1;
                foreach ($goodsArr as $k=>$v){
                    if(!empty($v['goodsDatas']['main_describe'])){

                        $arrArticlePics[0]['image']       =  $v['goodsDatas']['main_pic'];
                        $arrArticlePics[0]['describe']    =  $v['goodsDatas']['main_describe'];
                        $arrArticlePics[0]['image_type'] =  1;//1 主图 2副图
                        $arrArticlePics[0]['title']       =   $v['goodsDatas']['title'];
                        $arrArticlePics[0]['user_id']     =  $user_id;
                        $arrArticlePics[0]['article_id'] =  $article_id;
                        $arrArticlePics[0]['goods_id']    =  $v['id'];
                        $arrArticlePics[0]['product_id']  =  $v['goods_id'] ;
                        $arrArticlePics[0]['order_by']   =  $strOrderBy;
                        $arrArticlePics[0]['updated_at']     =   date("Y-m-d H:i:s");
                        $arrArticlePics[0]['created_at']     =   date("Y-m-d H:i:s");
                    }

                    if(!empty($v['goodsDatas']['sub_describe'])){
                        $arrArticlePics[1]['image']       =   $v['goodsDatas']['sub_pic'];
                        $arrArticlePics[1]['describe']    =  $v['goodsDatas']['sub_describe'];
                        $arrArticlePics[1]['image_type'] =  2;//1 主图 2副图
                        $arrArticlePics[1]['title'] = '';
                        $arrArticlePics[1]['user_id']    =  $user_id;
                        $arrArticlePics[1]['article_id'] =  $article_id;
                        $arrArticlePics[1]['goods_id']   =   $v['id'];
                        $arrArticlePics[1]['product_id']  = $v['goods_id'] ;
                        $arrArticlePics[1]['order_by']   =  $strOrderBy;
                        $arrArticlePics[1]['updated_at']     =   date("Y-m-d H:i:s");
                        $arrArticlePics[1]['created_at']     =   date("Y-m-d H:i:s");
                    }
                    DB::table("article_pics")->insert($arrArticlePics);
                    $strOrderBy++;
                }

            }
        }else{
                DB::table('article')->where("id", $article_id)
                ->update([
                    'title' => "$title",
                    'plan_online_time' => $planOnlineTime,
                    'status' => 2,
                    'updated_at' =>   date("Y-m-d H:i:s"),
                    'update_time' =>  Carbon::now()->timestamp
                ]);
                $articlePics = ArticlePics::where('article_id', $article_id)->orderBy('order_by', 'asc')->get();

                DB::table('article_pics')->where("article_id", $article_id)
                    ->delete();
                //存描述
                $strOrderBy = 1;
                foreach ($goodsArr as $k=>$v){
                    if(!empty($v['goodsDatas']['main_describe'])){

                        $arrArticlePics[0]['image']       =  $v['goodsDatas']['main_pic'];
                        $arrArticlePics[0]['describe']    =  $v['goodsDatas']['main_describe'];
                        $arrArticlePics[0]['image_type'] =  1;//1 主图 2副图
                        $arrArticlePics[0]['title']       =   $v['goodsDatas']['title'];
                        $arrArticlePics[0]['user_id']     =  $user_id;
                        $arrArticlePics[0]['article_id'] =  $article_id;
                        $arrArticlePics[0]['goods_id']    =  $v['id'];
                        $arrArticlePics[0]['product_id']  =  $v['goods_id'] ;
                        $arrArticlePics[0]['order_by']   =  $strOrderBy;
                        $arrArticlePics[0]['updated_at']     =   date("Y-m-d H:i:s");
                        $arrArticlePics[0]['created_at']     =   date("Y-m-d H:i:s");

                    }

                    if(!empty($v['goodsDatas']['sub_describe'])){
                        $arrArticlePics[1]['image']       =   $v['goodsDatas']['sub_pic'];
                        $arrArticlePics[1]['describe']    =  $v['goodsDatas']['sub_describe'];
                        $arrArticlePics[1]['image_type'] =  2;//1 主图 2副图
                        $arrArticlePics[1]['title'] = '';
                        $arrArticlePics[1]['user_id']    =  $user_id;
                        $arrArticlePics[1]['article_id'] =  $article_id;
                        $arrArticlePics[1]['goods_id']   =   $v['id'];
                        $arrArticlePics[1]['product_id']  = $v['goods_id'] ;
                        $arrArticlePics[1]['order_by']   =  $strOrderBy;
                        $arrArticlePics[1]['updated_at']     =   date("Y-m-d H:i:s");
                        $arrArticlePics[1]['created_at']     =   date("Y-m-d H:i:s");
                    }



                    DB::table("article_pics")->insert($arrArticlePics);
                    $strOrderBy++;
                }


        }
        //调用修改文章类型的方法
         CArticle::signContentType($article_id);
        return json_encode($article_id);

    }
    //存草稿(新)
    public function saveArticlePics(ArticleApiRequest $request){
        $data = !empty($request['params'])?$request['params']:null;
        if(!empty($data)){
            $goodsArr=$data['goodsArr'];//产品数组
            $title=$data['articleTitle'];//文章标题
            $planTime=$data['planTime'];//定时发布时间
            $article_id=$data['article_id'];//文章id


            //是否设置定时发布时间
            if(empty($planTime)){
                $planOnlineTime=time();
            }else{
                $planOnlineTime=strtotime($planTime);
            }
            //用户id
            $user_id=Admin::user()->id;

            $arrArticleData['user_id']          =  $user_id;
            $arrArticleData['article_number']  =  date('YmdHis').rand(1000, 9999);
            $arrArticleData['title']             =  $title;
            $arrArticleData['type']              =  1;   //图集
            $arrArticleData['plan_online_time'] = $planOnlineTime;//定时发布时间
            $arrArticleData['article_type']    = 0;
            $arrArticleData['status']           =  2;   //草稿   C('ARTICLE_STATUS.DRAFT');
            $arrArticleData['create_time']     =   Carbon::now()->timestamp;
            $arrArticleData['update_time']     =   Carbon::now()->timestamp;
            $arrArticleData['updated_at']     =   date("Y-m-d H:i:s");


            //存文章表，状态为：草稿
            if(empty($article_id)){
                $arrArticleData['created_at']     =   date("Y-m-d H:i:s");
                //插入文章数据
                $article_id=DB::table("article")->insertGetId($arrArticleData);
                if(!empty($article_id)){
                    $this->insertArticlePics($goodsArr,$article_id,$user_id);
                }
            }else{
                //修改文章数据
                DB::table('article')->where("id", $article_id)
                    ->update([
                        'title' => "$title",
                        'plan_online_time' => $planOnlineTime,
                        'status' => 2,
                        'updated_at' =>   date("Y-m-d H:i:s"),
                        'update_time' =>  Carbon::now()->timestamp
                    ]);
//                $articlePics = ArticlePics::where('article_id', $article_id)->orderBy('order_by', 'asc')->get();

                $this->updateArticlePics($goodsArr,$article_id,$user_id);


            }
        }

        //调用修改文章类型的方法
        CArticle::signContentType($article_id);
        return json_encode($article_id);


    }

    //主副图插入数据方法
    public function insertArticlePics($goodsArr,$article_id,$user_id){
        //存描述
        $strOrderBy = 1;
        foreach ($goodsArr as $k=>$v){

            //主图信息
            $arrArticlePics[0]['image']       =  $v['goodsDatas']['main_pic'];
            $arrArticlePics[0]['describe']    =  $v['goodsDatas']['main_describe'];
            $arrArticlePics[0]['image_type'] =  1;//1 主图 2副图
            $arrArticlePics[0]['title']       =   $v['goodsDatas']['title'];
            $arrArticlePics[0]['user_id']     =  $user_id;
            $arrArticlePics[0]['article_id'] =  $article_id;
            $arrArticlePics[0]['goods_id']    =  $v['id'];
            $arrArticlePics[0]['product_id']  =  $v['goods_id'] ;
            $arrArticlePics[0]['order_by']   =  $strOrderBy;
            $arrArticlePics[0]['updated_at']     =   date("Y-m-d H:i:s");
            $arrArticlePics[0]['created_at']     =   date("Y-m-d H:i:s");
            $arrArticlePics[0]['update_time'] = strtotime('now');
            $arrArticlePics[0]['create_time'] = strtotime('now');
            //副图信息
            $arrArticlePics[1]['image']       =   $v['goodsDatas']['sub_pic'];
            $arrArticlePics[1]['describe']    =  $v['goodsDatas']['sub_describe'];
            $arrArticlePics[1]['image_type'] =  2;//1 主图 2副图
            $arrArticlePics[1]['title'] = '';
            $arrArticlePics[1]['user_id']    =  $user_id;
            $arrArticlePics[1]['article_id'] =  $article_id;
            $arrArticlePics[1]['goods_id']   =   $v['id'];
            $arrArticlePics[1]['product_id']  = $v['goods_id'] ;
            $arrArticlePics[1]['order_by']   =  $strOrderBy;
            $arrArticlePics[1]['updated_at']     =   date("Y-m-d H:i:s");
            $arrArticlePics[1]['created_at']     =   date("Y-m-d H:i:s");
            $arrArticlePics[1]['update_time'] = strtotime('now');
            $arrArticlePics[1]['create_time'] = strtotime('now');

            DB::table("article_pics")->insert($arrArticlePics);
            $strOrderBy++;
        }
        return;
    }

    //主副图修改数据方法
    public function updateArticlePics($goodsArr,$article_id,$user_id){

        //存描述
        $strOrderBy = 1;
        foreach ($goodsArr as $k=>$v){

            $arrArticlePics[0]['image']       =  $v['goodsDatas']['main_pic'];
            $arrArticlePics[0]['describe']    =  $v['goodsDatas']['main_describe'];
            $arrArticlePics[0]['image_type'] =  1;//1 主图 2副图
            $arrArticlePics[0]['title']       =   $v['goodsDatas']['title'];
            $arrArticlePics[0]['user_id']     =  $user_id;
            $arrArticlePics[0]['article_id'] =  $article_id;
            $arrArticlePics[0]['goods_id']    =  $v['id'];
            $arrArticlePics[0]['product_id']  =  $v['goods_id'] ;
            $arrArticlePics[0]['order_by']   =  $strOrderBy;
            $arrArticlePics[0]['updated_at']     =   date("Y-m-d H:i:s");
            $arrArticlePics[0]['update_time'] = strtotime('now');
            //$arrArticlePics[0]['created_at']     =   date("Y-m-d H:i:s");



            $arrArticlePics[1]['image']       =   $v['goodsDatas']['sub_pic'];
            $arrArticlePics[1]['describe']    =  $v['goodsDatas']['sub_describe'];
            $arrArticlePics[1]['image_type'] =  2;//1 主图 2副图
            $arrArticlePics[1]['title'] = '';
            $arrArticlePics[1]['user_id']    =  $user_id;
            $arrArticlePics[1]['article_id'] =  $article_id;
            $arrArticlePics[1]['goods_id']   =   $v['id'];
            $arrArticlePics[1]['product_id']  = $v['goods_id'] ;
            $arrArticlePics[1]['order_by']   =  $strOrderBy;
            $arrArticlePics[1]['updated_at']     =   date("Y-m-d H:i:s");
            $arrArticlePics[1]['update_time'] = strtotime('now');
            //$arrArticlePics[1]['created_at']     =   date("Y-m-d H:i:s");



            $pics = ArticlePics::where('article_id', $article_id)->where('order_by', $strOrderBy)->get();

            if(count($pics)>1){
                $k=0;
                foreach ($pics as $key=>$val){
                    $detail_id = $val->id;
                    DB::table("article_pics")->where('article_id',$article_id)->where('id',$detail_id)->update($arrArticlePics[$k]);
                    $k++;
                }
            }else{
                $arrArticlePics[0]['create_time'] = strtotime('now');
                $arrArticlePics[0]['created_at']     =   date("Y-m-d H:i:s");
                $arrArticlePics[1]['create_time'] = strtotime('now');
                $arrArticlePics[1]['created_at']     =   date("Y-m-d H:i:s");
                $re=DB::table("article_pics")->insert($arrArticlePics);

            }

            DB::table('article_pics')->where("article_id", $article_id)->where('order_by','>',count($goodsArr))->delete();

            $strOrderBy++;
        }
        return;
    }

    //存草稿(调用方法)旧
    function saveArticle1($data){
        $goodsArr=$data['goodsArr'];
        $title=$data['articleTitle'];
        $planTime=$data['planTime'];//定时发布时间
        $article_id=$data['article_id'];//文章id



        if(empty($planTime)){
            $planOnlineTime=time();
        }else{
            $planOnlineTime=strtotime($planTime);
        }
        //用户id
        $user_id=Admin::user()->id;

        $arrArticleData['user_id']          =  $user_id;
        $arrArticleData['article_number']  =  date('YmdHis').rand(1000, 9999);
        $arrArticleData['title']             =  $title;
        $arrArticleData['type']              =  1;   //图集
        $arrArticleData['plan_online_time'] = $planOnlineTime;//定时发布时间
        $arrArticleData['article_type']    = 0;
        $arrArticleData['status']           =  2;   //草稿   C('ARTICLE_STATUS.DRAFT');
        $arrArticleData['create_time']     =   Carbon::now()->timestamp;
        $arrArticleData['update_time']     =   Carbon::now()->timestamp;
        $arrArticleData['updated_at']     =   date("Y-m-d H:i:s");



        if(empty($article_id)){
            $arrArticleData['created_at']     =   date("Y-m-d H:i:s");
            //存文章表，状态为：草稿
            $article_id=DB::table("article")->insertGetId($arrArticleData);
//       var_dump($article_id);exit;
            if(!empty($article_id)){
                //存描述
                $strOrderBy = 1;
                foreach ($goodsArr as $k=>$v){
                    if(!empty($v['goodsDatas']['main_describe'])){

                        $arrArticlePics[0]['image']       =  $v['goodsDatas']['main_pic'];
                        $arrArticlePics[0]['describe']    =  $v['goodsDatas']['main_describe'];
                        $arrArticlePics[0]['image_type'] =  1;//1 主图 2副图
                        $arrArticlePics[0]['title']       =   $v['goodsDatas']['title'];
                        $arrArticlePics[0]['user_id']     =  $user_id;
                        $arrArticlePics[0]['article_id'] =  $article_id;
                        $arrArticlePics[0]['goods_id']    =  $v['id'];
                        $arrArticlePics[0]['product_id']  =  $v['goods_id'] ;
                        $arrArticlePics[0]['order_by']   =  $strOrderBy;
                        $arrArticlePics[0]['updated_at']     =   date("Y-m-d H:i:s");
                        $arrArticlePics[0]['created_at']     =   date("Y-m-d H:i:s");
                    }

                    if(!empty($v['goodsDatas']['sub_describe'])){
                        $arrArticlePics[1]['image']       =   $v['goodsDatas']['sub_pic'];
                        $arrArticlePics[1]['describe']    =  $v['goodsDatas']['sub_describe'];
                        $arrArticlePics[1]['image_type'] =  2;//1 主图 2副图
                        $arrArticlePics[1]['title'] = '';
                        $arrArticlePics[1]['user_id']    =  $user_id;
                        $arrArticlePics[1]['article_id'] =  $article_id;
                        $arrArticlePics[1]['goods_id']   =   $v['id'];
                        $arrArticlePics[1]['product_id']  = $v['goods_id'] ;
                        $arrArticlePics[1]['order_by']   =  $strOrderBy;
                        $arrArticlePics[1]['updated_at']     =   date("Y-m-d H:i:s");
                        $arrArticlePics[1]['created_at']     =   date("Y-m-d H:i:s");
                    }
                    DB::table("article_pics")->insert($arrArticlePics);
                    $strOrderBy++;
                }
            }

        }else{
            DB::table('article')->where("id", $article_id)
                ->update([
                    'title' => "$title",
                    'plan_online_time' => $planOnlineTime,
                    'status' => 2,
                    'updated_at' => date("Y-m-d H:i:s"),
                    'update_time' =>  Carbon::now()->timestamp
                ]);
                $articlePics = ArticlePics::where('article_id', $article_id)->orderBy('order_by', 'asc')->get();

            DB::table('article_pics')->where("article_id", $article_id)
                ->delete();
            //存描述
            $strOrderBy = 1;
            foreach ($goodsArr as $k=>$v){
                if(!empty($v['goodsDatas']['main_describe'])){

                    $arrArticlePics[0]['image']       =  $v['goodsDatas']['main_pic'];
                    $arrArticlePics[0]['describe']    =  $v['goodsDatas']['main_describe'];
                    $arrArticlePics[0]['image_type'] =  1;//1 主图 2副图
                    $arrArticlePics[0]['title']       =   $v['goodsDatas']['title'];
                    $arrArticlePics[0]['user_id']     =  $user_id;
                    $arrArticlePics[0]['article_id'] =  $article_id;
                    $arrArticlePics[0]['goods_id']    =  $v['id'];
                    $arrArticlePics[0]['product_id']  =  $v['goods_id'] ;
                    $arrArticlePics[0]['order_by']   =  $strOrderBy;
                    $arrArticlePics[0]['updated_at']     =   date("Y-m-d H:i:s");
                    $arrArticlePics[0]['created_at']     =   date("Y-m-d H:i:s");
                }

                if(!empty($v['goodsDatas']['sub_describe'])){
                    $arrArticlePics[1]['image']       =   $v['goodsDatas']['sub_pic'];
                    $arrArticlePics[1]['describe']    =  $v['goodsDatas']['sub_describe'];
                    $arrArticlePics[1]['image_type'] =  2;//1 主图 2副图
                    $arrArticlePics[1]['title'] = '';
                    $arrArticlePics[1]['user_id']    =  $user_id;
                    $arrArticlePics[1]['article_id'] =  $article_id;
                    $arrArticlePics[1]['goods_id']   =   $v['id'];
                    $arrArticlePics[1]['product_id']  = $v['goods_id'] ;
                    $arrArticlePics[1]['order_by']   =  $strOrderBy;
                    $arrArticlePics[1]['updated_at']     =   date("Y-m-d H:i:s");
                    $arrArticlePics[1]['created_at']     =   date("Y-m-d H:i:s");
                }


                DB::table("article_pics")->insert($arrArticlePics);
                $strOrderBy++;
            }
        }

        //调用修改文章类型的方法
        CArticle::signContentType($article_id);

        return $article_id;

    }
    //存草稿(调用方法)新
    function saveArticle($data){
        if(!empty($data)){
            $goodsArr=$data['goodsArr'];//产品数组
            $title=$data['articleTitle'];//文章标题
            $planTime=$data['planTime'];//定时发布时间
            $article_id=$data['article_id'];//文章id


            //是否设置定时发布时间
            if(empty($planTime)){
                $planOnlineTime=time();
            }else{
                $planOnlineTime=strtotime($planTime);
            }
            //用户id
            $user_id=Admin::user()->id;

            $arrArticleData['user_id']          =  $user_id;
            $arrArticleData['article_number']  =  date('YmdHis').rand(1000, 9999);
            $arrArticleData['title']             =  $title;
            $arrArticleData['type']              =  1;   //图集
            $arrArticleData['plan_online_time'] = $planOnlineTime;//定时发布时间
            $arrArticleData['article_type']    = 0;
            $arrArticleData['status']           =  2;   //草稿   C('ARTICLE_STATUS.DRAFT');
            $arrArticleData['create_time']     =   Carbon::now()->timestamp;
            $arrArticleData['update_time']     =   Carbon::now()->timestamp;
            $arrArticleData['updated_at']     =   date("Y-m-d H:i:s");


            //存文章表，状态为：草稿
            if(empty($article_id)){
                $arrArticleData['created_at']     =   date("Y-m-d H:i:s");
                //插入文章数据
                $article_id=DB::table("article")->insertGetId($arrArticleData);
                if(!empty($article_id)){
                    $this->insertArticlePics($goodsArr,$article_id,$user_id);
                }
            }else{
                //修改文章数据
                DB::table('article')->where("id", $article_id)
                    ->update([
                        'title' => "$title",
                        'plan_online_time' => $planOnlineTime,
                        'status' => 2,
                        'updated_at' =>   date("Y-m-d H:i:s"),
                        'update_time' =>  Carbon::now()->timestamp
                    ]);
//                $articlePics = ArticlePics::where('article_id', $article_id)->orderBy('order_by', 'asc')->get();

                $this->updateArticlePics($goodsArr,$article_id,$user_id);


            }
        }

        //调用修改文章类型的方法
        CArticle::signContentType($article_id);
        return $article_id;
    }
    //敏感词校验
    public function sensitiveWord(Request $request)
    {
        $type = $request->type;
        $datas= DB::table('article_sensitive_word')->where([
                            ['keywords_type',0],
                            ['type',$type]
                        ])->select('keywords')->get()->toArray();
        foreach ($datas as $k=>$v){
            $data[]=$v->keywords;
        }
//        $datas=DB::select("select keywords from article_sensitive_word where type=$type and keywords_type=0 ");
        return json_encode($data);
    }


    //获取描述
    public function getGoodsDescribeById($strSelectProductId,$type)
    {

        if (empty($strSelectProductId)) {
            return array();
        }
        $strGetUrl ="https://baseinfo.youdnr.com/api/info/getgoodsinfo?";
        // $strGetUrl .= 'goods_ids='.$strSelectProductId;
        $strGetUrl .= 'goods_ids=' .$strSelectProductId.'&fuzzy_des=1&type_level=3&tool_type='.$type.'&des_count=10';
        $arrGoodsData = file_get_contents($strGetUrl);
        $arrData = json_decode($arrGoodsData);
        return !empty($arrData) ? $arrData : array();

    }

    //公共库获取标题
    public function getGoodsTitlesById($strSelectProductId)
    {

        if (empty($strSelectProductId)) {
            return array();
        }
        $strGetUrl = 'http://baseinfo.youdnr.com/api/goods/get_goods_article_title?';
        // $strGetUrl .= 'goods_ids='.$strSelectProductId;
        $strGetUrl .= 'goods_id=' . $strSelectProductId;
        $arrGoodsData = file_get_contents($strGetUrl);
        $arrData = json_decode($arrGoodsData);
        return !empty($arrData) ? $arrData : array();

    }


}