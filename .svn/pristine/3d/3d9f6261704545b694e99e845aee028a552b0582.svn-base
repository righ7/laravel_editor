<?php

namespace App\Admin\Controllers\GoodsCard;

use Illuminate\Http\Request;
use App\Admin\Models\GoodsCard\TemaiGoodsSearchConfig;
use App\Http\Controllers\Controller;

class TemaiGoodsSearchConfigController extends Controller
{
    public function getShop()
    {
        $datas = TemaiGoodsSearchConfig::where('is_show',1)->orderBy('order_by', 'desc')->get();
        $result = [
            'fxg' => [],
            'xd' => []
        ];
        //重组shop_id
        $shop_ids='';
        foreach($datas as $k => $v){
            $shop_id=$v['shop_id'];
            $shop_ids.=$shop_id.',';
        }
        $shop_ids = rtrim($shop_ids, ',');

        //请求获取shop_id对应的商品数量
        $re=file_get_contents('http://baseinfo.youdnr.com/api/shop/get_shops_amount?shop_ids='.$shop_ids);
        $re=json_decode($re);
        $count=$re->data;
        //重组数组
        $i=0;
        foreach($count as $k => $v){
            $goodsNum[$i]['shop_id']=$k;
            $goodsNum[$i]['goods_num']=$v;
            $i++;
        }

        foreach($datas as $k => $v){
            $shop_id=$v['shop_id'];
            foreach ($goodsNum as $key=>$val){
                if($val['shop_id']==$shop_id){
                    $v['count']=$val['goods_num'];
                    break;
                }

            }
            if($v['type'] == 1){
                $result['fxg'][] = $v;
            }else if($v['type'] == 2){
                $result['xd'][] = $v;
            }
        }

        return response()->json($result);
    }
}
