<?php

namespace App\Admin\Controllers\GoodsCard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\DB;

class OmissionGoodsController extends Controller
{
    /**
     * 获取标签
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitGoods(Request $request){
//        try{
            $result['code'] = 0;
            $result['err_msg'] = '';
            $url=$request['url'];
            $arr = parse_url($url);
            if ($arr['query'] ?? ''){
                $arr_query = $this->convertUrlQuery($arr['query']);
            }else{
                $arr_query=[];
            }
            if(empty($arr['host'] ?? ''))
                $arr['host'] = '';
            if ($arr['host']=='haohuo.snssdk.com' || $arr['host']=='haohuo.jinritemai.com'){
                if ($arr_query['id']){
                    $search = DB::table('omission_goods')->where('sku_id',"{$arr_query['id']}")->get()->toArray();
                    if (!$search){
                        $data['sku_id'] = $arr_query['id'];
                        $data['status'] = 0;
                        $data['type'] = 0;
                        $data['feedback_time'] = date('Y-m-d H:i:s',time());
                        DB::table('omission_goods')->insert($data);
                    }else{
                        $data['status']=0;
                        DB::table('omission_goods')->where('sku_id',"{$arr_query['id']}")->update($data);
                    }
                }else{
                    $result['code'] = 1;
                    $result['err_msg'] = '请输入正确的放心购商品链接';
                }
            }else{
                $search = DB::table('omission_goods')->where("shop_name","$url")->get()->toArray();
                if (!$search){
                    $data['shop_name'] = $url;
                    $data['status'] = 0;
                    $data['type'] = 1;
                    $data['feedback_time'] = date('Y-m-d H:i:s',time());
                    DB::table('omission_goods')->insert($data);
                }else{
                    $data['status']=0;
                    DB::table('omission_goods')->where('shop_name',"$url")->update($data);
                }
            }

//        }catch(\Exception $e){
//            $result['code'] = 1;
//            $result['err_msg'] = $e->getMessage();
//        }finally{
//            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
//        }

    }
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
