<?php

namespace App\Http\Controllers;

use App\Helpers\FunctionsHelper;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected $app_version;        //手机APP版本号
    protected $user_token;        //当前登录用户id，字符串，来自用户登录时提供的标识，未登录时为空
    protected $phone_type;        //手机系统类型ios/android
    protected $mf_identification;    //机器码，无论删除APP还是重启手机都不改变的唯一标识
    protected $mf_token;            //包名MD5，取当前时间戳（分段截取3.3.4），分别放入MD5字符串未插入前的3位后,15之后,最后3位之前,按长度当下标值

    /**
     * 初始化
     */

    public function __construct()
    {
        $this->app_version = $this->GetParamsValue('appversion');
        $this->user_token = $this->GetParamsValue('usertoken');
        $this->phone_type = $this->GetParamsValue('phonetype');
        $this->mf_identification = $this->GetParamsValue('mfidentification');
        $this->mf_token = $this->GetParamsValue('mftoken');
    }

    /***
     * 通过laravel验证规则进行验证
     * @param $request
     * @param $rules
     * @return boolean 返回是否通过验证
     */
    public static function Validator($request, $rules)
    {
        return FunctionsHelper::Validator($request, $rules);
    }

    /**
     * 将UNICODE编码后的内容进行解码
     * @param string $str
     * @return string 中文内容
     */

    function unicode2utf8($str)
    {
        return FunctionsHelper::unicode2utf8($str);
    }

    function unicodeDecode($data)
    {
        return FunctionsHelper::unicodeDecode($data);
    }

    /**
     * 获取IP
     */
    function GetIP()
    {
        return FunctionsHelper::GetIP();
    }

    /***
     * 获取参数值
     * @param $key
     * @return string
     */
    protected function GetParamsValue($key)
    {
        return FunctionsHelper::GetParamsValue($key);
    }

    /***
     * 获取参数值
     * @param $key
     * @return string
     */
    protected function GetAvatarParamsValue_Base64($key)
    {
        if (!isset($_POST[$key])) {
            if (!isset($_GET[$key]))
                return '';
            else
                return $_GET[$key];
        }
        return '';
    }

    /***
     * 获取boolean参数值
     * @param $key
     * @return boolean
     */
    protected function GetBooleanParamsValue($key)
    {
        $value = FunctionsHelper::GetParamsValue($key);
        if ($value == 1)
            return true;
        return false;
    }

    /**
     * 获取是否还有分页
     * @param $data
     * @return boolean
     */
    protected function GetHasMore($data)
    {
        if ($data['current_page'] < $data['last_page']) {
            return true;
        }
        return false;
    }


    /**
     * 获取页码
     * @return int 返回页码
     */
    protected function GetPageIndexParamsValue($request)
    {
        //校验是否传递pageindex参数，并且是否是数字
        if (!$this->Validator($request, ['page' => 'required|integer'])) {
            return 1;
        }
        $pageIndex = $this->GetParamsValue('page');
        if ($pageIndex <= 0 || $pageIndex == '') {
            return 1;
        }
        return $pageIndex;
    }

    /**
     * 生成Api需要返回的数据格式
     * @param $status                状态    1：正常；0不正常
     * @param $data                    数组数据
     * @param boolean $hasmore 是否有下一页数据    true or false
     * @param $extend                扩展数据    数据将会与status在同一层
     * @param string $open_click 点击事件
     * @param string $msg 消息    有传值就会弹出提示
     * @return string                返回结果    {"msg":"","status":1,"open_click":"","data":[]}
     */
    protected function GetApiJson($msg, $status, $data = null, $hasmore = false, $extend = null, $open_click = '')
    {
        $returnData = array('status' => $status,);
        //判断$extend是不是有值 if
        if ($extend) {
            //判断$extend是不是数组 if
            if (is_array($extend)) {     //如果是数组，key  value   for
                foreach ($extend as $key => $value) {
                    $returnData[$key] = $value;
                }
            }
        }
        $returnData['data'] = $data;
        $returnData['msg'] = $msg;
        return json_encode($returnData);
    }

    //保存图片的方法（参数：图片的base64的文件流,要保存的文件夹的名称,文件名的随机数）
    function saveImg($base64_image_content,$file,$rank_name){
        $msg = "";
        if(empty($file)){
            $file = 'Mixture';
        }

        if(empty($rank_name)){
            $rank_name = str_random('10');
        }

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $type = $result[2];

            $path = "upload/images/".$file."/".date('Ymd',time());

            $check_result = $this->createFolders($path);

            if($check_result == true){
                $img_name = $rank_name.date('Ymdhis',time()).time().rand(1,999).".{$type}";
                $img_file = base64_decode(str_replace($result[1], '', $base64_image_content));


                if (file_put_contents($_SERVER["DOCUMENT_ROOT"].'/'.$path.'/'.$img_name,$img_file)){
                    $url =$path.'/'.$img_name;
                    $status = 0;
                    $msg="保存成功！";
                }else{
                    $url ="";
                    $msg="保存失败！";
                    $status = -1;
                }
            }
            else{
                $url ="";
                $msg="创建文件夹失败！";
                $status = -2;
            }
        }
        else{
            $url ="";
            $msg="无法解析！";
            $status = -3;
        }

        $return_result['url'] = $url;
        $return_result['status'] = $status;
        $return_result['msg'] = $msg;


        return $return_result;
    }

    public  function createFolders($path)
    {
        // 递归创建
        if (!file_exists($path)) {

            $this->createFolders(dirname($path));
            if (!mkdir($path, 0777)) {
                return '建立存放上传文件目录失败';
            }
        }
        return true;
    }
}
