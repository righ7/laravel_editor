<?php

namespace App\Http\Controllers\User;

use App\Application\Home\Models\Recommend\RecommendItem;
use App\Application\TeMai\Models\Article\ArticleRecord;
use App\Application\TeMai\Models\Article\EditVersion;
use App\Application\Temai\Models\Article\SensitiveWords;
use App\Application\TeMai\Models\Article\TemaiAccount;
use App\Application\TeMai\Models\Goods\GoodsShopName;
use App\Application\TeMai\Models\GoodsLibrary\UserTbGroupRecord;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Access\User\SocialLogin;
use App\Models\Access\User\UserCode;
use App\Models\Access\User\UserTokenRecord;
use App\Models\Access\User\UserTripRecord;
use App\Repositories\Frontend\Access\User\UserCodeRepository;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Repositories\Frontend\Access\User\UserTokenRecordRepository;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserApiRequest;
use Illuminate\Support\Facades\Auth;
use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserApiController
 */
class UserApiController extends Controller
{
	/**
	 * @var $userRepository
	 */
	protected $userRepository;
    protected $userCodeRepository;
    protected $tokenRecordRepository;
	/**
	 * 初始化
	 */
	public function __construct()
	{
		//执行父级的初始化，获取通用的参数
		parent::__construct();

	}


    public function UserLogin(Request $request){

        $user_name =!empty($request['user_name'])?$request['user_name']:null;
        $password = !empty($request['password'])?$request['password']:null;
        if(!empty($user_name) && !empty($password)) {

            $user_info = Administrator::where('user_login', $user_name)->first();

            if ($user_info) {

                if(Auth::attempt(['user_login' => $user_name, 'password' => $password])){
                    $user_id = $user_info->id;
                    $error = 0;
                    $msg = '登录成功！';

                } else {
                    $user_id = "";
                    $error = -1;
                    $msg = '密码错误！';
                }

            } else {
                $user_id = "";
                $error = -2;
                $msg = '无该用户名！';
            }
        }
        else{
            $user_id = "";
            $error = -3;
            $msg = '用户名或密码不能为空！';
        }
        $result['user_id'] = $user_id;
        $result['error'] =$error;
        $result['msg'] =$msg;

        return json_encode($result);
    }
}