<?php

namespace App\Http\Controllers\Article;

use App\Admin\Models\Article\ArticleAlbums;

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
class ToutiaoArticleApiController extends Controller
{

	/**
	 * 初始化
	 */
	public function __construct()
	{
		//执行父级的初始化，获取通用的参数
		parent::__construct();

	}


    public function getArticleData(Request $request){

        $user_id =!empty($request['user_id'])?$request['user_id']:null;
        $account_id = !empty($request['account_id'])?$request['account_id']:null;

        DB::beginTransaction();
        try {
            if (!empty($user_id) && !empty($account_id)) {
                $distribute = config('article.platform_article_distribute');

                $article = config('article.article_table');
                $one_data = PlatformArticleDistribute::leftJoin($article, $article . '.id', '=', $distribute . '.article_id')
                    ->where($article . '.user_id', $user_id)
                    ->where($distribute . '.account_id', $account_id)
                    ->where($distribute . '.is_get', 0)
                    ->whereIn($distribute . '.article_type', [6, 7])
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
                    ->first();
                if (empty($one_data)) {
                    $one_data = PlatformArticleDistribute::leftJoin($article, $article . '.id', '=', $distribute . '.article_id')
                        ->where($article . '.user_id', $user_id)
                        ->where($distribute . '.account_id', -1)
                        ->where($distribute . '.is_get', 0)
                        ->whereIn($distribute . '.article_type', [6, 7])
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
                        ->first();

                }

                if (!empty($one_data)) {
                    PlatformArticleDistribute::where('id',$one_data->id)->update(['is_get'=>1,'account_id'=>$account_id,'update_time'=>date('Y-m-d H:i:s')]);
                    DB::commit();

                    $article_type = $one_data->article_type;
                    $article_id = $one_data->article_id;
                    $data = array();
                    switch ($article_type) {
                        case 6: // 图集
                            $data[] = null;
                            break;
                        case 7: // 专辑
                            $albums = ArticleAlbums::where('article_id', $article_id)->orderBy('order_by', 'asc')->get();
                            $arr['id'] = $article_id;
                            $arr['type'] = 0;
                            $arr['article_type'] = 0;
                            $arr['title'] = $one_data->title;
                            $arr['sex'] = '';
                            $arr['issue_type'] = $one_data->issue_type;
                            $arr['content'] = $this->changeAlbumsStruct($albums);
                            $desc = $this->articleIntroduction($one_data->desc);
                            $first_img = $this->articleFirstImg($one_data->face_image);
                            array_unshift($arr['content'], $desc);
                            array_unshift($arr['content'], $first_img);
                            $data[] = $arr;
                            break;
                    }

                    $error = 0;
                    $msg = '';
                } else {
                    $data[] = null;
                    $error = 0;
                    $msg = '暂无要发布的文章';
                }
            } else {
                $error = -1;
                $msg = '用户id或者是账号id为空！';
                $data[] = null;
            }
        }
        catch (Exception $e) {
            // 数据回滚, 当try中的语句抛出异常。
            DB::rollBack();
            // 执行一些提醒操作等等...
            $error = -2;
            $msg = '程序出错啦';
            $data[] = null;
        } finally {
            $result['error'] =$error;
            $result['msg'] =$msg;
            $result['data'] = $data;
            return json_encode($result);
        }
    }

    private function changeAlbumsStruct($albums)
    {
        $lists = [];

        foreach($albums as $album){
            $arr['detail_type'] = $album->detail_type ?? '';
            $arr['goods_id'] = $album->product_id ?? '';
            $arr['goods_link'] = $album->goods_url ?? '';
            $arr['goods_name'] = $album->title ?? '';
            $arr['main_description'] = $album->describe ?? '';
            $arr['main_picture'] = $this->translateImageUrl($album->image ?? '');
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
        $arr['goods_id'] = '';
        $arr['goods_link'] = '';
        $arr['goods_name'] = '';
        $arr['main_description'] = '';
        $arr['main_picture'] = $content ?? '';
        return $arr;
    }
}