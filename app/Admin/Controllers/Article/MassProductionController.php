<?php

namespace App\Admin\Controllers\Article;

use App\Admin\Models\Article\ArticleTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;
use Carbon\Carbon;

class MassProductionController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        Admin::disablePjax();
        return $content
            ->header('批量生成')
            ->description('批量生成')
            ->body(view('article.mass_production'));
    }

    // 从 thinkphp 3.2 迁移过来， 没有时间重构，希望你改的开心...

    // 不清楚什么作用...
    public function omissionGoods()
    {
        try{
            $result['code'] = 0;
            $result['err_msg'] = '';
            $url=$_GET['url'];
            $arr = parse_url($url);

            $arr_query = $this->convertUrlQuery($arr['query']);

            $goods= DB::table('omission_goods');
            if ($arr['host']=='haohuo.snssdk.com' || $arr['host']=='haohuo.jinritemai.com'){
                if ($arr_query['id']){
                    $search = $goods->where('sku_id', $arr_query['id'])->first();
                    if (!$search){
                        $data['sku_id'] = $arr_query['id'];
                        $data['status'] = 0;
                        $data['type'] = 0;
                        $data['feedback_time'] = date('Y-m-d H:i:s',time());
                        $goods->insert($data);
                    }else{
                        $data['status']=0;
                        $goods->where('sku_id', $arr_query['id'])->update($data);
                    }
                }else{
                    $result['code'] = 1;
                    $result['err_msg'] = '请输入正确的放心购商品链接';
                }
            }else{
                $search = $goods->where("shop_name", $url)->first();
                if (!$search){
                    $data['shop_name'] = $url;
                    $data['status'] = 0;
                    $data['type'] = 1;
                    $data['feedback_time'] = date('Y-m-d H:i:s',time());
                    $goods->insert($data);
                }else{
                    $data['status']=0;
                    $goods->where("shop_name", $url)->update($data);
                }
            }

        }catch(\Exception $e){
            $result['code'] = 1;
            $result['err_msg'] = $e->getMessage();
        }finally{
            return response()->json($result);
        }
    }

    // 获取模板
    public function getTemplate()
    {
        return response()->json(ArticleTemplate::where('status','1')->get());
    }

    // 增删用户收藏的商品
    public function putch(Request $request)
    {
        $goods_id = $request->goods_id;
        $user_id = Admin::user()->id;
        $type = $request->type;
        $now = Carbon::now()->toDateTimeString();
        $userFavorite = DB::table('user_favorite_goods');
        switch ($type) {
            case 1: // 增加
                $data = [];
                foreach($goods_id as $k => $v){
                    $data[$k]['user_id']     = $user_id;
                    $data[$k]['goods_id']    = $v;
                    $data[$k]['create_time'] = $now;
                    $data[$k]['update_time'] = $now;
                }
                $userFavorite->whereIn('goods_id',$goods_id)->delete();
                $userFavorite->insert($data);
                break;
            case 2: // 删除
                $userFavorite->where("user_id", $user_id)->where('goods_id', $goods_id)->delete();
                break;
            case 3: // 删除全部
                $userFavorite->where("user_id", $user_id)->delete();
                break;
        }
        echo '操作成功';
    }

    // 获取用户收藏商品
    public function getFavoriteGoods()
    {
        $user_id = Admin::user()->id;
        $goods_id_arr = DB::table('user_favorite_goods')->where("user_id", $user_id)->pluck('goods_id');
        $goods_id_arr = json_encode($goods_id_arr);
        $goods_id_arr = str_replace('[','',$goods_id_arr);
        $goods_id_arr = str_replace(']','',$goods_id_arr);
        $goods_id_arr = str_replace('"','',$goods_id_arr);
        $BASE_URL2 = 'https://baseinfo.youdnr.com/api/goods/get_goods_data_generate_article?goods_id_arr='; // TODO 域名加入到配置文件
        $data = json_decode($this->curl($BASE_URL2.$goods_id_arr),true)['data'];
        return response()->json($data);
    }

    // 生成文章
    public function produce(Request $request)
    {
        set_time_limit(200);
        $article_amount = $request->article_amount;
        $article_content_goods_amount = empty($request->article_content_goods_amount) ? 12 : $request->article_content_goods_amount;
        $article_is_recommend = $request->article_is_recommend;
        $article_type = $request->article_type ?? 0;
        $article_type = $article_type == 0 ? 0 : 1;

        $user_id = Admin::user()->id;
        $goods_id_arr = DB::table('user_favorite_goods')->where("user_id", $user_id)->pluck('goods_id');

        $BASE_URL1 = 'https://baseinfo.youdnr.com/api/info/getgoodsinfo?goods_ids='; // TODO 域名加入到配置文件
        $BASE_URL2 = 'https://baseinfo.youdnr.com/api/goods/get_goods_data_generate_article?goods_id_arr='; // TODO 域名加入到配置文件

        $goods_id_arr = json_encode($goods_id_arr);
        $goods_id_arr = str_replace('[','',$goods_id_arr);
        $goods_id_arr = str_replace(']','',$goods_id_arr);
        $goods_id_arr = str_replace('"','',$goods_id_arr);

        $data1 = $this->curl($BASE_URL1 . $goods_id_arr . '&fuzzy_des=1&type_level=2&tool_type='.$article_type); // tool_type 图集 0， 专辑1
        $list = json_decode($data1, true)['data'];

        $data2 = $this->curl($BASE_URL2.$goods_id_arr);
        $list2 = json_decode($data2,true)['data']; // 商品详细数据

        // 判断推荐商品数是否够 3 个
        $is_recommend_amount = 0;
        foreach($list2 as $recommend){
            if($recommend['is_recommend'] == 1){
                $is_recommend_amount++;
            }
        }
        if($article_is_recommend == 'true' && $is_recommend_amount < 3) {
            echo '推荐商品不足三个！';
            exit();
        }

        // 删除商品前两个图片、随机后三个图片
        foreach($list as $m => $n){

            if(count($list[$m]['img']) >= 5){
                $s1 = rand(2,4);
                $s2 = rand(2,4);
                while($s1 == $s2){
                    $s2 = rand(2,4);
                }
                $img = [];
                $img[] = $list[$m]['img'][$s1];
                $img[] = $list[$m]['img'][$s2];
            }else{
                $len = count($list[$m]['img']);
                $img[] = $list[$m]['img'][$len-1] ?? NULL;
                $img[] = $list[$m]['img'][$len-2] ?? NULL;
            }
            $list[$m]['img'] = $img;
        }

        // 清除包含敏感词的句子
        $words = DB::table('article_sensitive_word')->where("type",2)->where('keywords', '!=', '')->pluck('keywords');
        foreach($list as $k => $v){
            foreach($words as $word){
                if(strstr($v['main_description'],$word)){
                    $blocks = explode('，',$v['main_description']);
                    foreach($blocks as $x => $block){
                        if(strstr($block,$word)){
                            unset($blocks[$x]);
                        }
                    }
                    $list[$k]['main_description'] = implode('，',$blocks);
                }
                if(strstr($v['vice_description'],$word)){
                    $blocks = explode('，',$v['vice_description']);
                    foreach($blocks as $y => $block){
                        if(strstr($block,$word)){
                            unset($blocks[$y]);
                        }
                    }
                    $list[$k]['vice_description'] = implode('，',$blocks);
                }
            }
        }

        // 合并两个 list list2
        foreach($list as $x => $y){
            foreach($list2 as $c => $d){
                if($y['goods_id'] == $d['product_id']){
                    $list[$x]['goods_detail'] = $d;
                }
            }
        }

        // 剔除没有描述的商品
        $emptyDescriptionGoodsAmount = 0;
        $Configs=DB::table('configs')->where('id',0)->first();
        if ($Configs->use_describe=='1'){
            foreach ($list as $k => $v) {
                if (empty($v['main_description']) || empty($v['vice_description'])) {
                    unset($list[$k]);
                    $emptyDescriptionGoodsAmount++;
                }
            }
        }
        //剔除null
        foreach ($list as $k => $v) {
            if (strstr($v['vice_description'],"null")) {
                $list[$k]['vice_description']='';
            }
            if (strstr($v['main_description'],"null")) {
                $list[$k]['main_description']='';
            }
        }
        $article_content_goods_amount = $article_content_goods_amount - 3;
        if (count($list) < ($article_content_goods_amount + 3)) {
            $article_content_goods_amount = count($list) - 3;
        }

        // 拼合处理
        if($article_is_recommend == 'true'){ // 推荐商品
            if ($article_amount <= ceil(count($list) / 3)) { // 没有超出推荐篇数
                $result = $this->getGoodsOrderRecommend($list, $article_amount, $article_content_goods_amount);
            } else { // 超出推荐篇数
                $result = $this->getGoodsOrderRecommend($list, ceil(count($list) / 3), $article_content_goods_amount);
                $remanning = $article_amount - ceil(count($list) / 3);
                $result_r = $this->getGoodsOrderRecommend($list, $remanning, $article_content_goods_amount);
                foreach ($result_r as $k => $v) {
                    array_push($result, array_shift($result_r));
                }
            }
        }else{
            if ($article_amount <= ceil(count($list) / 3)) { // 没有超出推荐篇数
                $result = $this->getGoodsOrderASC($list, $article_amount, $article_content_goods_amount);
            } else { // 超出推荐篇数
                $result = $this->getGoodsOrderASC($list, ceil(count($list) / 3), $article_content_goods_amount);
                $remanning = $article_amount - ceil(count($list) / 3);
                $result_r = $this->getGoodsOrderASC($list, $remanning, $article_content_goods_amount);
                foreach ($result_r as $k => $v) {
                    array_push($result, array_shift($result_r));
                }
            }
        }

        $data = [];
        foreach($result as $item => $value){
            $id = $item + 1;
            $data[$item]['id'] = $id;
            $data[$item]['title'] = Admin::user()->id.' - '.date('Y-m-d H:i:s');
            $data[$item]['goods_amount'] = count($value);
            $data[$item]['goods'] = $value;
            $data[$item]['empty_description_goods_amount'] = $emptyDescriptionGoodsAmount;
        }

        exit(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    // 存为图集
    public function saveImgCollection()
    {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body, true);
        $data = $data['params']['data'];
        $now = strtotime('now');

        foreach($data as $item){
            $article = $this->returnArticleArr();
            $article['title'] = $item['title']; // article 表数据
            $article_id = DB::table('article')->insertGetId($article);
            $pics = [];
            foreach($item['goods'] as $k => $v){
                $order = $k + 1;
                $arr = [];
                $arr['user_id'] = Admin::user()->id;
                $arr['article_id'] = $article_id;
                $arr['goods_id'] = $v['goods_detail']['id'];
                $arr['product_id'] = $v['goods_detail']['product_id'];
                $arr['title'] = $v['goods_detail']['name'];
                $arr['price'] = 0;
                $arr['image'] = $v['img'][0];
                $arr['image_type'] = 1;
                $arr['describe'] = $v['main_description'] ?? '';
                $arr['order_by'] = $order;
                $arr['price_label'] = 0;
                $arr['create_time'] = $now;
                $arr['update_time'] = $now;
                $pics[] = $arr;

                $arr = [];
                $arr['user_id'] = Admin::user()->id;
                $arr['article_id'] = $article_id;
                $arr['goods_id'] = $v['goods_detail']['id'];
                $arr['product_id'] = $v['goods_detail']['product_id'];
                $arr['title'] = '';
                $arr['price'] = 0;
                $arr['image'] = $v['img'][1];
                $arr['image_type'] = 2;
                $arr['describe'] = $v['vice_description'] ?? '';
                $arr['order_by'] = $order;
                $arr['price_label'] = 0;
                $arr['create_time'] = $now;
                $arr['update_time'] = $now;
                $pics[] = $arr;
            }
            DB::table('article_pics')->insert($pics);
        }

        return '操作成功';
    }

    // 存为专辑 [希望你看的懂]
    public function saveAlbum()
    {
        $request_body = file_get_contents('php://input');
        $input = json_decode($request_body, true);
        $data = $input['params']['data'];
        $template_id = $input['params']['template'];

        $template = ArticleTemplate::findOrFail($template_id);

        $templates = explode(',',$template->template);

        /**
         * 提取 p 后面最大的数字，数字多大则弹出多少个商品出来处理，不够则舍弃
         */
        $max_number = 0;
        foreach($templates as $item){
            $tem = str_split(strstr($item,'p'))[1];
            if($tem > $max_number) $max_number = $tem;
        }
        foreach($data as $item){ // 外层循环多个文章
            $article = $this->returnArticleArr();
            $article['title'] = $item['title']; // article 表数据
            $article['type'] = 2;
            $article['desc'] = '';
            $article_id = DB::table('article')->insertGetId($article);

            $order_by = 0;
            $insert_data = [];
            $while_index = 0; // 这个变量只是用来判断第一次不添加分割线...
            while(count($item['goods']) > 0){ // >= $max_number 不足一个模板将舍弃

                // 每次开始前，添加分割线
                if ($while_index != 0) {
                    $arr = $this->returnArticleAlbumArr();
                    $arr['article_id'] = $article_id;
                    $arr['order_by'] = $order_by;
                    $arr['product_type'] = 2;
                    $arr['create_time'] = time();
                    $arr['update_time'] = time();
                    $arr['image'] = 'http://p3a.pstatp.com/large/1f7700011f8c20db3b29';
                    $arr['detail_type'] = 5;
                    array_push($insert_data, $arr);
                }
                $while_index++;

                $product = array_slice($item['goods'],0,$max_number);
                $item['goods'] = array_slice($item['goods'], $max_number);
                foreach($templates as  $t){
                    $p_num = str_split(strstr($t,'p'))[1] - 1;

                    // 没有定义进入下一个循环
                    if(!isset($product[$p_num]['goods_detail'])) continue;

                    $order_by++;

                    $arr = $this->returnArticleAlbumArr();
                    $arr['article_id'] = $article_id;
                    $arr['order_by'] = $order_by;
                    $arr['product_type'] = 2;
                    $arr['product_id'] = $product[$p_num]['goods_detail']['product_id'];
                    $arr['create_time'] = time();
                    $arr['update_time'] = time();

                    if(strstr($t, 't')){ // 图片
                        $arr['detail_type'] = 2;
                        // 取主图
                        if((int)str_split(strstr($t,'t'))[1] == 1) $arr['image'] = $product[$p_num]['img'][0];
                        // 取副图
                        if((int)str_split(strstr($t,'t'))[1] == 2) $arr['image'] = $product[$p_num]['img'][1];
                    }

                    if(strstr($t, 'm')){ // 描述
                        $arr['detail_type'] = 1;
                        // 取主描述
                        if((int)str_split(strstr($t,'m'))[1] == 1) $arr['describe'] = $product[$p_num]['main_description'];
                        // 取副描述
                        if((int)str_split(strstr($t,'m'))[1] == 2) $arr['describe'] = $product[$p_num]['vice_description'];
                    }

                    if(strstr($t, 'car')){ // 产品卡
                        $arr['detail_type'] = 4;
                        $arr['image'] = $product[$p_num]['goods_detail']['img'] ?? '';
                        $arr['goods_id'] = $product[$p_num]['goods_detail']['id'];
                        $arr['product_id'] = $product[$p_num]['goods_detail']['product_id'];
                        $arr['price'] = $product[$p_num]['goods_detail']['discount_price'] / 100;
                        $arr['title'] = $product[$p_num]['goods_detail']['name'];
                    }
                    array_push($insert_data, $arr);
                }
            }
            DB::table('article_albums')->insert($insert_data);
        }
        return '操作成功';
    }

    private function returnArticleArr()
    {
        $article['user_id'] = Admin::user()->id;
        $article['article_number'] = date('YmdHis').rand(1000, 9999);;
        $article['title'] = 'AAAAA';
        $article['type'] = 1;
        $article['reading_count'] = 0;
        $article['comments_count'] = 0;
        $article['plan_online_time'] = strtotime('now');
        $article['publish_time'] = 0;
        $article['article_type'] = 1;
        $article['create_time'] = strtotime('now');
        $article['update_time'] = strtotime('now');
        $article['status'] = 2;
        return $article;
    }

    private function returnArticleAlbumArr() {
        $arr['user_id'] = Admin::user()->id;
        $arr['article_id'] = '';
        $arr['goods_id'] = '';
        $arr['product_id'] = '';
        $arr['title'] = '';
        $arr['price'] = 0;
        $arr['image'] = '';
        $arr['describe'] = '';
        $arr['order_by'] = '';
        $arr['create_time'] = '';
        $arr['update_time'] = '';
        return $arr;
    }

    // 文章商品排序规则
    private function getGoodsOrderASC($list, $article_amount, $article_content_goods_amount)
    {
        $result = [];
        for ($i = 0; $i < $article_amount; $i++) {
            $item = array_slice($list, 0, 3);
            $use_list = $item;
            foreach ($item as $m) {
                array_shift($list);
            }
            $random_arr = $list;
            shuffle($random_arr);
            for ($z = 0; $z < $article_content_goods_amount; $z++) {
                array_push($item, $random_arr[$z]);
            }
            unset($random_arr);
            foreach ($use_list as $x => $y) {
                array_push($list, array_shift($use_list));
            }
            $result[] = $item;
        }
        return $result;
    }

    // 根据推荐商品，排序
    private function getGoodsOrderRecommend($list,$article_amount,$article_content_goods_amount)
    {
        $result = [];
        $goods_recommend = [];
        // 提取出推荐商品
        foreach($list as $a => $recommend){
            if($recommend['goods_detail']['is_recommend'] == 1){
                array_push($goods_recommend, $list[$a]);
                unset($list[$a]);
            }
        }

        $list_clone = $list;

        for ($i = 0; $i < $article_amount; $i++) {
            $list = $list_clone;

            shuffle($goods_recommend);

            $residue_array = array_slice($goods_recommend, 3);
            foreach ($residue_array as $b => $c){
                array_push($list,$residue_array[$b]);
            }

            shuffle($list);

            $item = array_slice($goods_recommend, 0, 3); // 取推荐商品前 3 个

            for ($z = 0; $z < $article_content_goods_amount; $z++) {
                array_push($item, $list[$z]);
            }
            $result[] = $item;
        }
        return $result;
    }

    // 封装请求公共库描述
    private function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    // 转换URL参数
    public function convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }
}
