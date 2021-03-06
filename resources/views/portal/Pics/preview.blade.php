<!doctype html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('simpleboot/css/public.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('smartadmin/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('smartadmin/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('smartadmin/css/smartadmin-production.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('smartadmin/css/smartadmin-production-plugins.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('smartadmin/css/smartadmin-skins.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('smartadmin/css/jquery.gritter.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('smartadmin/css/smartadmin-rtl.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/iview.css') }}" />

    <style>
        form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
        .table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
        .table-list{margin-bottom: 0px;}
        body{overflow-y: auto;}
        html{overflow-y: auto;}
        [v-cloak] {
            display: none;
        }
    </style>
    <!--[if IE 7]>
    <link rel="stylesheet" href="__PUBLIC__/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
            <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-skins.min.css">
        <!-- SmartAdmin RTL Support -->
    <![endif]-->

    {{--<script src="__PUBLIC__/js/jquery.js"></script>--}}


    <style>

        #main{
            /*max-width:540px;*/
            /*padding:0 0px;*/
            /*margin:0 auto;*/

        }
        p{
            /*text-indent: 2em; *//*em是相对单位，2em即现在一个字大小的两倍*/
            padding-left:0px;
        }
        p img{
            padding-left:0px;
        }
        /*手机预览*/
        .phone-preview {
            background-image: url(https://tms3.bytecdn.cn/dist/online/public/img/iphone_7_plus_a6f7b5c.png);
            background-size: cover;
            width: 362px;
            height: 738px;
            padding-top: 94px;
            float: left;
            margin: 10px;
            overflow: hidden;
        }
        .preview-article-content{
            width: 312px;
            height: 555px;
            background-color: #1b1b1b;
            overflow: hidden;
            margin-left: 25px;
            padding-top: 90px;
            position: relative;
        }
        .preview-article-content img{
            /*width: 100%;*/
        }
        .phone-des{
            display: inline-block;
            width: 100%;
            height: 180px;
            position: absolute;
            left: 0;
            bottom: 0;
            background: rgba(27,27,27,.7);
        }
        .phone-des-recommend{
            display: inline-block;
            width: 100%;
            height: 120px;
            position: absolute;
            left: 0;
            bottom: 0;
            background: rgba(27,27,27,.7);
        }
        .goods-title{
            margin: 10px 15px 12px;
            height: 32px;
            line-height: 32px;
            overflow: hidden;
            color: #fff;
            font-size: 18px;
        }
        .tt-des{
            color: #cacaca;
            font-size: 16px;
            line-height: 22px;
            max-height: 178px;
            word-break: break-all;
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow-x: hidden;
            margin-left: 15px;
        }

    </style>

</head>
<body  style=" margin:0 auto; ">
<div id="app" v-cloak>
    <!--max-height:500px;width:524px;-->
    <div class="wrap js-check-wrap pl10" id="main" style="margin-left: 0">
        <!--width:524px;-->
        <section id="widget-grid" style="margin:0 auto;text-align:left;border:none;"  >
            <article class="col-xs-24 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable" style=" margin:0 auto;border:none;">
                <div class="jarviswidget jarviswidget-color-darken " data-widget-editbutton="false" role="widget" style=" margin:0 auto;border-right: none;">
                    <notempty name="threePics">
                        <div  class="phone-preview" >
                            <div class="preview-article-content" >
                                    {{--<img  style='max-width:312px;' >--}}
                                <div  style="max-width:312px;border:1px solid;background-color: white;">
                                    <div style="width: 100%">
                                        <img src="{{ URL::asset('images/headimg.png') }}"/>
                                    </div>
                                    <div style="width: 90%;font-size: 12px;margin:0 auto">
                                        <strong>
                                            @{{ title }}
                                        </strong>
                                    </div>
                                    <br/>
                                    <div style="text-align: center">
                                        {{--<div v-for="(item,index) in items" style="width: 33%;display: inline-block;padding-left: 3px">--}}
                                            {{--<span v-if="index < 3">--}}
                                                {{--<img :src="item.goodsDatas.main_pic" style='max-width: 100%;' >--}}
                                            {{--</span>--}}
                                        {{--</div>--}}

                                        <div v-if="items.length < 3">
                                            <div v-for="(item,index) in items" style="width: 33%;display: inline-block;padding-left: 3px">
                                                <span v-if="index < 3">
                                                    <img :src="item.goodsDatas.main_pic" style='max-width: 100%;' >
                                                </span>

                                            </div>
                                        </div>
                                        <div v-else>
                                            <div  style="width: 33%;float: left;padding-left: 3px">
                                                <img :src="items[0].goodsDatas.main_pic" style='max-width: 100%;' >
                                            </div>
                                            <div  style="width: 33%;float: left;padding-left: 3px">
                                                <img :src="items[0].goodsDatas.sub_pic" style='max-width: 100%;' >
                                            </div>
                                            <div  style="width: 33%;float: left;padding-left: 3px">
                                                <img :src="items[1].goodsDatas.main_pic" style='max-width: 100%;' >
                                            </div>
                                        </div>

                                    </div>
                                    <div style="clear:both;"></div>
                                    <div style="width: 100%">
                                        <img src="{{ URL::asset('images/footerimg.png') }}"/>
                                    </div>


                                </div>
                                <div class="phone-des-recommend" >
                                    <p class="goods-title">
                                    </p>

                                    <p class="tt-des" style="height:65px;text-overflow: ellipsis;overflow: hidden;margin: auto">
                                    </p>

                                </div>
                                <div style="clear:both;"></div>

                            </div>
                        </div>

                        <div class="phone-preview">
                            <div class="preview-article-content" >
                                {{--<img  style='max-width:312px;' >--}}
                                <div  style="max-width:312px;border:1px solid;background-color: white;">
                                    <div style="width: 100%">
                                        <img src="{{ URL::asset('images/headimg.png') }}"/>
                                    </div>
                                    <div style="width: 90%;font-size: 12px;margin:0 auto">
                                        <strong>
                                            @{{ title }}
                                        </strong>
                                    </div>
                                    <br/>
                                    <div style="text-align: center">
                                        {{--<div v-for="(item,index) in items" style="width: 33%;display: inline-block;padding-left: 3px">--}}
                                        {{--<span v-if="index < 3">--}}
                                        {{--<img :src="item.goodsDatas.main_pic" style='max-width: 100%;' >--}}
                                        {{--</span>--}}
                                        {{--</div>--}}

                                        <div v-if="items.length < 3">
                                            <div v-for="(item,index) in items" style="width: 33%;display: inline-block;padding-left: 3px">
                                                <span v-if="index < 3">
                                                    <img :src="item.goodsDatas.main_pic" style='max-width: 100%;' >
                                                </span>

                                            </div>
                                        </div>

                                        <div v-else>
                                            <div  style="width: 65%;float: left;padding-left: 3px">
                                                <img :src="items[0].goodsDatas.main_pic" style='max-width: 100%;' >
                                            </div>
                                            <div  style="width: 33%;float: left;padding-left: 3px">
                                                <img :src="items[0].goodsDatas.sub_pic" style='max-width: 100%;' >
                                            </div>
                                            <div  style="width: 33%;float: left;padding-left: 3px">
                                                <img :src="items[1].goodsDatas.main_pic" style='max-width: 100%;' >
                                            </div>
                                        </div>

                                    </div>
                                    <div style="clear:both;"></div>
                                    <div style="width: 100%;">
                                        <img src="{{ URL::asset('images/footerimg.png') }}"/>
                                    </div>

                                </div>
                                <div class="phone-des-recommend" >
                                    <p class="goods-title">
                                    </p>

                                    <p class="tt-des" style="height:65px;text-overflow: ellipsis;overflow: hidden;margin: auto">
                                    </p>

                                </div>
                                <div style="clear:both;"></div>

                            </div>
                        </div>


                        <div id="thems2" class="phone-preview" >
                            <Carousel>
                                <volist v-for="data in items" name="dataPics" >
                                    <Carousel-item>
                                        <div class="preview-article-content">
                                            <p>
                                                <img :src="data.goodsDatas.main_pic" style='max-width:312px;' >
                                            </p>
                                            <div class="phone-des" >
                                                <p class="goods-title">
                                                    @{{ data.goodsDatas.title_recommend }}
                                                    {{--<if condition="$vo['image_type'] eq 1">--}}
                                                    {{--{$vo['title']}--}}
                                                    {{--</if>--}}
                                                </p>

                                                <p class="tt-des" style="height:65px;text-overflow: ellipsis;overflow: hidden;margin: auto">
                                                    @{{ data.goodsDatas.main_describe }}
                                                </p>

                                            </div>
                                            <div style="clear:both;"></div>

                                        </div>
                                    </Carousel-item>
                                    <Carousel-item>
                                        <div class="preview-article-content">
                                            <p>
                                                <img :src="data.goodsDatas.sub_pic" style='max-width:312px;' >
                                            </p>
                                            <div class="phone-des" >
                                                <p class="goods-title">

                                                </p>

                                                <p class="tt-des" style="height:65px;text-overflow: ellipsis;overflow: hidden;margin: auto">
                                                    @{{ data.goodsDatas.sub_describe }}
                                                </p>

                                            </div>
                                            <div style="clear:both;"></div>

                                        </div>
                                    </Carousel-item>
                                </volist>
                            </Carousel>
                        </div>

                        <div style="position: absolute;top:50px;right:100px;font-size: 20px">
                            <strong>切换预览模式</strong>
                            <i-switch size="large" @on-change="change">
                                <span slot="open">滑动</span>
                                <span slot="close">一览</span>
                            </i-switch>
                        </div>


                    </notempty>
                    <div id="thems1" class="widget-body mt10"  style="min-height:0px;padding-bottom: 5px;float:left;border-right: none;border-left:none;">
                        <div class="widget-body no-padding">
                            <div  style="overflow-x:hidden;overflow-y:hidden;text-align:left;">
                                <div style="margin:20px auto;text-align: center;font-size:14px;font-weight: bold;">
                                    {{--@{{ title }}--}}
                                </div>

                                <div >
                                    <volist  v-for="data in items" name="dataPics" >
                                        <div class="phone-preview">
                                            <div class="preview-article-content">
                                                <p>
                                                    <img :src="data.goodsDatas.main_pic" style='max-width:312px;' >
                                                </p>
                                                <div class="phone-des" >
                                                    <p class="goods-title">
                                                        @{{ data.goodsDatas.title_recommend }}
                                                        {{--<if condition="$vo['image_type'] eq 1">--}}
                                                        {{--{$vo['title']}--}}
                                                        {{--</if>--}}
                                                    </p>

                                                    <p class="tt-des" style="height:65px;text-overflow: ellipsis;overflow: hidden;margin: auto">
                                                        @{{ data.goodsDatas.main_describe }}
                                                    </p>

                                                </div>
                                                <div style="clear:both;"></div>

                                            </div>
                                        </div>

                                        <div class="phone-preview">
                                            <div class="preview-article-content">
                                                <p>
                                                    <img :src="data.goodsDatas.sub_pic" style='max-width:312px;' >
                                                </p>
                                                <div class="phone-des" >
                                                    <p class="goods-title">

                                                    </p>

                                                    <p class="tt-des" style="height:65px;text-overflow: ellipsis;overflow: hidden;margin: auto">
                                                        @{{ data.goodsDatas.sub_describe }}
                                                    </p>

                                                </div>
                                                <div style="clear:both;"></div>

                                            </div>
                                        </div>
                                    </volist>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </section>
    </div>
    <div style="clear:both;"></div>
    <div style="margin:0 auto;text-align: center;position: fixed;top:20px;right:50px">
        <label class="btn-group">
            {{--<a class="btn btn-sm btn-primary" href="javascript:returnUrl();" >--}}
                {{--<font style="color:white;"> 关闭 </font>--}}
            {{--</a>--}}
            <i-button type="primary" @click="closeUrl">关闭</i-button>
        </label>
    </div>

</div>

{{--<admintpl file="editor_footer" />--}}
<script type="text/javascript" src="{{ URL::asset('js/vue.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/iview.min.js') }}"></script>

<script>
//    resizeWindow();
//    function resizeWindow(){
//        var acticle_pos_div = $("#acticle_pos_div").height();
//        var winH = $(window).height()-150;
//
//        $("#main").css('max-height',winH+'px');
//        $("#main").css('height',winH+'px');
//    }
//    function returnUrl(){
//        window.close();
//    }

var type= '<?php echo $type;?>';

        let vm;
        vm = new Vue({
            el:'#app',
            data(){
                return{
                    title:'',
                    items:[],
                }
            },
            mounted() {
                document.getElementById("thems2").style.display="none";//隐藏
            },
            methods: {
                showPreview(){

                    if(type=='edit'){
                        vm.items=JSON.parse(localStorage.getItem('PreselectPicsGoodsData'));
                        vm.title=JSON.parse(localStorage.getItem('PrearticleTitle'));
                    }else{
                        vm.items=JSON.parse(localStorage.getItem('selectPicsGoodsData'));
                        vm.title=JSON.parse(localStorage.getItem('articleTitle'));
                    }

                    console.log(vm.items.length)
                },
                change (status) {
                    if(status==true){
//                        $('#thems2').show();
//                        $('#thems1').hide();
                        document.getElementById("thems1").style.display="none";//隐藏
                        document.getElementById("thems2").style.display="block";//显示
                    }else{
//                        $('#thems2').hide();
//                        $('#thems1').show();
                        document.getElementById("thems2").style.display="none";//隐藏
                        document.getElementById("thems1").style.display="block";//显示
                    }
                   // this.$Message.info('开关状态：' + status);
                },
                closeUrl(){
                    window.opener=null;
                    window.open('','_self');
                    window.close();
                }
            }
        });
        vm.showPreview();

</script>
</body>
</html>