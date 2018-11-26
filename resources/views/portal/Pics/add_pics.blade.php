<style>
    td{white-space: nowrap;}
    #test2 { position:fixed; top:25%;left:6%;z-index: 5}
/*    .my-modal{z-index:1002}
    .my-modal-parent .ivu-modal-mask{
        z-index: 1001;
    }*/
    .active_back{
        background: #e6f0fb !important;
    }
    [v-cloak] {
        display: none;
    }
    .top1{
        padding: 10px;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        text-align: center;
        border-radius: 2px;
    }

</style>
<div id="app" class="content-box" v-cloak>
    {{ csrf_field()}}
    <div >
        <form  name="edit_article_form"  method="post"  id="edit_article_form">
            <div id="titleVue"  style="min-height:0px;padding-bottom: 5px;">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 sortable-grid ui-sortable">
                        <div >
                            <input type="text" class="form-control" name="article_title"
                                   id="article_title" v-model="title"
                                   placeholder="请输入8～30个字符的标题，结尾不能为句号或叹号" maxlength="100"
                                   style="padding-left:0px;"/>

                            <span style="color: green" class="title_tip" v-if="titleNum <= 30">@{{ titleNum }}/30</span>
                            <span style="color: red" class="title_tip" v-else>@{{ titleNum }}/30</span>
                        </div>

                    </div>
                    <label>
                        <a class="btn btn-primary title-check" @click="checkTitleRepetiveRate">
                            <font style="color:white;">检测标题重复率</font>
                        </a>
                    </label>



            </div>
            <div>
                <p :style="{ color: styleColor }" style="margin-left: 15px;">@{{ hint }}</p>
                <p :style="{ color: repetiveColor }" style="margin-left: 15px;">@{{ repetitionHint }}</p>
                {{--<label :style="{ color: repetiveColor }" class="title-tip"></label>--}}
            </div>
            <div style="clear: both"></div>
            <template >
                <Affix>
                <div class="addBtnBox demo-affix" id="affix" style="margin-left:15px">
<!--                    <div class="addBtnBox demo-affix" id="affix" style="margin-left: 15px;margin-top: 50px">-->
                    <a class="btn btn-primary"href="#" @click="saveArticlePics">
                        <font style="color:white;"><i class="fa fa-tag"></i> 存草稿</font>                                            </a>

                    <a class="btn btn-primary"href="#" @click="auditArticle"  :disabled="isDisable">
                        <font style="color:white;"><i class="fa fa-legal "></i>提交审核</font>
                    </a>

                    <a class="btn btn-primary" :href="previewUrl" @click="showPreview"  target="_blank" >
                        <font style="color:white;">
                            <i class="fa fa-print"></i>
                            预览
                        </font>
                    </a>

                    <a class="btn btn-primary"href="#" @click="setPlanTimemodal = true">
                        <font style="color:white;"><i class="fa fa-clock-o"></i>定时发布</font>
                    </a>
                    {{--<a class="btn" @click="addGoodsmodal = true">--}}
                    {{--<font style="color:white;">请先添加宝贝＊ </font>--}}
                    {{--<goods-card @goods-select="goodsSelect">--}}

                    {{--</goods-card>--}}

                    {{--</a>--}}
                    <a class="btn" >
                        <goods-card :modal-show="showStatus" @goods-select="goodsSelect"></goods-card>
                    </a>

                    <a v-if="goodsCardNum > 20">
                        产品卡数量:<span  style="color: red" >@{{ goodsCardNum }}</span>
                    </a>
                    <a v-else>
                        产品卡数量:<span  style="color: green" >@{{ goodsCardNum }}</span>
                    </a>

                    <a class="ivu-btn ivu-btn-warning" @click="editSelectGoodsData(items,1)" style="margin-left: 100px">
                        <font style="color:white;"><i class="fa fa-wrench" ></i>修改全部</font>
                    </a>

                    <a class="ivu-btn ivu-btn-warning" @click="sortmodal = true" >
                        <font style="color:white;"><i class="fa fa-sort" ></i>排序</font>
                    </a>
                </div>
            </Affix>
            </template>


            <div  class="addBtnBox" style="height: 100%;margin-top: 10px">
                {{--<div class="row" id="acticle_pos_div"></div>--}}
                {{--<div class="row"></div>--}}
                {{--<div class=""></div>--}}
                {{--<div >--}}
                    {{----}}
                {{--</div>--}}
                <Modal v-model="sortmodal" title="产品卡排序"  width="80%"  :mask-closable="false" footer-hide="true">
                    <draggable  v-model="items" @start="drag=true" @end="drag=false">
                        <Card v-for="(item,index) in items" :key="index" class="picDiv" style="display:inline-block;width: 140px;text-align: center;position:relative">
                            <img :src="item.goodsDatas.main_pic" style="width: 100px;height:100px;"/>
                            <div style="color: red;position:absolute;bottom:15px;right:22px">
                                ￥@{{ item.price }}
                            </div>
                        </Card>
                    </draggable>
                    <br/>
                    <div  style="text-align: center">
                        <span class="btn btn-sm btn-primary" @click="closeSortModal">
                            关闭
                        </span>
                    </div>
                </Modal>

                <draggable  v-model="items" @start="drag=true" @end="drag=false">
                    <Card  v-for="(item,index) in items" :key="index" style="width:363px;display: inline-block;margin-left: 15px;margin-top: 15px" @dblclick.native="editSelectGoodsData(item.goods_id,index)" class="cardDiv">
                        <a slot="title" @click="editSelectGoodsData(item.goods_id,index)" >
                            <Icon type=""></Icon>
                            修改<i class="fa fa-wrench"></i>
                        </a>
                        <a href="#" slot="extra" @click="deleteGoodsPics(index)" >
                            <Icon type="ios-loop-strong"></Icon>
                            <span style="font-size: 20px;">×</span>
                        </a>
                        <div >
                            <div style="width: 100%;height: 200px;">
                                <div style="float: left;width: 65%;height:100%;text-align: center">
                                    <img :src="item.goodsDatas.main_pic" style="max-height:100%;max-width:100%;" class="atlas_main_pic"/>
                                </div>
                                <div style="float: left;width:35%;;padding-left: 10px;height:100%">
                                    <div style="width:100%;height:50%;text-align: center">
                                        <img :src="item.goodsDatas.sub_pic" style="max-height:100%;max-width:100%;"  class="atlas_sub_pic"/>
                                    </div>
                                    <div style="width:100%;height:50%">
                                        <div style="height:100%;text-overflow: ellipsis;overflow: hidden;margin: auto">
                                            <Tooltip  placement="top-end">
                                                <div slot="content" style=" white-space: normal">
                                                    <div >@{{ item.goodsDatas.sub_describe }}</div>
                                                </div>
                                                <span style="font-size: 12px;">
                                                     @{{ item.goodsDatas.sub_describe  }}
                                                </span>
                                            </Tooltip>

                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div style="clear: both"></div>
                            <div style="width: 100%;height: 17px;margin-top: 10px;text-overflow: ellipsis;overflow: hidden;white-space: normal;">
                                <div style="width:80%;float:left">
                                    <Tooltip  placement="top-end">
                                        <div slot="content" style=" white-space: normal">
                                            <div >@{{ item.goodsDatas.title }}</div>
                                        </div>
                                        <a :href="item.goods_url" target="_blank">
                                            @{{ item.goodsDatas.title }}
                                        </a>
                                    </Tooltip>

                                </div>
                                <div style="color: red;float:left">
                                        ￥@{{ item.price }}
                                </div>
                            </div>
                            <div style="clear: both"></div>
                            <div  style="width: 100%;height: 40px;margin-top: 10px;overflow:hidden;text-overflow: ellipsis">
                                <Tooltip  placement="top-end">
                                    <div slot="content" style=" white-space: normal">
                                        <div >@{{ item.goodsDatas.main_describe }}</div>
                                    </div>
                                    <span >
                                        @{{ item.goodsDatas.main_describe }}
                                    </span>
                                </Tooltip>

                            </div>
                            <div style="clear: both"></div>
                            <div style="width: 100%;height: 20px;margin-top: 10px">
                                {{--<a :href="item.goods_url" target="_blank">--}}
                                <a :href="['https://haohuo.snssdk.com/views/shop/index?id='+item.shop_id]"  target="_blank">
                                    @{{ item.shop_name }}
                                </a>

                                <span>
                                         佣金：@{{ item.commission_rate*100 }}%
                                    </span>
                                <span>
                                         销量：@{{ item.sell_num }}
                                    </span>
                            </div>

                        </div>
                    </Card>
                </draggable>






            </div>

        </form>
    </div>


    {{--<modal--}}
            {{--title="添加宝贝"--}}
            {{--v-model="addGoodsmodal"--}}
            {{--ok-text="提交"--}}
    {{--@on-ok="addGoods"--}}
    {{--class-name="vertical-center-modal">--}}
    {{--<i-input type="textarea" v-model="goodsLink" placeholder="请输入商品链接" clearable style="margin: 20px 0 20px 10px;width: 490px;"></i-input>--}}
    {{--</modal>--}}
    <modal
    title="设置定时发布时间"
    v-model="setPlanTimemodal"
    ok-text="确定"
    @on-ok="doPulishPlanTime"
    class-name="vertical-center-modal">
    <Date-picker id="planTime" type="datetime"  v-model="planTime" placeholder="选择日期和时间" style="width: 200px"></Date-picker>
    </modal>



    <div id="modalVue">
        <Modal v-model="modal" title="编辑商品" width="80%"  :mask-closable="false" footer-hide="true">
            <template >
                <Affix>
                    <div class="demo-affix"  align="right"  style="position: fixed;top:8%;right:12%;z-index:5">
                        <input :disabled="isDisable" type="button" class="ivu-btn ivu-btn-warning" @click="saveGoodsData" value="保存" />
                        <input type="button" class="btn btn-sm btn-primary" @click="changeSensitiveWord" value="清除敏感词"/>
                        <a class="location" href="" style="display: none">定位</a>
                    </div>
                </Affix>
            </template>
            <div v-for="(goodsDatas,index) in goodsDatas" :key="index" class="modal-body" id="modal_select_pics_info" style="padding:0 0; height: 100%;" >
                <table class="table table-bordered table-striped emo-style" style="width:100%;margin-bottom:2px;table-layout: fixed">
                    <tr :class="{'active_back':index%2!= 1}">
                        <td width="25%" height="100%">
                            <div style="width: 100%;height:100%">
                                <div style="width: 80%;height:100%;float:left;">
                                    <div  style="width: 100%;height:10%;">
                                        标题:<span :id="['title_'+goodsDatas.product_id]" style="color:red"></span>
                                    </div>
                                    <div style="width: 100%;height:70%;">
                                        <textarea  v-model="goodsDatas.title" rows="4" cols="60"   class="form-control pics_title"  maxlength="20"  placeholder="请输入6～20个汉字的标题" style="padding:0px 3px;"  >             </textarea>
                                    </div>
                                    <div style="width: 100%;height:20%;word-wrap:break-word;white-space:normal;">

                                        <div v-if="goodsDatas.getTitleNumber == -1">
                                            @{{ goodsDatas.title_recommend }}
                                        </div>
                                        <div v-else>
                                            @{{ goodsDatas.title_recommend }}
                                            <p>@{{ goodsDatas.getTitleNumber }} - @{{ goodsDatas.getTitleNumberCount }}</p>
                                        </div>

                                    </div>

                                </div>
                                <div style="width: 20%;height:100%;float:left;">
                                    <br/>
                                    <div style="width: 100%;height:50%;">
                                        <a @click="getChangeGoodsTitle(goodsDatas.product_id,index)" class="btn btn-default btn-xs" >换<i class="fa fa-rotate-right"></i></a>
                                    </div>
                                    <br/>
                                    <div style="width: 100%;height:50%;">
                                        <a @click="setChangeTitle(index)" class="btn btn-default btn-xs" >插入</a>
                                    </div>
                                </div>
                            </div>

                        </td>
                        <td v-for="goodsImage in goodsDatas.images" width="15%" height="100%">
                            <div style="width: 100%;height:100%">
                                <div style="width: 70%;height:100%;float:left">
                                    <img :src="goodsImage" style="width:90%;overflow: hidden;" class="atlas_main_pic"/>
                                    <p>800px * 800px</p>
                                </div>
                                <div style="width: 30%;height:100%;float:left">
                                    <div style="width: 100%;height:50%;">
                                        <a  @click="setMainPic(goodsImage,index)" class="btn btn-default btn-xs " >设主</a>
                                    </div>
                                    <br/>
                                    <div style="width: 100%;height:50%;">
                                        <a @click="setSubPic(goodsImage,index)" class="btn btn-default btn-xs " >设副</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                </table>
                <table  class="table table-bordered table-striped emo-style" style="width:100%;margin-bottom:2px;table-layout: fixed">
                    <tr :class="{'active_back':index%2!= 1}">
                        <td width="20%" height="100%" align="center">
                            <div style="width: 75%;height:75%;position: relative">
                                <img :src="goodsDatas.main_pic" style="max-height:100%;max-width:100%;" :class="['main_pic_'+goodsDatas.product_id]" id="main_pic"  class="atlas_main_pic"/>
                                <span class="btn btn-promary btn-sm btn-crop" style="position: absolute;right:0;bottom: 0;background-color: grey;color: white" @click="cropAtlasImgFn(goodsDatas.product_id,index,'main_pic')">修改图片</span>
                            </div>
                        </td>
                        <td width="30%" height="100%" >
                            <div style="width: 80%;height:60%;float:left">
                          <textarea v-model="goodsDatas.main_describe"  rows="6" cols="60" maxlength="255"  placeholder="请输入主图描述" class="form-control">
                            </textarea>
                            </div>
                            <div  style="width: 20%;height:20%;float:left;">
                                <div style="width: 100%;height:30%;">
                                    <a @click="getChangeGoodsDescribe(goodsDatas.product_id,index)" class="btn btn-default btn-xs " >换<i class="fa fa-rotate-right"></i></a>
                                </div>
                                <br/>
                                <div style="width: 100%;height:30%;">
                                    <a @click="setChangeDesc(index)" class="btn btn-default btn-xs ">插入</a>
                                </div>
                                <div style="margin-top:10px;width:80%;height:40%;overflow-wrap: break-word; white-space: normal">
                                    <span :id="['main_des_'+goodsDatas.product_id]" style="color: red"></span>
                                </div>
                            </div>
                            <br/>
                            <div style="width: 100%;height:20%;word-wrap:break-word;white-space:normal;float: left">

                                <div v-if="goodsDatas.getDescribeNumber == -1">
                                    <p >@{{ goodsDatas.main_describe_recommend }}</p>
                                </div>
                                <div v-else>
                                    @{{ goodsDatas.main_describe_recommend }}
                                    <p>@{{ goodsDatas.getDescribeNumber }} - @{{ goodsDatas.getDescribeNumberCount }}</p>
                                </div>
                                <br/>
                                {{--<p :id="['main_des_'+goodsDatas.product_id]" style="color: red"></p>--}}
                            </div>
                        </td>
                        <td width="20%" height="100%" align="center">
                            <div style="width: 75%;height:75%;position: relative;">
                                <img :src="goodsDatas.sub_pic" :class="['sub_pic_'+goodsDatas.product_id]" style="max-height:100%;max-width:100%;" class="atlas_sub_pic"/>
                                <span class="btn btn-promary btn-sm btn-crop" style="position: absolute;right:0;bottom: 0;background-color: grey;color: white" @click="cropAtlasImgFn(goodsDatas.product_id,index,'sub_pic')">修改图片</span>
                            </div>
                        </td>
                        <td width="30%" height="100%">
                            <div style="width: 80%;height:60%;float:left">
                                <textarea v-model="goodsDatas.sub_describe" rows="6" cols="60" maxlength="255"  placeholder="请输入副图描述" class="form-control"></textarea>
                            </div>
                            <div  style="width: 20%;height:20%;float:left">
                                <div style="width: 100%;height:30%;">
                                    <a @click="getChangeGoodsSubDescribe(goodsDatas.product_id,index)" class="btn btn-default btn-xs " >换<i class="fa fa-rotate-right"></i></a>
                                </div>
                                <br/>
                                <div style="width: 100%;height:30%;">
                                    <a @click="setChangeSubDesc(index)" class="btn btn-default btn-xs " >插入</a>
                                </div>
                                <div style="margin-top:10px;width:80%;height:40%;overflow-wrap: break-word; white-space: normal">
                                    <span :id="['sub_des_'+goodsDatas.product_id]" style="color: red"></span>
                                </div>
                            </div>
                            <br/>
                            <div style="width: 100%;height:20%;word-wrap:break-word;white-space:normal;float: left">

                                <div v-if="goodsDatas.getSubDescribeNumber == -1">
                                    <p >
                                        @{{ goodsDatas.sub_describe_recommend }}
                                    </p>
                                </div>
                                <div v-else>
                                    @{{ goodsDatas.sub_describe_recommend }}
                                    <p>@{{ goodsDatas.getSubDescribeNumber }} - @{{ goodsDatas.getSubDescribeNumberCount }}</p>
                                </div>
                                <br/>
                                {{--<p :id="['sub_des_'+goodsDatas.product_id]" style="color: red"></p>--}}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

        </Modal>
        <Modal
                v-model="localModal"
                title="提示！"
                @on-ok="localModalok"
                @on-cancel="localModalcancel">
            <p>是否加载上一次未保存的数据？</p>
        </Modal>

    </div>
    <back-top :height="100" :bottom="200">
        <div class="top1">回到顶部</div>
    </back-top>
</div>


{{--拖拽插件--}}
<script src="{{ asset('lib/Sortable.min.js') }}"></script>
<script src="{{ asset('lib/vuedraggable.min.js') }}"></script>
{{--裁剪--}}
{{--<script src="{{ asset('js/indexCrop.js') }}"></script>--}}

@include('vue.vue_components.goods_card.goodsCard');


<script data-exec-on-popstate>
    //拖拽
    Vue.component('draggable');
   let vm;
   $(function () {
       var editData= eval(<?php echo $items;?>);
       var article_title= '<?php echo $title;?>';
       var article_id= '<?php echo $article_id;?>';
       if(editData==''){
           var showStatus=true;
           var previewUrl='/admin/article/preview_article_pics';
       }else{
           var showStatus=false;
           var previewUrl='/admin/article/preview_article_edit_pics';
       }
       vm = new Vue({
           el:'#app',
           store, // 挂载store
           data(){
               return{
                   title: '', // 标题
                   goodsLink:'',//产品链接
                   addGoodsmodal:false,
                   modal:false,
                   setPlanTimemodal:false,
                   sortmodal:false,//排序
                   items: [],//产品信息
                   goodsImages: [],//产品图集
                   goodsDatas:[],//产品数据
                   waitTitle:'',//产品推荐标题
                   main_pic:[],//主图
                   sub_pic:[],//副图
                   goods_id:'',//产品id
                   type:'',//类型：add 为添加、edit为编辑
                   index:'',//产品卡下标
                   title_recommend:'',
                   previewUrl:previewUrl,//预览
                   titleStatus:false,//检测标题重复率
                   data:[],
                   repetitionHint:'',
                   repetiveColor:'green',
                   hint: '', // 敏感词、中文、特殊符号提示语句
                   styleColor: 'red', // 上一条语句样式
                   sensitiveWord: [], // 敏感词数组
                   result:false,
                   planTime:'',//定时发布时间
                   doPublicPlanTime:'',//转换后确定的定时发布时间
                   //缓存
                   localModal:false,
                   goodsCardNum:0,//产品卡数量
                   titleNum:0,//标题可写字数
                   isDisable:false,//保存按钮不能连续点击
                   showStatus:showStatus,
               }

           },
           mounted() {
//             this.checkTitle(this.title);

               this.onLoad();
               this.$Message.config({top: 200,duration: 3});
           },
           methods: {
               loading() {
                   const msg = this.$Message.loading('正在加载中...', 0);
                   setTimeout(msg, 3000);
               },
               onLoad(){
                   if(editData!=''){

                       this.items=editData;
                       this.title=article_title;
                       this.goodsCardNum=editData.length;
                       //console.log(this.items);
                   }
               },
               //排序
               closeSortModal(){
                   vm.sortmodal=false;
               },
               goodsSelect(arr){
                   //console.log(arr);
                   //console.log(vm.items);
                   //判断是否有选择产品
                   if(arr==''){
                       vm.modal = false;
                   }else{
                       vm.type='add';//添加的表示位
                       //是否有加入过产品卡
                       if(vm.items==''){
                           ids='';
                           for(var i=0;i<arr.length;i++){
                              ids+=arr[i].goods_id+',';
                           }
                       }else{
                           var ids='';
                           var result = [];
                           var is_useNum=0;
                           for(var i = 0; i < arr.length; i++){
                               var obj = arr[i];
                               var num = obj.goods_id;
                               var isExist = false;
                               for(var j = 0; j < vm.items.length; j++){
                                   var aj = vm.items[j];
                                   var n = aj.goods_id;
                                   if(n == num){
                                       isExist = true;
                                       is_useNum++;
                                       break;
                                   }
                               }
                               if(!isExist){
                                   ids+=obj.goods_id+',';
                               }
                           }

                       }
                       if(is_useNum>0){
                           vm.$Message.error(is_useNum+' 个产品已在图集中，自动过滤！')
                       }
                       if(ids==''){
                           vm.modal = false;
                       }else{
                           //alert(ids);
                           console.log(ids);
                           ids=(ids.substring(ids.length-1)==',')?ids.substring(0,ids.length-1):ids;
                           vm.goods_id=ids;
                           //调用编辑
                           vm.getSelectGoodsData(ids);
                       }

                   }


               },
               //获取goods_id
//            addGoods() {
//                vm.type='add';
//                axios.get("get_select_goods", {
//                    params: {
//                        link:vm.goodsLink
//                    }
//                })
//                .then(function (response) {
//                    //console.log(response.data);
//
//                    //alert(data[0]);
//                    console.log(response.data)
//                    console.log(vm.items)
//                    //alert(vm.items.length)
//                    //ids='';
//                    ids=response.data;
//                    //alert(ids);
//                    //调用编辑
//                    vm.getSelectGoodsData(ids);
//                    //data=[response.data];
//                    vm.goods_id=response.data;
//
//                })
//                .catch(function (error) {
//                    console.log(error);
//                });
//            },
               //生成编辑页
           getSelectGoodsData(goods_id){

                   vm.modal = true;
                   //清空旧数据
                   vm.goodsDatas=[];
                   //加载。。。
                   vm.loading ();
                   axios.get('/admin/article/select_goods_data', {
                       params: {
                           select_product_id: goods_id,
                       }
                   }).then(function (response) {
                       //console.log(response);
                       //循环存储新数据
                       for(var i=0;i<response.data.DATA.length;i++){
                           arr=response.data.DATA[i];
                           //判断是否有产品没有推荐标题
                           if(response.data.waitTitle[response.data.DATA[i].product_id]){
                                arr.title=response.data.waitTitle[response.data.DATA[i].product_id].title;
                                arr.title_recommend=response.data.waitTitle[response.data.DATA[i].product_id].title_recommend;
                           }else{
                               arr.title='';
                               arr.title_recommend='';
                           }
                           arr.getChangeGoodsTitle=[];//换一换标题
                           arr.getChangeGoodsDescribe=[];//换一换主描述
                           arr.getChangeGoodsSubDescribe=[];//换一换副图描述
                           arr.getTitleNumber=-1;
                           arr.getDescribeNumber=-1;
                           arr.getSubDescribeNumber=-1;
                           //主图。副图
                           arr.main_pic=response.data.DATA[i].images[0];
                           arr.sub_pic=response.data.DATA[i].images[1];
                           //存储数据
                           vm.goodsDatas.push(arr);
                       }
                       //推荐title
                       vm.waitTitle=response.data.waitTitle;

                   }).catch(e => {
                       vm.$Message.error('服务器开了点小差，请稍后再试！')
                   });
           },
               //设置主图
          setMainPic(url,index){
//                vm.main_pic[index]=url;
              //alert(vm.goodsDatas[index].main_pic);
             // url=$('.main_pic_'+vm.goodsDatas[index].product_id).attr('src');
              if(vm.goodsDatas[index].sub_pic==url){
                  vm.$Message.error('主副图不能相同！')
              }else{
                  vm.goodsDatas[index].main_pic=url;
              }

                //console.log(vm.main_pic)
          },
               //设置副图
          setSubPic(url,index){
//              vm.sub_pic[index]=url;
              if(vm.goodsDatas[index].main_pic==url){
                  vm.$Message.error('主副图不能相同！')
              }else{
                  vm.goodsDatas[index].sub_pic=url;
              }

          },
          //设置定时发布时间
          doPulishPlanTime(){
              //gmt时间格式转换为日期
              if(vm.planTime!=''){
                  date = new Date(vm.planTime);
                  Str=date.getFullYear() + '-' +
                      (date.getMonth() + 1) + '-' +
                      date.getDate() + ' ' +
                      date.getHours() + ':' +
                      date.getMinutes() + ':' +
                      date.getSeconds();

              }else{
                  Str='';
              }
              vm.doPublicPlanTime=Str;
              //console.log(Str);
              vm.setPlanTimemodal=false;
          },
          //清除敏感词
          changeSensitiveWord(){
                axios.post('/admin/article/change_sensitiveWord', {
                       params: {
                           goods_datas: vm.goodsDatas,
                       },
                    _token:LA.token
                   }).then(function (response) {
                       data=response.data.DATA;
                        vm.goodsDatas=data;
                        //console.log(vm.goodsDatas)
                   });
          },
               //保存产品卡
          saveGoodsData(type){
              data=vm.goods_id.split(',');
              //alert(data);
              //加载。。。
              vm.loading();
              this.isDisable = true;
              setTimeout(() => {
                  this.isDisable = false
              }, 2000);
              axios.get('http://baseinfo.youdnr.com/api/goods/get_goods_data_v2', {
                    params: {
                        goods_id_arr: data,
                    }
                }).then(function (response) {

                        vm.datas=response.data.data;

                      //字数、为空判断
                      re=vm.checkContent();
                      console.log( vm.datas);
                      if(re){
                          //敏感词判断
                           axios.post('/admin/article/check_content_sensitiveWord', {
                               params: {
                                   goods_datas: vm.goodsDatas,
                               },
                               _token:LA.token
                           }).then(function (response) {
                               //data=response.data.DATA;
                               arrData=response.data.DATA;
                               if(response.data.CODE=='SENSITIVE_WORD'){
                                   for(var x=0;x<vm.goodsDatas.length;x++){
                                       if(arrData['title_'+vm.goodsDatas[x].product_id]==""){
                                           $('#title_'+vm.goodsDatas[x].product_id).html('');
                                       }else{
                                           $('#title_'+vm.goodsDatas[x].product_id).html('标题包含敏感词『'+arrData['title_'+vm.goodsDatas[x].product_id]+'』');
                                           $('.location').attr('href','#title_'+vm.goodsDatas[x].product_id);
                                           $('.location')[0].click();
                                           vm.result=false;
                                       }
                                       if(arrData['main_des_'+vm.goodsDatas[x].product_id]==""){
                                           $('#main_des_'+vm.goodsDatas[x].product_id).html('');
                                       }else{
                                           $('#main_des_'+vm.goodsDatas[x].product_id).html('描述包含敏感词『'+arrData['main_des_'+vm.goodsDatas[x].product_id]+'』');
                                           $('.location').attr('href','#title_'+vm.goodsDatas[x].product_id);
                                           $('.location')[0].click();
                                           vm.result=false;
                                       }
                                       if(arrData['sub_des_'+vm.goodsDatas[x].product_id]==""){
                                           $('#sub_des_'+vm.goodsDatas[x].product_id).html('');
                                       }else{
                                           $('#sub_des_'+vm.goodsDatas[x].product_id).html('描述包含敏感词『'+arrData['sub_des_'+vm.goodsDatas[x].product_id]+'』');
                                           $('.location').attr('href','#title_'+vm.goodsDatas[x].product_id);
                                           $('.location')[0].click();
                                           vm.result=false;
                                       }
                                   }

//                                   if(response.data.word!=''){
//                                       vm.$Message.error('内容中包含敏感词：['+response.data.word+']。')
//                                   }
                               }else{
                                   //alert(vm.type);
                                  // console.log(vm.datas);
                                   if(vm.type=='add'){
                                       for(var i=0;i<vm.datas.length;i++){

                                           arr=vm.datas[i];
                                           for(var j=0;j<vm.goodsDatas.length;j++){
                                               if(vm.datas[i].goods_id==vm.goodsDatas[j].product_id){
                                                   vm.goodsDatas[j].main_pic=$('.main_pic_'+vm.goodsDatas[j].product_id).attr('src');
                                                   vm.goodsDatas[j].sub_pic=$('.sub_pic_'+vm.goodsDatas[j].product_id).attr('src');
                                                   arr.goodsDatas=vm.goodsDatas[j];
                                               }

                                           }
                                           vm.items.push(arr);
                                       }
                                       //产品卡数量
                                       vm.goodsCardNum=vm.items.length;
                                       //进入发布图集页
                                       if(editData==''){
                                           //缓存产品卡数据
                                           localStorage.setItem('selectPicsGoodsData',JSON.stringify(vm.items));
                                           //缓存文章标题
                                           localStorage.setItem('articleTitle',JSON.stringify(vm.title));
                                       }else{
                                           //缓存产品卡数据
                                           localStorage.setItem('PreselectPicsGoodsData',JSON.stringify(vm.items));
                                           //缓存文章标题
                                           localStorage.setItem('PrearticleTitle',JSON.stringify(vm.title));
                                       }

                                   }else{
                                       if(vm.type=='edit_alone'){
                                           vm.modal=false;
                                           arr=vm.datas[0];
                                           console.log(arr);
                                           if(vm.datas.length==0){
                                               vm.items.splice(vm.index, 1);
                                               //产品卡数量
                                               vm.goodsCardNum=vm.items.length;
                                               if(editData==''){
                                                   //缓存产品卡数据
                                                   localStorage.setItem('selectPicsGoodsData',JSON.stringify(vm.items));
                                                   //缓存文章标题
                                                   localStorage.setItem('articleTitle',JSON.stringify(vm.title));
                                               }else{
                                                   //缓存产品卡数据
                                                   localStorage.setItem('PreselectPicsGoodsData',JSON.stringify(vm.items));
                                                   //缓存文章标题
                                                   localStorage.setItem('PrearticleTitle',JSON.stringify(vm.title));
                                               }
                                               vm.$Message.error('该产品已下架，自动删除！');
                                           }else{
                                               vm.goodsDatas[0].main_pic=$('.main_pic_'+vm.goodsDatas[0].product_id).attr('src');
                                               vm.goodsDatas[0].sub_pic=$('.sub_pic_'+vm.goodsDatas[0].product_id).attr('src');
                                               //console.log(vm.goodsDatas[0]);
                                               arr.goodsDatas=vm.goodsDatas[0];

                                               vm.items[vm.index]=arr;
                                               //更新产品卡数据
                                               if(editData==''){
                                                   var arrs=JSON.parse(localStorage.getItem('selectPicsGoodsData'));
                                               }else{
                                                   var arrs=JSON.parse(localStorage.getItem('PreselectPicsGoodsData'));
                                               }

                                               //console.log(arrs);
                                               arrs[vm.index]=arr;
                                               if(editData==''){
                                                   //缓存产品卡数据
                                                   localStorage.setItem('selectPicsGoodsData',JSON.stringify(arrs));
                                                   //缓存文章标题
                                                   localStorage.setItem('articleTitle',JSON.stringify(vm.title));
                                               }else{
                                                   //缓存产品卡数据
                                                   localStorage.setItem('PreselectPicsGoodsData',JSON.stringify(vm.items));
                                                   //缓存文章标题
                                                   localStorage.setItem('PrearticleTitle',JSON.stringify(vm.title));
                                               }
                                           }


                                       }else{
                                           //vm.items=[];
                                           //全部修改
                                           for(var i=0;i<vm.items.length;i++){
                                               arr=vm.items[i];
                                               for(var j=0;j<vm.goodsDatas.length;j++){
                                                   if(vm.items[i].goods_id==vm.goodsDatas[j].product_id){
                                                       vm.goodsDatas[j].main_pic=$('.main_pic_'+vm.goodsDatas[j].product_id).attr('src');
                                                       vm.goodsDatas[j].sub_pic=$('.sub_pic_'+vm.goodsDatas[j].product_id).attr('src');
                                                       arr.goodsDatas=vm.goodsDatas[j];
                                                   }

                                               }
                                               //vm.items.push(arr);
                                           }

                                           if(editData==''){
                                               //缓存产品卡数据
                                               localStorage.setItem('selectPicsGoodsData',JSON.stringify(vm.items));
                                               //缓存文章标题
                                               localStorage.setItem('articleTitle',JSON.stringify(vm.title));
                                           }else{
                                               //缓存产品卡数据
                                               localStorage.setItem('PreselectPicsGoodsData',JSON.stringify(vm.items));
                                               //缓存文章标题
                                               localStorage.setItem('PrearticleTitle',JSON.stringify(vm.title));
                                           }

                                       }

                                   }
                                   vm.modal=false;
                                   vm.$Message.success('保存成功！');

                               }
                               //console.log(vm.items);

                           });

                      }

                  //console.log(vm.items);
                })
//                  .catch(e => {
//                      vm.$Message.error('服务器开了点小差，请稍后再试！')
//                });


          },
          //添加产品卡校验
           checkContent(){
              vm.result=true;
               for(var i=0;i<vm.goodsDatas.length;i++){
                   if(vm.goodsDatas[i].title==''){
                       $('#title_'+vm.goodsDatas[i].product_id).html('产品标题不能为空！');
                       $('.location').attr('href','#title_'+vm.goodsDatas[i].product_id);
                       $('.location')[0].click();
                       //vm.$Message.error('产品标题不能为空！');
//                       return false;
                       vm.result=false;
                   }else if(vm.goodsDatas[i].title.length < 6){
                       $('#title_'+vm.goodsDatas[i].product_id).html('产品标题字数不能小于6个字！');
                       $('.location').attr('href','#title_'+vm.goodsDatas[i].product_id);
                       $('.location')[0].click();
                       //vm.$Message.error('产品标题字数不能小于6个字！');
                       //                       return false;
                       vm.result=false;
                   }else if(vm.goodsDatas[i].title.length > 20){
                       //vm.$Message.error('产品标题字数过长！');
                       $('#title_'+vm.goodsDatas[i].product_id).html('产品标题字数过长！');
                       $('.location').attr('href','#title_'+vm.goodsDatas[i].product_id);
                       $('.location')[0].click();
                       //                       return false;
                       vm.result=false;
                   }else if(vm.goodsDatas[i].main_describe==''){
                       //vm.$Message.error('主图描述不能为空！');
                       $('#main_des_'+vm.goodsDatas[i].product_id).html('主图描述不能为空！');
                       $('.location').attr('href','#title_'+vm.goodsDatas[i].product_id);
                       $('.location')[0].click();
                       //                       return false;
                       vm.result=false;
                   }else if(vm.goodsDatas[i].main_describe.length < 8 ){
                       $('#main_des_'+vm.goodsDatas[i].product_id).html('主图描述不能小于8个字符！');
                       $('.location').attr('href','#title_'+vm.goodsDatas[i].product_id);
                       $('.location')[0].click();
                       //                       return false;
                       vm.result=false;
                   }else if(vm.goodsDatas[i].sub_describe==''){
                       //vm.$Message.error('副图描述不能为空！');
                       $('#sub_des_'+vm.goodsDatas[i].product_id).html('副图描述不能为空！');
                       $('.location').attr('href','#title_'+vm.goodsDatas[i].product_id);
                       $('.location')[0].click();
                       //                       return false;
                       vm.result=false;
                   }else if(vm.goodsDatas[i].sub_describe.length < 8 ){
                       //vm.$Message.error('副图描述不能为空！');
                       $('#sub_des_'+vm.goodsDatas[i].product_id).html('副图描述不能小于8个字符！');
                       $('.location').attr('href','#title_'+vm.goodsDatas[i].product_id);
                       $('.location')[0].click();
                       //                       return false;
                       vm.result=false;
                   }else{
                       $('#title_'+vm.goodsDatas[i].product_id).html('');
                       $('#main_des_'+vm.goodsDatas[i].product_id).html('');
                       $('#sub_des_'+vm.goodsDatas[i].product_id).html('');
                   }
               }
               //                       return false;
               //vm.result=true;
               return vm.result;
           },
               //编辑产品卡
          editSelectGoodsData(goods_id,index){
              //console.log(goods_id);
              //清除缓存
              vm.goodsDatas=[];

               if(typeof(goods_id)!='string'){
                   vm.type='edit_all';
                   vm.modal = true;
                   ids='';
                   for(var i=0;i<goods_id.length;i++){
                       ids+=goods_id[i].goods_id+',';
                       var arr=vm.items[i].goodsDatas;
                       //产品数据
                       vm.goodsDatas.push(arr);
                   }
                   vm.goods_id=ids;

               }else{
                   vm.type='edit_alone';
                   vm.index=index;
                   vm.goods_id=goods_id;
                   vm.modal = true;
                   var arr = [vm.items[index].goodsDatas];
                   //产品数据
                   vm.goodsDatas=arr;
               }



              //主图、副图
//              vm.sub_pic=[vm.items[index].sub_pic];
//              vm.main_pic=[vm.items[index].main_pic];
           },
           //预览
          showPreview(){
               //更新标题
              if(editData==''){
                  //缓存产品卡数据
                  localStorage.setItem('selectPicsGoodsData',JSON.stringify(vm.items));
                  localStorage.setItem('articleTitle',JSON.stringify(vm.title));
                  vm.previewUrl='/admin/article/preview_article_pics';
              }else{
                  //缓存产品卡数据
                  localStorage.setItem('PreselectPicsGoodsData',JSON.stringify(vm.items));
                  localStorage.setItem('PrearticleTitle',JSON.stringify(vm.title));
                  vm.previewUrl='/admin/article/preview_article_edit_pics';
              }

              //vm.previewUrl='preview_article_pics';
          },
          //删除产品卡
          deleteGoodsPics(indexNum){
              layer.confirm("确定要删除该产品卡？", {
                      btn: ['确认','取消']
                  }, function(index){

                  vm.items.splice(indexNum, 1);
                  //产品卡数量
                  vm.goodsCardNum=vm.items.length;
                  if(editData==''){
                      //缓存产品卡数据
                      localStorage.setItem('selectPicsGoodsData',JSON.stringify(vm.items));
                      //缓存文章标题
                      localStorage.setItem('articleTitle',JSON.stringify(vm.title));
                  }else{
                      //缓存产品卡数据
                      localStorage.setItem('PreselectPicsGoodsData',JSON.stringify(vm.items));
                      //缓存文章标题
                      localStorage.setItem('PrearticleTitle',JSON.stringify(vm.title));
                  }

                  layer.close(index);
              });

          },
          //存草稿
          saveArticlePics(){
              var re=true;
              for(var i=0;i<vm.items.length;i++){
                  if(vm.items[i].goodsDatas.main_describe=='' || vm.items[i].goodsDatas.sub_describe==''){
                      var re=false;
                      vm.$Message.error('描述不能为空！');
                      break;
                  }else if(vm.items[i].goodsDatas.title==''){
                      var re=false;
                      vm.$Message.error('标题不能为空！');
                      break;
                  }
              }
              if(re==true){
                  if(vm.items==''){
                      vm.$Message.error('请先添加宝贝！');
                  }else if(vm.goodsCardNum > 20){
                      vm.$Message.error('产品卡数量不允许超过20个！');
                  }else if(this.checkTitle(vm.title)==false){
                      vm.$Message.error(this.hint);
                  }else if(vm.title.length > 30){
                      vm.$Message.error('标题内容过长！');
                  }
//              else if(vm.titleStatus==false){
//                  vm.$Message.error('标题未检测！');
//              }else if(vm.titleRepetive >= 80){
//                  vm.$Message.error('标题重复率检测未通过！');
//              }
                  else{
                      vm.loading();
                      axios.post('/admin/article/save_article_pics', {
                          params: {
                              goodsArr: vm.items,
                              articleTitle:vm.title,
                              planTime:vm.doPublicPlanTime,
                              article_id:article_id
                          },
                          _token:LA.token
                      }).then(function (response) {
                          //清除本地缓存
                          vm.items=[];
                          localStorage.removeItem('selectPicsGoodsData');
                          localStorage.removeItem('articleTitle');
                          vm.$Message.success('保存成功！');
                          location.href='/admin/articles';
                      }).catch(e => {
                          vm.$Message.error('服务器开了点小差，请稍后再试！')
                      });

                  }
              }


           },
           // 标题重复率检测
           checkTitleRepetiveRate() {
               var that = vm;
               that.url="https://www.toutiao.com/search_content/?offset=0&format=json&autoload=true&count=20&cur_tab=1&from=search_tab&keyword="+that.title;
               $.ajax({
                   url: that.url,
                   type: 'GET',
                   dataType: 'JSONP',
                   success: function (res) {
                       that.data=res.data;
                       console.log(that.data);
                       if(that.data!=''){
                           if(res.data.length > 0){
                               var reg = /[\u4e00-\u9fa5]/g;
                               console.log(vm.title.match(reg));
                               if(vm.title.match(reg)!=null){
                                   var title = vm.title.match(reg).join("").split("");
                                   var rtitleArr = []; // 存放 data 里提取出来的标题
                                   var rTitle = 0;   // 重复率最高的标题
                                   var repetitiveRate = 0; // 重复率
                                   var num = 0;
                                   var rate = 0;
                                   that.data.map(item => {
                                       if(item.title != undefined){
                                           rtitleArr.push(item.title);
                                       }
                                   });
                                   rtitleArr.map(i => {
                                       title.map(j => {
                                           if(i.indexOf(j) != -1){
                                               num++;
                                           }
                                       });
                                       rate = Math.round(num / title.length * 100);
                                       if(repetitiveRate < rate){
                                           repetitiveRate = rate;
                                           rTitle = i;
                                       }
                                       num = 0;
                                   });
                               }


                               if(repetitiveRate >= 80){
                                   that.repetitionHint = `搜索到标题：${rTitle}；重复率：${repetitiveRate}%`;
                                   that.repetiveColor = 'red';
                               }else{
//                       that.repetitionHint = `重复率：${repetitiveRate}%`;
                                   $.ajax({
                                       url: "/admin/article/check_platform_article_title",
                                       type: 'GET',
                                       data:{'title':vm.title,'article_id':article_id},
                                       dataType: 'JSON',
                                       success: function (res) {
                                           if(res.code==1){
                                               that.repetitionHint = `搜索到标题："${res.title}" ；与平台文章标题，重复率：100%`;
                                               that.repetiveColor = 'red';
                                           }
                                           else {
                                               that.repetitionHint = `标题检测通过`;
                                               that.repetiveColor = 'green';
                                           }
                                       }
                                   })
                               }

                               that.titleStatus = true;
                               that.titleRepetive = repetitiveRate;
                           }
                       }else{
                           that.repetitionHint = `标题检测通过`;
                           that.repetiveColor = 'green';
                           that.titleStatus = true;
                           that.titleRepetive = repetitiveRate;
                       }



                   }
                });
               //缓存文章标题
               localStorage.setItem('articleTitle',JSON.stringify(vm.title));
           },
           //敏感词
           getSensitiveWordTitle() {
               var that = this;
               axios.get("/admin/article/sensitive_word",{
                   params: {
                       type: 1,
                   }
               }) .then(response => {
                       that.sensitiveWord = response.data;
                   })
           },
           //标题正则检测
           checkTitle(n){
               this.title = n.trim();

               vm.titleNum=this.title.length;

               this.titleHref = 'https://www.toutiao.com/search/?keyword=' + this.title;

               if(this.title.length > 0){

                   // 英文 ' 转为 中文 ‘
                   if(this.title.indexOf(`'`) != -1){
                       this.title = this.title.replace(`'`,`‘`);
                   }

                   // 检测是否有 8 个中文
                   reg = /[\u4e00-\u9fa5]/g;
                   if(vm.title.match(reg)!=null){
                       var ChineseLength = this.title.match(reg).join('').length;
                   }else{
                       var ChineseLength=0;
                   }

                   if(ChineseLength < 8){
                       this.hint = `至少需要 8 个中文`;
                       this.styleColor = 'red';
                       return false;
                   }

                   // 检测是否是叠字
                   var sign = true;
                   var str = '';
                   var titleArr = this.title.split('');
                   for(var i = 0; i < titleArr.length; i++){
                       if(i === 0) str = titleArr[i];
                       if(str !== titleArr[i]){
                           sign = false;
                           break;
                       }
                       str = titleArr[i];
                   }
                   if(sign === true){
                       this.hint = `检测到标题都是叠字`;
                       this.styleColor = 'red';
                       return false;
                   }

                   // 检测末尾是否特殊符号
                   var regEn = /[`~!@#$%^&*()_+<>?:"{},.\/;'[\]]/im;
                   var regCn = /[·！#￥（——）：；“”‘、，|《。》？、【】[\]]/im;
                   if(regEn.test(this.title.charAt(this.title.length - 1)) || regCn.test(this.title.charAt(this.title.length - 1))){
                       this.hint = `检测到标题末尾有特殊字符`;
                       this.styleColor = 'red';
                       return false;
                   }

                   // 敏感词检测

                   console.log(this.sensitiveWord);
                   if(this.sensitiveWord.length === 0){
                       this.getSensitiveWordTitle();
                   }
                   for(var i = 0; i< this.sensitiveWord.length; i++){
                       if(this.title.indexOf(this.sensitiveWord[i]) != -1){
                           this.hint = `检测到标题含有敏感词『 ${this.sensitiveWord[i]} 』`;
                           this.styleColor = 'red';
                           return false;
                       }
                   }

                    if(n.length > 30 ){
                        this.hint = `检测到标题字数超过30个字`;
                        this.styleColor = 'red';
                        return false;
                    }else{
                        this.hint = `还可以输入 ${30 - n.length} 字`;
                        this.styleColor = 'green';
                    }

               }else{
                   this.hint = `请输入标题`;
                   this.styleColor = 'red';
                   return false;
               }
               console.log(this.hint);
               console.log(this.styleColor);
           },
           //换一换产品标题
           getChangeGoodsTitle(goods_id,index){
               var that=vm;
                //获取推荐标题接口
               if(that.goodsDatas[index].getChangeGoodsTitle==''){
                   axios.get('/admin/article/get_change_goods_title', {
                       params: {
                           goods_id: goods_id,
                       }
                   }).then(function (response) {
                       if(response.data.CODE=='ok'){
                           data=response.data.DATA;
//                                if(data.length==0){
//                                    //推荐标题条数(初始值)
//                                    that.goodsDatas[index].getTitleNumberCount=1;
//                                    that.goodsDatas[index].getTitleNumber=0;
//                                }else{
                                    that.goodsDatas[index].getChangeGoodsTitle=data;
                                    //推荐标题条数(初始值)
                                    that.goodsDatas[index].getTitleNumberCount=data.length;
//                           that.goodsDatas[index].getTitleNumber=data.length;
                                    that.goodsDatas[index].getTitleNumber=1;
                                    that.goodsDatas[index].title_recommend=data[0];
//                                }


                       }
                       console.log(response);
                   }).catch(e => {
                       that.$Message.error('服务器开了点小差，请稍后再试！')
                   });
               }else{
//                   //计算推荐那一条
//                   if (that.goodsDatas[index].getTitleNumber > 0){
//                       that.goodsDatas[index].getTitleNumber=that.goodsDatas[index].getTitleNumber-1;
//                   }else{
//                       that.goodsDatas[index].getTitleNumber=that.goodsDatas[index].getTitleNumberCount-1;
//                   }
//                   //赋值
//                   that.goodsDatas[index].title_recommend=that.goodsDatas[index].getChangeGoodsTitle[that.goodsDatas[index].getTitleNumber];

                   //计算推荐那一条
                   if (that.goodsDatas[index].getTitleNumber < that.goodsDatas[index].getTitleNumberCount){
                       that.goodsDatas[index].getTitleNumber=that.goodsDatas[index].getTitleNumber+1;
                   }else{
                       that.goodsDatas[index].getTitleNumber=1;
                   }
                   //赋值
                   if(that.goodsDatas[index].getTitleNumber-1>=0){
                       that.goodsDatas[index].title_recommend=that.goodsDatas[index].getChangeGoodsTitle[that.goodsDatas[index].getTitleNumber-1];
                   }

               }
               console.log(that.goodsDatas[index].getTitleNumber);

           },
          //插入换一换的标题
          setChangeTitle(index){
               if(vm.goodsDatas[index].title_recommend!=''){
                   vm.goodsDatas[index].title=vm.goodsDatas[index].title_recommend;
               }

          },
          //换一换主图描述
           getChangeGoodsDescribe(goods_id,index){
               var that=vm;
               //获取推荐标题接口
               if(that.goodsDatas[index].getChangeGoodsDescribe==''){
                   axios.get('/admin/article/get_change_goods_describe', {
                       params: {
                           goods_id: goods_id,
                       }
                   }).then(function (response) {
                       if(response.data.CODE=='ok'){
                           data=response.data.DATA;
                           that.goodsDatas[index].getChangeGoodsDescribe=data;
                           //推荐标题条数(初始值)
                           that.goodsDatas[index].getDescribeNumberCount=data.length;
//                           that.goodsDatas[index].getDescribeNumber=data.length;
                           that.goodsDatas[index].getDescribeNumber=1;
                           that.goodsDatas[index].main_describe_recommend=data[0];
                       }
                       console.log(response);
                   }).catch(e => {
                       that.$Message.error('服务器开了点小差，请稍后再试！')
                   });
               }else{
//                   //计算推荐那一条
//                   if (that.goodsDatas[index].getDescribeNumber > 0){
//                       that.goodsDatas[index].getDescribeNumber=that.goodsDatas[index].getDescribeNumber-1;
//                   }else{
//                       that.goodsDatas[index].getDescribeNumber=that.goodsDatas[index].getDescribeNumberCount-1;
//                   }
//                   //赋值
//                   that.goodsDatas[index].main_describe_recommend=that.goodsDatas[index].getChangeGoodsDescribe[that.goodsDatas[index].getDescribeNumber];

                   //计算推荐那一条
                   if (that.goodsDatas[index].getDescribeNumber < that.goodsDatas[index].getDescribeNumberCount){
                       that.goodsDatas[index].getDescribeNumber=that.goodsDatas[index].getDescribeNumber+1;
                   }else{
                       that.goodsDatas[index].getDescribeNumber=1;
                   }
                   //赋值
                   if(that.goodsDatas[index].getDescribeNumber-1>=0){
                       that.goodsDatas[index].main_describe_recommend=that.goodsDatas[index].getChangeGoodsDescribe[that.goodsDatas[index].getDescribeNumber-1];
                   }

               }
           },
           //插入换一换的主图描述
           setChangeDesc(index){
               vm.goodsDatas[index].main_describe=vm.goodsDatas[index].main_describe_recommend;
           },
          //换一换副图描述
           getChangeGoodsSubDescribe(goods_id,index){
               var that=vm;
               //获取推荐标题接口
               if(that.goodsDatas[index].getChangeGoodsSubDescribe==''){
                   axios.get('/admin/article/get_change_goods_subdescribe', {
                       params: {
                           goods_id: goods_id,
                       }
                   }).then(function (response) {
                       if(response.data.CODE=='ok'){
                           data=response.data.DATA;
                           that.goodsDatas[index].getChangeGoodsSubDescribe=data;
                           //推荐标题条数(初始值)
                           that.goodsDatas[index].getSubDescribeNumberCount=data.length;
//                           that.goodsDatas[index].getSubDescribeNumber=data.length;
                           that.goodsDatas[index].getSubDescribeNumber=1;
                           that.goodsDatas[index].sub_describe_recommend=data[0];
                       }
                       console.log(response);
                   }).catch(e => {
                       that.$Message.error('服务器开了点小差，请稍后再试！')
                   });
               }else{
                   //getSubDescribeNumber=that.goodsDatas[index].getSubDescribeNumber;
                   getSubDescribeNumberCount=that.goodsDatas[index].getSubDescribeNumberCount;
//                   //计算推荐那一条
//                   if (that.goodsDatas[index].getSubDescribeNumber > 0){
//                       that.goodsDatas[index].getSubDescribeNumber=that.goodsDatas[index].getSubDescribeNumber-1;
//                   }else{
//                       that.goodsDatas[index].getSubDescribeNumber=getSubDescribeNumberCount-1;
//                   }
//                   //赋值
//                   that.goodsDatas[index].sub_describe_recommend=that.goodsDatas[index].getChangeGoodsSubDescribe[that.goodsDatas[index].getSubDescribeNumber];

                   //计算推荐那一条
                   if (that.goodsDatas[index].getSubDescribeNumber < getSubDescribeNumberCount){
                       that.goodsDatas[index].getSubDescribeNumber=that.goodsDatas[index].getSubDescribeNumber+1;
                   }else{
                       that.goodsDatas[index].getSubDescribeNumber=1;
                   }
                   //赋值
                   if(that.goodsDatas[index].getSubDescribeNumber-1>=0){
                       that.goodsDatas[index].sub_describe_recommend=that.goodsDatas[index].getChangeGoodsSubDescribe[that.goodsDatas[index].getSubDescribeNumber-1];
                   }

               }
           },
           //插入换一换的副图描述
           setChangeSubDesc(index){
               vm.goodsDatas[index].sub_describe=vm.goodsDatas[index].sub_describe_recommend;
           },
           //提交审核
           auditArticle(){
               var re=true;
               for(var i=0;i<vm.items.length;i++){
                   if(vm.items[i].goodsDatas.main_describe=='' || vm.items[i].goodsDatas.sub_describe==''){
                       var re=false;
                       vm.$Message.error('描述不能为空！');
                       break;
                   }else if(vm.items[i].goodsDatas.title==''){
                       var re=false;
                       vm.$Message.error('标题不能为空！');
                       break;
                   }
               }
               if(re==true){
                   if(vm.items==''){
                       vm.$Message.error('请先添加宝贝！');
                   }else if(vm.goodsCardNum > 20){
                       vm.$Message.error('产品卡数量不允许超过20个！');
                   }else if(this.checkTitle(vm.title)==false){
                       vm.$Message.error(this.hint);
                   }else if(vm.title.length > 30){
                       vm.$Message.error('标题内容过长！');
                   }else if(vm.titleStatus==false){
                       vm.$Message.error('标题未检测！');
                   }else if(vm.titleRepetive >= 80){
                       vm.$Message.error('标题重复率检测未通过！');
                   }else if(vm.items.length < 10){
                       vm.$Message.error('至少需要添加10个图集模块才能提交审核！');
                   }else{
                       //加载。。。
                       vm.loading();
                       this.isDisable = true;
                       setTimeout(() => {
                           this.isDisable = false
                       }, 3000);
                       axios.post('/admin/article/audit_article', {
                           params: {
                               goodsArr: vm.items,
                               articleTitle:vm.title,
                               planTime:vm.doPublicPlanTime,
                               article_id:article_id
                           },
                           _token:LA.token
                       }).then(function (response) {
                           console.log(response);
                           if(response.data.CODE=='error'){
                               vm.$Message.error(response.data.DATA);
                           }else{
                               vm.$Message.success(response.data.DATA);
                               //清除本地缓存
                               //清除本地缓存
                               vm.items=[];
                               localStorage.removeItem('selectPicsGoodsData');
                               localStorage.removeItem('articleTitle');
                               //vm.$Message.success('保存成功！');
                               location.href='/admin/articles';
                           }

                       }).catch(e => {
                           vm.$Message.error('服务器开了点小差，请稍后再试！')
                       });
                   }
               }

           },
           //加载缓存数据
           loadLocal(){
               var selectPicsGoodsData=JSON.parse(localStorage.getItem('selectPicsGoodsData'));
               if(selectPicsGoodsData === undefined || selectPicsGoodsData=== null) return false;
               if(editData==''){
                   if(selectPicsGoodsData.length>0){
                       vm.localModal=true;
                   }
               }
           },
           localModalok(){
               vm.items=JSON.parse(localStorage.getItem('selectPicsGoodsData'));
               vm.title=JSON.parse(localStorage.getItem('articleTitle'));
               //产品卡数量
               vm.goodsCardNum=vm.items.length;
           },
           localModalcancel(){
               localStorage.removeItem('selectPicsGoodsData');
               localStorage.removeItem('articleTitle');
           },
           //裁剪
           cropAtlasImgFn(product_id,goodsDataIndex,type){
               if(type=='main_pic'){
                   var $imgSingle=$('.main_pic_'+product_id);
                   cropAtlasImgFn($imgSingle,goodsDataIndex,type);
               }else{
                   var $imgSingle=$('.sub_pic_'+product_id);
                   cropAtlasImgFn($imgSingle,goodsDataIndex,type);
               }

           },
         },
           watch: {
               title: function (n, o) {
                   //标题内容修改，重新检测重复率
                   vm.titleStatus = false;
                   vm.repetitionHint='';
                   this.checkTitle(n);
               }
           }

       });
       vm.loadLocal();

   });

    //jq部分
//    $(document).scroll(function(e) {
//        //console.log($(document).scrollTop())
//        if($(document).scrollTop()!=0){
//            $("#test2").stop();
//            $("#test2").animate({"top":"0"});
//        }
//        else{
//            $("#test2").stop();
//            $("#test2").animate({"top":"25%"});
//        }
//    });

//    $(document).on('click','.btn-crop',function () {
//        var $imgSingle=$(this).siblings('img');
//        cropAtlasImgFn($imgSingle);
//    });
    $(document).on('click','.btn-change',function () {
        var $imgSingle=$(this).siblings('img');
        changeImgFn($imgSingle);
    });
    $(document).on('click','.atlas_main_pic',function () {
        var path = $(this).attr('src');
        showBigImg(path);
    });
    $(document).on('click','.atlas_sub_pic',function () {
        var path = $(this).attr('src');
        showBigImg(path);
    });
</script>