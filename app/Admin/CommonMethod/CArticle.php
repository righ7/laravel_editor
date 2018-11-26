<?php
/**
 * 文章公用方法
 * Done is better that Perfect.
 */

namespace App\Admin\CommonMethod;

use App\Admin\Models\Article\Article;
use App\Admin\Models\Article\ArticleSensitiveWord;
use App\Admin\Models\Auth\User;
use App\Admin\Models\Platform\PlatformAccount;
use App\Admin\Models\Platform\PlatformArticleDistribute;
use App\Admin\Models\Platform\PlatformPermission;
use Encore\Admin\Facades\Admin;
use Carbon\Carbon;

class CArticle
{
    /**
     * 文章校检 [ 通过查询数据库中数据进行校检 ]
     * @param $article_id
     * @return string
     */
    public static function dataCheck($article_id): string
    {
        /**
         * 校检内容为
         * 文章标题 【中文字数 > 8】【敏感词】
         * 导语 【敏感词】
         * 特卖/头条图集 【图集产品数，根据表product_id判断 >= 10  <= 20】【产品标题敏感词】【产品内容敏感词】
         * 特卖/头条专辑 【导语 + 描述字数 > 500字】【产品标题敏感词】【产品内容敏感词】
         */
        $article = Article::where('id', $article_id)->first();

        // 标题中文字数校检
        preg_match_all("/[\x{4e00}-\x{9fa5}]+/u", $article->title, $arr);
        $titleChineseLength = 0;
        foreach ($arr[0] as $k => $v) {
            $titleChineseLength += mb_strlen($v);
        }
        if ($titleChineseLength < 8)
            return '文章标题至少需要8个中文！';

        $sensitiveWord = ArticleSensitiveWord::get();
        $titleSensitiveWords = $sensitiveWord->where('keywords_type', 0)->where('type', 1)->pluck('keywords');
        $ContentSensitiveWords = $sensitiveWord->where('keywords_type', 0)->where('type', 2)->pluck('keywords');

        // 标题/导语敏感词校检
        foreach ($titleSensitiveWords as $titleSensitiveWord) {
            if (strstr($article->title, $titleSensitiveWord))
                return "标题发现敏感词『{$titleSensitiveWord}』";
            if (strstr($article->desc, $titleSensitiveWord))
                return "导语发现敏感词『{$titleSensitiveWord}』";
        }

        switch ($article->type) {
            case 1: // 特卖图集
            case 6: // 头条图集
                $pics = $article->pics()->get();

                // 产品数量校检
                $count = $pics->groupBy('product_id')->count();
                if ($count < 10)
                    return '图集产品数量必须大于或等于 10 个';
                if ($count > 20)
                    return '图集产品数量不能大于 20 个';

                // 敏感词校检
                $titles = $pics->where('title', '!=', '')->pluck('title');
                $describes = $pics->pluck('describe');
                foreach ($ContentSensitiveWords as $contentSensitiveWord) {
                    foreach ($titles as $title) {
                        if (strstr($title, $contentSensitiveWord))
                            return "产品标题包含敏感词『{$contentSensitiveWord}』";
                    }
                    foreach ($describes as $describe) {
                        if (strstr($describe, $contentSensitiveWord))
                            return "产品内容包含敏感词『{$contentSensitiveWord}』";
                    }
                }
                break;
            case 2: // 特卖专辑
            case 7: // 头条专辑
                $albums = $article->albums()->get();

                // 专辑字数校检
                $contentLength = !empty($article->desc) ? mb_strlen($article->desc) : 0;
                foreach ($albums as $album) {
                    $contentLength += !empty($album->describe) ? mb_strlen($album->describe) : 0;
                }
                if ($contentLength < 500)
                    return '专辑字数必须大于或等于500字';

                // 敏感词校检
                $titles = $albums->where('title', '!=', '')->pluck('title');
                $describes = $albums->pluck('describe');
                foreach ($ContentSensitiveWords as $contentSensitiveWord) {
                    foreach ($titles as $title) {
                        if (strstr($title, $contentSensitiveWord))
                            return "产品标题包含敏感词『{$contentSensitiveWord}』";
                    }
                    foreach ($describes as $describe) {
                        if (strstr($describe, $contentSensitiveWord))
                            return "产品内容包含敏感词『{$contentSensitiveWord}』";
                    }
                }
                break;
        }
        return 'true';
    }

    /**
     * 文章类型标记 [ 通过请求公共库的数据进行进行判断更改 ]
     * @param $article_id
     * @return string
     */
    public static function signContentType($article_id): string
    {
        $article = Article::findOrFail($article_id);
        $baseUrl = 'http://baseinfo.youdnr.com/api/goods/get_goods_shop_type';

        $articleContent = [];
        switch ($article->type) {
            case 1: // 特卖图集
                $articleContent = $article->pics();
                break;
            case 2: // 特卖专辑
                $articleContent = $article->albums();
                break;
        }
        if(empty($articleContent))
            return '不支持头条图集/专辑';

        $articleContent = $articleContent
            ->where('product_id', '!=', '')
            ->where('product_id', '!=', 0)
            ->whereNotNull('product_id')
            ->select('product_id', 'order_by')
            ->orderBy('order_by')
            ->get();

        $articleContent = $articleContent->sortBy('order_by')->pluck('order_by', 'product_id')->all();
        $product_ids = array_keys($articleContent);
        $wgetData = json_decode(self::wget($baseUrl . '?data=' . json_encode($product_ids)), true);

        // 0 放心购 1 小店
        if (!empty($wgetData)) {
            if ($wgetData['code'] != 0)
                return '远程数据请求异常，请联系管理员';

            $data = $wgetData['data'];

            // 校检是否精选文章
            $goods3 = array_keys(array_slice($articleContent, 0, 3, true)); // 前三个商品ID
            $tem = collect($data)->whereIn('product_id', $goods3);
            if ($tem->count() < 3) {
                return '远程请求商品可能被下架或隐藏';
            }
            if ($tem->where('is_recommend', 1)->count() >= 3) {
                Article::where('id', $article_id)->update(['article_content_type' => 1]);
                return 'true';
            }

            // 判断是否是小店文章
            $tem = collect($data)->where('shop_type', 0)->count();
            if ($tem < 1) {
                Article::where('id', $article_id)->update(['article_content_type' => 2]);
                return 'true';
            }

            // 默认是放心购文章
            Article::where('id', $article_id)->update(['article_content_type' => 3]);
        }
        return 'true';
    }

    /**
     * 免审核 [查询对应的数据，更改文章状态及是否写入分发表]
     * @param $article_id
     * @return string
     */
    public static function avoidAudit($article_id)
    {
        $user = Article::where('id',$article_id)->first()->user()->first();

        if ($user['is_avoid_audit'] == 1) { // 判断用户是否免审核
            Article::where('id',$article_id)->update(['status' => 1, 'update_time' => strtotime('now')]);

            if ($user['direct_issue'] == 1) { // 判断是否直接发布
                $accounts = PlatformPermission::leftJoin('platform_account', 'platform_permission.account_id', '=', 'platform_account.id')
                    ->where('platform_permission.user_id', $user->id)
                    ->when(true, function ($query) use ($article_id){
                        $type = Article::where('id',$article_id)->value('type');
                        switch ($type){
                            case 1:
                            case 6:
                                $query->where('res_pics_num', '>', 0);
                                break;
                            case 2:
                            case 7:
                                $query->where('res_albums_num', '>', 0);
                                break;
                        }
                    })
                    ->select('platform_permission.*')
                    ->get();
                $article = Article::where('id', $article_id)->first();

                if (!empty(count($accounts))) { // 有分配账户
                    foreach ($accounts as $k => $account) { // 数据转换存入平台分发表
                        $list[$k]['article_id'] = $article_id;
                        $list[$k]['account_id'] = $account['shop_id'] ?? -1;
                        $list[$k]['platform_id'] = $account['platform_id'];
                        $list[$k]['article_type'] = $article['article_type'];
                        $list[$k]['status'] = 0;
                        $list[$k]['is_get'] = 0;
                        $list[$k]['issue_type'] = $user['direct_draft'] == 1 ? 0 : 1;
                        $list[$k]['fail_cause'] = '';
                        $list[$k]['issue_time'] = !empty($article['plan_online_time']) ? date('Y-m-d H:i:s', $article['plan_online_time']) : date('Y-m-d H:i:s');
                        $list[$k]['create_time'] = date('Y-m-d H:i:s');
                        $list[$k]['update_time'] = date('Y-m-d H:i:s');
                    }

                    if (!empty($list)) { // 随机取一个账户分配
                        $count = PlatformArticleDistribute::where('article_id', $article_id)->count();
                        if (!$count) {
                            $z = rand(0, count($list) - 1);
                            PlatformArticleDistribute::insert($list[$z]);
                        }
                    }
                } else { // 用户无对应的账户
                    $temaiAccounts = PlatformAccount::whereNotNull('shop_id')->where('status',1)
                        ->where('is_start',1)
                        ->where('platform', 4)
                        ->count();

                    if (!empty($temaiAccounts)) { //判断是否有开启的特卖号
                        $list['article_id'] = $article_id;
                        $list['account_id'] = -1;
                        $list['platform_id'] = 4;
                        $list['article_type'] = $article['article_type'];
                        $list['status'] = 0;
                        $list['is_get'] = 0;
                        $list['issue_type'] = $user['direct_draft'] == 1 ? 0 : 1;
                        $list['fail_cause'] = '';
                        $list['issue_time'] = !empty($article['plan_online_time']) ? date('Y-m-d H:i:s', $article['plan_online_time']) : date('Y-m-d H:i:s');
                        $list['create_time'] = date('Y-m-d H:i:s');
                        $list['update_time'] = date('Y-m-d H:i:s');

                        if (!empty($list)) {
                            $count = PlatformArticleDistribute::where('article_id',$article_id)->count();
                            if (!$count) {
                                PlatformArticleDistribute::insert($list);
                            }
                        }
                    }
                }
            }
        }
        return 'true';
    }

    /**
     * 封装 get 请求方法
     * @param $url
     * @return string
     */
    private static function wget($url): string
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
}