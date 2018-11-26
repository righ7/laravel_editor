<?php

namespace App\Admin\Controllers\GoodsCard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\DB;

class GoodsTagController extends Controller
{
    /**
     * 获取标签
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGoodsTags(){
        $res=[];
        $tagRoot=Admin::user()->can('goods_setting');
        $feedbackRoot=Admin::user()->can('goods.feedback');
        $res['tagRoot']=$tagRoot;
        $res['feedbackRoot']=$feedbackRoot;
        return response()->json($res);
    }
    //图集商品问题反馈
    public function addFeedBack(Request $request){
        $res['errorCode']=false;
        if ($request['rootcheck']){
            if ($request['rootcheck']==1){
                $this->ajaxReturn($res);
            }
        }
        $content=$request['content'];
        //var_dump($content);exit();
        $goods_url=$request['goods_url'];
        $goods_id=$request['goods_id'];
        $goods_title=$request['goods_title'];
        $user_id=Admin::user()->id;

        $data['user_id'] = $user_id;
        $data['goods_link'] = $goods_url;
        $data['goods_id'] = $goods_id;
        $data['type'] = 1;
        $data['content'] = $content;
        $data['time'] = date("Y-m-d H:i:s", strtotime('now'));
        $result=DB::table('feedback')->insert($data);
        if (!$result){
            $res['errorCode']=true;
        }
        if ($content=='产品图片问题'){
            $post_data = array(
                "goods_id" => $goods_id,
                "is_hide" => 1,
            );
            $url='http://baseinfo.youdnr.com/api/set_goods_hihe';
            $response=json_decode($this->send_post($url,$post_data),true);
            if ($response['error']==-1){
                $res['errorCode']=true;
                $res['msg']='特卖接口出错';
            }else{
                $data['is_hide']=1;
                $r=DB::table('feedback')->where('goods_id',$goods_id)->update($data);
                if (!$r){
                    $res['errorCode']=true;
                    $res['msg']='保存出错';
                }
            }
        }
        return response()->json($res);
    }
    public function send_post($url,$post_data='') {
        if ($post_data){
            $postdata = http_build_query($post_data);
        }
        else{
            $postdata = '';
        }
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
