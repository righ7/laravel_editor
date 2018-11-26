<?php

namespace App\Admin\Controllers\Auth;

use App\Admin\Models\Article\Article;
use App\Admin\Models\BaseInfo\TemaiProductInfo;
use App\Admin\Models\Article\ArticlePics;
use App\Admin\CommonMethod\CArticle;
use App\Admin\Requests\ArticleApiRequest;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Layout\Row;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountTemaiController extends Controller
{
    public function index()
    {
        Admin::disablePjax();
        return Admin::content(function (Content $content){

            $content->header('账号发文设置');
            $content->description('列表');

            $content->body(view('account.TemaiSet.account_temai_list'));
        });
    }

    //获取列表数据
    public function getTemaiListData(Request $request){
        $serachArr=$request->searchArr;
        $serachArr = json_decode(htmlspecialchars_decode($serachArr),true);

        $accounts = $this->platformAccountArray($serachArr);

        $list = array();
        $i=0;
        foreach ($accounts as $k=>$v) {
            $list[$i]['id'] = $v->id;
            $list[$i]['name'] = $v->shop_name;
            $list[$i]['pics_num'] = $v->pics_num;
            $list[$i]['res_pics_num'] = $v->res_pics_num;
            $list[$i]['albums_num'] = $v->albums_num;
            $list[$i]['res_albums_num'] = $v->res_albums_num;
            $list[$i]['is_start'] = $v->is_start;
            $list[$i]['is_limit'] = $v->is_limit;
            $list[$i]['is_pics'] = $v->is_pics;
            $list[$i]['is_albums'] = $v->is_albums;
            $list[$i]['xd_pics_num'] = $v->xd_pics_num;
            $list[$i]['xd_res_pics_num'] = $v->xd_res_pics_num;
            $list[$i]['xd_albums_num'] = $v->xd_albums_num;
            $list[$i]['xd_res_albums_num'] = $v->xd_res_albums_num;
            $list[$i]['choice_pics_num'] = $v->choice_pics_num;
            $list[$i]['choice_albums_num'] = $v->choice_albums_num;
            $i++;
        }
        exit(json_encode($list,JSON_UNESCAPED_UNICODE));
    }

    //获取信息调用方法
    function platformAccountArray($serachArr){
        //判断是否有筛选条件
        if(empty($serachArr['shop_id']) || $serachArr['shop_id']==''){
            $where=[
                ['status',1],
                ['platform',4]
            ];
        }else{
            $shop_id=$serachArr['shop_id'];
            $where=[
                ['shop_id','like',"%$shop_id%"],
                ['status',1],
                ['platform',4]
            ];
        }

        //获取信息并返回
        //DB::connection()->enableQueryLog();#开启执行日志
        $datas=DB::table('platform_account')->where($where)->WhereNotNull('shop_id')->get();
        return $datas;
    }
    //开关启用
    public function  changeIsOn(Request $request){
        $data=$request;
        $type=$data->type;//类型
        if($type=='is_start'){
            $db=$this->changeIsStart($data);
        }elseif($type=='is_pics'){
            $db=$this->changeIsPics($data);
        }elseif ($type=='is_albums'){
            $db=$this->changeIsAlbums($data);
        }else{
            $return['msg']='类型参数有误！';
            $return['code']='no';
            exit(json_encode($return,JSON_UNESCAPED_UNICODE));
        }

       // if($db){
            $return['msg']='操作成功！';
            $return['code']='ok';
       // }else{
           // $return['msg']='操作失败！';
           // $return['code']='no';
        //}
        exit(json_encode($return,JSON_UNESCAPED_UNICODE));
    }


    //开关启用
    function  changeIsStart($data){
        $id=$data->id;
        $is_start=$data->is_start;// 0 不启用 1 启用
        for($i=0;$i<sizeof($id);$i++){
            $db=DB::table('platform_account')->where('id',$id[$i])
                ->update([
                    'is_start'=> $is_start
                ]);
        }


        return $db;
    }
    //启用专辑
    function changeIsAlbums($data){
        $id=$data->id;
        $is_albums=$data->is_albums;// 0 不启用 1 启用
        for($i=0;$i<sizeof($id);$i++){
            $db=DB::table('platform_account')->where('id',$id[$i])
                ->update([
                    'is_albums'=> $is_albums
                ]);
        }

        return $db;
    }
    //启用图集
    function changeIsPics($data){
        $id=$data->id;
        $is_pics=$data->is_pics;// 0 不启用 1 启用
        for($i=0;$i<sizeof($id);$i++){
            $db=DB::table('platform_account')->where('id',$id[$i])
                ->update([
                    'is_pics'=> $is_pics
                ]);
        }

        return $db;
    }


    //批量修改小店图集数、专辑数
    public function upAllResetNum(Request $request){
        $ids=$request->shop_id;
        $xd_pics_num=$request->xd_pics_num;
        $xd_albums_num=$request->xd_albums_num;
        for($i=0;$i<sizeof($ids);$i++){
            $db=DB::table('platform_account')->where('id',$ids[$i] )
                ->update([
                    'xd_pics_num' => $xd_pics_num,
                    'xd_albums_num'=>$xd_albums_num
                ]);
        }

        if($db){
            $return['msg']='操作成功！';
            $return['code']='ok';
        }else{
            $return['msg']='操作失败！';
            $return['code']='no';
        }
        exit(json_encode($return,JSON_UNESCAPED_UNICODE));
    }

    //重置（将专辑/图集数据同步到‘相对应的剩余数量’）
    public function restartAll(Request $request){
        $id=$request->shop_id;
        for($i=0;$i<sizeof($id);$i++){
            $data=DB::table('platform_account')
                ->where("id",$id[$i])
                ->select(['id','xd_pics_num','xd_res_pics_num','xd_albums_num','xd_res_albums_num'])
                ->first();
            DB::table('platform_account')->where("id",$id[$i])
                ->update([
                    'xd_res_pics_num' => $data->xd_pics_num,
                    'xd_res_albums_num'=>$data->xd_albums_num
                ]);
        }
        exit(json_encode('操作成功！',JSON_UNESCAPED_UNICODE));
    }
}