<?php

namespace App\Http\Controllers\DingDingMessage;

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
class DingdingmessageApiController extends Controller
{

	/**
	 * 初始化
	 */
	public function __construct()
	{
		//执行父级的初始化，获取通用的参数
		parent::__construct();

	}


    public function sendMessage(){

        $webhook = "https://oapi.dingtalk.com/robot/send?access_token=98dd2674821c72c1ea0ee1153bf38051bc7f7171b70ed714d8f611bc18ba61af";
        $message="我就是我, 是不一样的烟火";
        $data = array (
            'msgtype' => 'text',
            'text' => array (
                'content' => $message
            ),
            "at"=>array(
                "atMobiles"=>[
                    "18060781201",
                    "13075914435"
                ],
                "isAtAll"=>false
            )
        );
        $data_string = json_encode($data);

        $result = $this->request_by_curl($webhook, $data_string);
        return $result;
    }

    function request_by_curl($remote_server, $post_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 线下环境不用开启curl证书验证, 未调通情况可尝试添加该代码
         curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
         curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

}