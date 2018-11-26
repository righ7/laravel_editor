<?php

namespace App\Admin\Controllers\Api;

use App\Admin\Models\Article\Article;
use App\Admin\Models\Auth\User;
use App\Admin\Models\Platform\PlatformArticleDistribute;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Illuminate\Support\Facades\Hash;

class ArticleIssueController extends Controller
{
    /**
     * 登录接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $result = [];

            $username = $request->username ?? '';

            $password = DB::table('cmf_users')->where('user_login', $username)->value('password');

            $authCheck = Hash::check($request->password ?? '', $password);

            if (!$authCheck)
                throw new \Exception('用户名或密码错误，请重新输入');

            $result = $this->getUserAccountData($username);

        } catch (\Exception $e) {
            $result['code'] = 1;
            $result['errMsg'] = $e->getMessage();
        } finallY {
            return response()->json($result);
        }
    }

    /**
     * 会写发文结果
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function writeDistributeStatus(Request $request)
    {
        try {
            $account_id = $request->account_id ?? '';
            $article_id = $request->article_id ?? 0;
            $status = $request->status ?? -1;
            $draft_id = $request->draft_id ?? '';
            $fail_cause = $request->fail_cause ?? '';
            $platform_article_status = $request->platform_article_status ?? -1;

            $result['code'] = 0;
            $result['errMsg'] = '';
            $result['msg'] = '';

            if (empty($account_id))
                throw new \Exception('「account_id」不能为空!');
            if (empty($article_id))
                throw new \Exception('「article_id」不能为空!');
            if ($status == -1)
                throw new \Exception('「status」不能为空!');

            $update['status'] = $status;
            $update['draft_id'] = $draft_id;
            $update['platform_article_status'] = $platform_article_status;
            $update['update_time'] = date('Y-m-d H:m:s');
            $update['fail_cause'] = $fail_cause ?? '';

            $sign = PlatformArticleDistribute::where('account_id', $account_id)
                ->where('article_id', $article_id)
                ->update($update);

            // 发布成功、自动提交标题
            if ($status == 1) {
                $user_id = Article::where('id', $article_id)->value('user_id');
                if (!empty($user_id))
                    $temai_uid = User::where('id', $user_id)->value('temai_uid');
                if (!empty($temai_uid)) {
                    $this->getTitle($temai_uid, $article_id);
                }
            }

            $username = User::where('id',$user_id)->value('user_login');
            $result = $this->getUserAccountData($username);

            if (!empty($sign)) {
                $result['msg'] = '状态更新成功！';
                $result['status'] = $status;
            }
        } catch (\Exception $e) {
            $result['code'] = 1;
            $result['errMsg'] = $e->getMessage();
        } finally {
            return response()->json($result);
        }
    }

    /**
     * 返回整理后对应的数据
     * @param $username
     * @return array
     */
    private function getUserAccountData($username)
    {
        $result = [
            'code' => 0,
            'errMsg' => '',
            'accounts' => [],
            'articleType' => [],
        ];

        // 查询出账户表主键数组
        $account_ids = DB::table(DB::raw('cmf_users as a'))
            ->rightJoin(DB::raw('platform_permission as b'), 'a.id', '=', 'b.user_id')
            ->where('a.user_login', $username)
            ->pluck('b.account_id');

        // 平台名对照数组
        $platform = DB::table('platform')->pluck('platform_name', 'id');

        // 文章类型对照数组
        $articleTransformContract = config('table_column_transform.editor.article') ?? [];
        $result['articleType'] = $articleTransformContract['type'] ?? [];
        $result['articleContentType'] = $articleTransformContract['article_content_type'] ?? [];

        if ($account_ids) {
            $accounts = DB::table('platform_account')
                ->whereIn('id', $account_ids)
                ->select('platform', 'shop_id', 'password_account')
                ->get();
            $shop_ids = $accounts->pluck('shop_id') ?? [];
            $distribute = DB::table(DB::raw('platform_article_distribute as a'))
                ->leftJoin(DB::raw('article as b'), 'a.article_id', '=', 'b.id')
                ->whereIn('a.account_id', $shop_ids)
                ->where('a.is_get', 0)
                ->where('a.status', 0)
                ->select('a.id', 'a.article_id', 'a.account_id', 'a.article_type', 'b.article_content_type')
                ->get();
            // 增加平台名、文章类型对应数据总量
            foreach ($accounts as $account) {
                $account->platform_name = $platform[$account->platform] ?? '未知';
                $arr = [];
                foreach ($result['articleContentType'] as $x => $y) {
                    $amount = 0;
                    foreach ($result['articleType'] as $k => $v) {
                        $arr[$x][$k] = $distribute->where('account_id', $account->shop_id)
                            ->where('article_content_type', $x)
                            ->where('article_type', $k)->count();
                        $amount += $arr[$x][$k];
                    }
                    $arr[$x]['amount'] = $amount;
                }
                $account->article_amount = $arr;
            }
            $result['accounts'] = $accounts;
        }
        return $result;
    }

    /**
     * 自动提交标题
     * @param $temai_uid
     * @param $article_id
     */
    public function getTitle($temai_uid, $article_id)
    {
        $title = Article::where('id', $article_id)->value('title');
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
            Article::where('id', $article_id)->update(['is_exist' => 2]);
        } elseif ($data['status'] == 0 && $data['is_exist'] == 2) {
            Article::where('id', $article_id)->update(['is_exist' => 2]);
        } elseif ($data['status'] == 0 && $data['is_exist'] == 1) {
            Article::where('id', $article_id)->update(['is_exist' => 1, 'exist_msg' => $data['msg']]);
        }
    }

    /**
     * 封装 post 请求
     * @param $url
     * @param $post_data
     * @return bool|string
     */
    private function send_post($url, $post_data)
    {
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
