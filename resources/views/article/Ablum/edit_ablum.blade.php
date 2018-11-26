<div class="content-box" id="app" >
	<div class="content-box-left">
		<div class="form-group titleBox">
			<input type="hidden" id="article_id" value="{{$data['article_id'] or ''}}"/>
			{{--<input type="text" class="form-control" id="titleInp" value="{{$data['title'] or ''}}" class="titleInp" placeholder="请输入4～19个汉字的标题，结尾不能为句号或叹号">--}}
			{{--<span class="title_tip">0/19</span>--}}
		</div>
        <div style="overflow: hidden">
            <div class="tm_title">
                <input type="text" class="form-control" name="article_title"  value="{{$data['title'] or ''}}"
                       id="article_title" v-model="title"
                       placeholder="请输入8～30个字符的标题，结尾不能为句号或叹号" maxlength="100"
                       style="padding-left:0px;"/>

                <span style="color: green" class="tm_title_tip" v-if="titleNum <= 30">@{{ titleNum }}/30</span>
                <span style="color: red" class="tm_title_tip" v-else>@{{ titleNum }}/30</span>
            </div>
            <label class="tm_title_check">
                <a class="btn btn-primary title-check" @click="checkTitleRepetiveRate">检测标题重复率</a>
            </label>
        </div>
        <p :style="{ color: styleColor }" style="margin-left: 15px;">@{{ hint }}</p>
        <p :style="{ color: repetiveColor }" style="margin-left: 15px;">@{{ repetitionHint }}</p>


		<div class="firstImg_tm">
			<div class="firstImgBox_tm" style="display: none"></div>
			<img src="{{$data['face_image']}}" class="headImg" data-edit="1">
			<button type="button" class="btn btn-primary btn-sm edit_img_first">
				<span class="glyphicon glyphicon-pencil">修改导图</span>
			</button>
		</div>

		<div class="leadsBox">
			<textarea class="form-control leads" rows="3" placeholder="请输入导语">{{$data['desc'] or ''}}</textarea>
            <p class="findSensitive" style="color: red;"></p>
			{{--<span class="leads_tip">0/100</span>--}}
		</div>

		<div>
            <i-select v-model="defaultTem" style="width:200px" @on-change="changeTem">
                <i-option v-for="item in tem" :value="item.value" :key="item.label" @mouseover.native="showTem(item.value)" @mouseout.native="removeTem">@{{ item.label }}</i-option>
            </i-select>
			<a class="btn" >
				<goods-card @goods-select="goodsSelect"></goods-card>
			</a>

			<a v-if="goodsCardNum > 20">
				产品卡数量:<span  style="color: red" >@{{ goodsCardNum }}</span>
			</a>
			<a v-else>
				产品卡数量:<span  style="color: green" >@{{ goodsCardNum }}</span>
			</a>

			<button type="button" class="btn btn-primary lineBtn">分割线选择</button>
			<span class="lineBox" style="vertical-align: middle"><img src="http://p3a.pstatp.com/large/1f7700011f8c20db3b29"></span>
		</div>
		<div id="sortable">
			@if(!empty($data['content']))
				@foreach($data['content'] as $k=>$v)
					@if($v['detail_type'] == 1)
						<div class="IntSingle" data-id="{{$v['product_id']}}">
							<p class="IntHead">段落导语<span class="delBtn">X</span></p>
							<div class="IntSingleBox">
								<div class="textareaBox">
									<textarea class="form-control textareaDes" rows="2" placeholder="请输入导语">{{$v['describe'] or ''}}</textarea>
                                    <p class="des_recommend" style="margin: 6px 0 0 10px;">{{$v['describe'] or ''}}</p>
								</div>

                                <button type="button" class="btn btn-primary changeDesBtn" style="margin-bottom: 10px">
                                    <span class="glyphicon glyphicon-refresh"></span>
                                </button>
                                <button type="button" class="btn btn-primary insertDesBtn" style="margin-bottom: 10px;margin-left: 10px">插入</button><br>
								<span class="change_des_tip">
									<span class="cur_des"></span>-<span class="all_des"></span>
								</span>
                                <p class="findSensitive" style="color: red;"></p>
							</div>
						</div>
					@elseif($v['detail_type'] == 2)
						<div class="IntSingle" data-id="{{$v['product_id']}}">
							<p class="IntHead">段落图片<span class="delBtn">X</span></p>
                            <div class="ul_img_box" style="display: none"></div>
							<div class="IntContent">
								<img class="imgSingle" src="{{$v['image'] or ''}}"/>
								<button type="button" class="btn btn-primary btn-sm edit_img_btn">
									<span class="glyphicon glyphicon-pencil"></span>
								</button>

							</div>
						</div>
					@elseif($v['detail_type'] == 4)
						<div class="IntSingle" data-id="{{$v['product_id']}}">
							<p class="IntHead">产品卡<span class="delBtn">X</span></p>
							<div class="IntContent">
								<div class="ul_img_box" style="display: none"></div>
								<div class="div_left"><img src="{{$v['image'] or ''}}" class="goods_img"/><span class="edit_img">修改图片</span></div>
								<div class="div_center">

                                    <div><textarea rows="2" class="product_title">{{$v['title'] or ''}}</textarea></div>
                                    <div>
                                        <a href="{{$v['goods_url'] or ''}}" target="_blank">{{$v['title'] or ''}}</a>
                                    </div>

									<div><span>￥</span><span class="price">{{$v['price'] or ''}}</span></div>
									<div><span class="shop_name">{{$v['shop_name'] or ''}}</span></div>
								</div>
                                <button type="button" class="btn btn-primary changeTitleBtn" style="margin-bottom: 10px">
                                    <span class="glyphicon glyphicon-refresh"></span>
                                    </button>
                                <button type="button" class="btn btn-primary insertTitleBtn" style="margin-bottom: 10px;margin-left: 10px">插入</button><br>
                                <span class="change_title_tip">
                                    <span class="cur_title"></span>-<span class="all_title"></span>
                                </span>
                                <p class="findSensitive" style="color: red;"></p>

							</div>
						</div>
					@elseif($v['detail_type'] == 5)
						<div class="IntSingle" style="height: 94px" data-id="0">
							<p class="IntHead">分割线<span class="delBtn">X</span></p>
							<div class="IntContent">
								<img class="lineImgSin" src="{{$v['image'] or ''}}">
							</div>
						</div>
					@endif
				@endforeach

			@endif
		</div>


	</div>
	<div class="content-box-right">
		<div class="saveBtnBox">
			{{ csrf_field()}}
            <a class="location" href="" style="display: none">定位</a>
            <button type="button" class="btn btn-primary clearSensitiveBtn" @click="clearSensitive">清除敏感词</button>
			<button type="button" class="btn btn-primary commitBtn">提交审核</button>
			<button type="button" class="btn btn-default timingPublishBtn_tm" data-timing="0" @click="setPlanTimemodal = true">定时发布</button>
			<button type="button" class="btn btn-default previewBtn_tm">预览</button>
			<button type="button" class="btn btn-default draftBtn_tm">存草稿</button>
		</div>
		<div class="refresh-preview">
			<div class="preview-article-content">
				<div class="tt-title"></div>
				<div class="tt-first-img"></div>
				<div class="tt-leads"></div>
				<div class="tt-content"></div>
			</div>
			<div class="refreshBtn_tm">
				<button type="button" class="btn btn-primary btn-xs">
					<span class="glyphicon glyphicon-refresh">刷新</span>
				</button>
			</div>
			<div class="bg-white"></div>
		</div>
	</div>
    <modal
            title="设置定时发布时间"
            v-model="setPlanTimemodal"
            ok-text="确定"
            @on-ok="doPulishPlanTime"
            class-name="vertical-center-modal">
        <Date-picker id="planTime" type="datetime"  placeholder="选择日期和时间" @on-change="selectDate" style="width: 200px"></Date-picker>
    </modal>
</div>


{{--拖拽插件--}}
<script src="{{ asset('lib/Sortable.min.js') }}"></script>
<script src="{{ asset('lib/vuedraggable.min.js') }}"></script>

@include('vue.vue_components.goods_card.goodsCard');


<script data-exec-on-popstate>
    //拖拽
    Vue.component('draggable');
    let vm;
    $(function () {

        vm = new Vue({
            el:'#app',
            store, // 挂载store
            data(){
                return{

                    title: $('#article_title').val(), // 标题
                    titleNum:$('#article_title').val().length,
                    goodsCardNum:0,//产品卡数量
                    titleStatus:false,//检测标题重复率
                    defaultTem: '',
                    temLen:0,
                    tem:[],
                    curTem:'',
                    titleStatus:false,//检测标题重复率
                    data:[],
                    repetitionHint:'',
                    repetiveColor:'green',
                    hint: '', // 敏感词、中文、特殊符号提示语句
                    styleColor: 'red', // 上一条语句样式
                    sensitiveWord: [], // 敏感词数组
                    sensitiveCon:[],
                    result:false,
                    planTime:'',//定时发布时间
                    setPlanTimemodal:false,
                    doPublicPlanTime:''//转换后确定的定时发布时间

                }

            },

            methods: {
                selectDate(v,f){
                    console.log('selectDate');
                    console.log(v);
                    console.log(f);
                    vm.planTime=v;
                },
                //定时发布
                doPulishPlanTime(){
                    vm.setPlanTimemodal=false;
                    if(vm.planTime!=''){
                        var obj;
                        var title=$('#article_title').val();
                        var leads=$('.leads').val();

                        var count=$('.textareaDes').length;
                        var arTcontent='';
                        if(count>0){
                            for (var i=0;i<count;i++){
                                arTcontent+=$('.textareaDes').eq(i).val();
                            }
                            arTcontent += leads;
                            if(arTcontent.length<500){
                                layer.msg('文章内容不能小于500字');
                                return;
                            }
                            var sensitiveCon=localStorage.getItem('sensitiveCon');
                            sensitiveCon=sensitiveCon.split(',');
                            for (var k=0;k<count;k++){
                                var des=$('.textareaDes').eq(k).val();
                                for(var i = 0; i< sensitiveCon.length; i++){
                                    if(des.indexOf(sensitiveCon[i]) != -1){
                                        $('.findSensitive').eq(k).text('发现敏感词【'+sensitiveCon[i]+'】');
                                        $('.findSensitive').eq(k).parents('.IntSingle').attr('id','findSen');
                                        $('.location').attr('href','#findSen');
                                        $('.location')[0].click();
                                        $('.findSensitive').eq(k).parents('.IntSingle').attr('id','');
                                        return;
                                        // des=des.replace(sensitiveCon[i],'');
                                        // $('.textareaDes').eq(k).val(des);
                                    }
                                }
                            }
                        }

                        if(title==''){
                            layer.msg('请填写标题');
                            return;
                        }
                        else if (title.length<6){
                            layer.msg('标题不能少于6个字');
                            return;
                        }
                        else if (title.length>30){
                            layer.msg('标题不能多于30个字');
                            return;
                        }

                        var firstImg='';
                        if($('.headImg').attr('data-edit')=='1'){
                            firstImg=$('.headImg').attr('src');
                        }
                        else{
                            layer.msg('请添加导图');
                            return;
                        }
                        if(leads==''){
                            layer.msg('请填写导语');
                            return;
                        }
                        // else if (leads.length<10){
                        //     layer.msg('导语不能少于10个字');
                        //     $draftBtn.css({'cursor':'pointer'});
                        //     return;
                        // }
                        // else if (leads.length>100){
                        //     layer.msg('导语不能多于100个字');
                        //     $draftBtn.css({'cursor':'pointer'});
                        //     return;
                        // }
                        var len=$('#sortable .IntSingle').length;
                        var content=[];
                        for (var i=0;i<len;i++){
                            var single;
                            var addType=$('#sortable .IntSingle:eq('+i+') .IntHead').text();
                            var product_id=$('#sortable .IntSingle:eq('+i+')').attr('data-id');
                            if(addType.indexOf('图片')!=-1){
                                single={
                                    product_id:product_id,
                                    type:2,
                                    img:$('#sortable .IntSingle:eq('+i+') .imgSingle').attr('src'),
                                    describe:'',
                                    link:'',
                                    price:'',
                                    goods_name:'',
                                    shop_name:''

                                }
                            }
                            else if(addType.indexOf('分割线')!=-1){
                                single={
                                    product_id:product_id,
                                    type:5,
                                    img:$('#sortable .IntSingle:eq('+i+') img').attr('src'),
                                    describe:'',
                                    link:'',
                                    price:'',
                                    goods_name:'',
                                    shop_name:''

                                }
                            }
                            else if(addType.indexOf('导语')!=-1){
                                var describe=$('#sortable .IntSingle:eq('+i+') textarea').val();
                                if(describe==''){
                                    layer.msg('请填写段落导语');
                                    return;
                                }
                                else if (describe.length<10){
                                    layer.msg('段落导语不能少于10个字');
                                    return;
                                }
                                // else if (describe.length>100){
                                //     layer.msg('段落导语不能多于100个字');
                                //     $draftBtn.css({'cursor':'pointer'});
                                //     return;
                                // }
                                single={
                                    product_id:product_id,
                                    type:1,
                                    img:'',
                                    describe:describe,
                                    link:'',
                                    price:'',
                                    goods_name:'',
                                    shop_name:''

                                }
                            }
                            else if(addType.indexOf('产品卡')!=-1){
                                single={
                                    product_id:product_id,
                                    type:4,
                                    img:$('#sortable .IntSingle:eq('+i+') .div_left img').attr('src'),
                                    describe:'',
                                    link:$('#sortable .IntSingle:eq('+i+') a').attr('href'),
                                    price:$('#sortable .IntSingle:eq('+i+') .price').text(),
                                    goods_name:$('#sortable .IntSingle:eq('+i+') a').text(),
                                    shop_name:$('#sortable .IntSingle:eq('+i+') .shop_name').text()
                                }
                            }
                            content.push(single);
                        }
                        if($('#article_id').length>0){
                            var article_id=$('#article_id').val();
                            obj={
                                // saveType      3是发布   2是存草稿
                                // articleType  2是专辑   6是图集
                                // platform    1是头条   0是放心购
                                id:article_id,
                                publish_time:vm.planTime,
                                articleType:2,
                                saveType:3,
                                title:title,
                                firstImg:firstImg,
                                leads:leads,
                                content:content
                            };
                        }
                        else{
                            obj={
                                publish_time:vm.planTime,
                                articleType:2,
                                saveType:3,
                                title:title,
                                firstImg:firstImg,
                                leads:leads,
                                content:content
                            };
                        }

                        console.log(obj);
                        $('.timingPublishBtn_tm').siblings('button').prop('disabled', true);
                        $('.timingPublishBtn_tm').prop('disabled', true);
                        $.post(
                            '/admin/article/save_article',
                            {
                                data:JSON.stringify(obj),
                                _token :  $("input[name='_token']").val()
                            },
                            function(res) {
                                var res=JSON.parse(res);
                                if(res.status==0){
                                    layer.msg('定时发布成功');
                                    $('.timingPublishBtn_tm').siblings('button').prop('disabled', false);
                                    $('.timingPublishBtn_tm').prop('disabled', false);
                                    localStorage.removeItem('timingTmAlbum');
                                    localStorage.removeItem('timingTmTitle');
                                    localStorage.removeItem('timingTmLeads');
                                    localStorage.removeItem('timingTmImg');
                                    window.location.href='/admin/articles';

                                }
                                else{
                                    layer.msg('定时发布失败');
                                    $('.timingPublishBtn_tm').siblings('button').prop('disabled', false);
                                    $('.timingPublishBtn_tm').prop('disabled', false);
                                }
                                setTimeout(function () {
                                    $('.timingPublishBtn_tm').siblings('button').prop('disabled', false);
                                    $('.timingPublishBtn_tm').prop('disabled', false);
                                },10000)
                            }
                        )

                    }


                },

                goodsSelect(arr){
                    console.log(arr.length);
                    if(arr.length>0){
                        var selectPro=arr.length+vm.goodsCardNum;
                        if(selectPro>5 && selectPro<21){

                            var goods_id='';
                            var new_goods=0;
                            var repeatGoods=0;
                            if($('.firstImg_tm').attr('data-ids')!=undefined){
                                var beforeIds=$('.firstImg_tm').attr('data-ids');
                                var id_arr=beforeIds.split(',');
                                for(var i=0;i<arr.length;i++){
                                    var is_new=1;
                                    for(var k=0;k<id_arr.length;k++){
                                        if(arr[i].goods_id==id_arr[k]){
                                            is_new=0;

                                        }
                                    }
                                    if(is_new==1){
                                        goods_id+=arr[i].goods_id+',';
                                        new_goods++;
                                    }
                                    else {
                                        repeatGoods++;
                                    }
                                }
                                vm.goodsCardNum=new_goods+vm.goodsCardNum;

                                beforeIds=beforeIds+goods_id;
                                $('.firstImg_tm').attr('data-ids',beforeIds);
                            }
                            if(repeatGoods!=arr.length){
                                this.$Spin.show();
                                var that=this;
                                $.get(
                                    '/admin/article/select_goods_data',
                                    {
                                        select_product_id: goods_id,
                                        type:1
                                    },
                                    function (res) {
                                        var res=JSON.parse(res);
                                        console.log(res.DATA.length);

                                        $.get(
                                            'http://baseinfo.youdnr.com/api/goods/get_goods_data_v2',
                                            {
                                                goods_id_arr: goods_id.split(','),
                                            },
                                            function (a) {
                                                console.log('a.code');
                                                console.log(a.data.length);
                                                var curTemArr=vm.curTem.split(',');
                                                console.log(curTemArr.length);
                                                console.log(curTemArr);
                                                if($('.all_pro_ul').length==0){
                                                    $('.firstImgBox_tm').append('<p>已选产品: </p><ul class="all_pro_ul"></ul><div class="all_pro_div"><span>产品图片: </span></div>');
                                                }
                                                for(var k=0;k<a.data.length;k++){
                                                    var li='<li><img src="'+a.data[k].image+'"></li>';
                                                    $('.all_pro_ul').append(li);
                                                    var ul_sin='<ul class="ul_sin">';
                                                    for(var z=0;z<res.DATA[k].images.length;z++){
                                                        ul_sin+='<li><img src="'+res.DATA[k].images[z]+'"></li>';
                                                    }
                                                    ul_sin +='</ul>';
                                                    $('.all_pro_div').append(ul_sin);
                                                }
                                                for(var k=0;k<a.data.length;){

                                                    var lineSrc=$('.lineBox img').attr('src');
                                                    var line='<div class="IntSingle" style="height: 94px" data-id="0">' +
                                                        '<p class="IntHead">分割线<span class="delBtn">X</span></p>' +
                                                        '<div class="IntContent"><img class="lineImgSin" src="'+lineSrc+'">' +
                                                        '</div>'+
                                                        '</div>';
                                                    $('#sortable').append(line);
                                                    for(var j=0;j<curTemArr.length;j++){
                                                        var q=k;
                                                        var html='';
                                                        if(curTemArr[j].indexOf('p2')!=-1){
                                                            q++;
                                                        }
                                                        if(q<a.data.length){
                                                            var ul='<ul class="img_ul">';
                                                            for(var m=0;m<res.DATA[q].images.length;m++){
                                                                if(i == 0){
                                                                    ul += '<li class="img_active"><img src="'+res.DATA[q].images[m]+'" class="tb_goods_imgs" /></li>'
                                                                }
                                                                else{
                                                                    ul += '<li><img src="'+res.DATA[q].images[m]+'" class="tb_goods_imgs img-rounded" alt="Cinque Terre"/></li>'
                                                                }
                                                            }
                                                            ul +='</ul>';
                                                        }
                                                        if(curTemArr[j].indexOf('t')!=-1){
                                                            var img='';
                                                            var id=res.DATA[k].product_id;
                                                            if(curTemArr[j].indexOf('t1')!=-1){
                                                                if(curTemArr[j].indexOf('p2')!=-1){
                                                                    img=res.DATA[k+1].images[2];
                                                                    id=res.DATA[k+1].product_id;
                                                                }
                                                                else{
                                                                    img=res.DATA[k].images[2];
                                                                }

                                                            }
                                                            else{
                                                                if(curTemArr[j].indexOf('p2')!=-1){
                                                                    img=res.DATA[k+1].images[1];
                                                                    id=res.DATA[k+1].product_id;
                                                                }
                                                                else{
                                                                    img=res.DATA[k].images[1];
                                                                }
                                                            }
                                                            html='<div class="IntSingle" data-id="'+id+'">' +
                                                                '<p class="IntHead">段落图片<span class="delBtn">X</span></p>' +
                                                                '<div class="ul_img_box" style="display: none">'+ul+'</div>'+
                                                                '<div class="IntContent">' +
                                                                '<img class="imgSingle" src="' + img + '"/>' +
                                                                '<button type="button" class="btn btn-primary btn-sm edit_img_btn">\n' +
                                                                '  <span class="glyphicon glyphicon-pencil"></span>' +
                                                                '</button>'+
                                                                // '<button type="button" class="btn btn-primary btn-sm cutImgBtn">\n' +
                                                                // '  <span class="glyphicon glyphicon-scissors"></span>' +
                                                                // '</button>'+
                                                                '</div>'+
                                                                '</div>';
                                                        }
                                                        else if(curTemArr[j].indexOf('m')!=-1){
                                                            var des='';
                                                            var des_rec='';
                                                            var id=res.DATA[k].product_id;
                                                            if(curTemArr[j].indexOf('m1')!=-1){
                                                                if(curTemArr[j].indexOf('p2')!=-1){
                                                                    des=res.DATA[k+1].main_describe;
                                                                    des_rec=res.DATA[k+1].main_describe_recommend;
                                                                    id=res.DATA[k+1].product_id;
                                                                }
                                                                else{
                                                                    des=res.DATA[k].main_describe;
                                                                    des_rec=res.DATA[k].main_describe_recommend;
                                                                }
                                                            }
                                                            else{
                                                                if(curTemArr[j].indexOf('p2')!=-1){
                                                                    des=res.DATA[k+1].sub_describe;
                                                                    id=res.DATA[k+1].product_id;
                                                                    des_rec=res.DATA[k+1].sub_describe_recommend;
                                                                }
                                                                else{
                                                                    des=res.DATA[k].sub_describe;
                                                                    des_rec=res.DATA[k].sub_describe_recommend;
                                                                }

                                                            }
                                                            html='<div class="IntSingle" data-id="'+id+'">' +
                                                                '<p class="IntHead">段落导语<span class="delBtn">X</span></p>' +
                                                                '<div class="IntSingleBox">' +
                                                                '<div class="textareaBox">' +
                                                                '<textarea class="form-control textareaDes" rows="3" placeholder="请输入段落导语">' + des + '</textarea>' +
                                                                '<p class="des_recommend" style="margin: 6px 0 0 10px;">' + des_rec + '</p>' +
                                                                // '<span class="des_tip">0/100</span>' +
                                                                '</div>' +
                                                                '<button type="button" class="btn btn-primary changeDesBtn" style="margin-bottom: 10px">' +
                                                                '<span class="glyphicon glyphicon-refresh"></span>' +
                                                                '</button>' +
                                                                '<button type="button" class="btn btn-primary insertDesBtn" style="margin-bottom: 10px;margin-left: 10px">插入</button><br>' +
                                                                '<span class="change_des_tip">' +
                                                                '<span class="cur_des"></span>-<span class="all_des"></span>' +
                                                                '</span>' +
                                                                '<p class="findSensitive" style="color: red;"></p>' +
                                                                '</div>'+
                                                                '</div>';
                                                        }
                                                        else if(curTemArr[j].indexOf('car')!=-1 && q<a.data.length){
                                                            var title=a.data[q].title;
                                                            if(title.length>20){
                                                                title=title.substring(0,20);
                                                            }
                                                            html= '<div class="IntSingle" data-id="'+res.DATA[q].product_id+'">' +
                                                                '<p class="IntHead">产品卡<span class="delBtn">X</span></p>' +
                                                                '<div class="IntContent">' +
                                                                '<div class="ul_img_box" style="display: none">'+ul+'</div>'+
                                                                '<div class="div_left"><img src="'+a.data[q].image+'" class="goods_img"/><span class="edit_img">修改图片</span></div>'+
                                                                '<div class="div_center">' +
                                                                '<div><textarea rows="2" class="product_title">'+title+'</textarea></div>'+
                                                                '<div><a href="'+a.data[q].goods_url+'" target="_blank">'+title+'</a></div>'+
                                                                '<div><span>￥</span><span class="price">'+a.data[q].price+'</span></div>'+
                                                                '<div><span class="shop_name">'+a.data[q].shop_name+'</span></div>'+
                                                                '</div>'+
                                                                '<button type="button" class="btn btn-primary changeTitleBtn" style="margin-bottom: 10px">' +
                                                                '<span class="glyphicon glyphicon-refresh"></span>' +
                                                                '</button>' +
                                                                '<button type="button" class="btn btn-primary insertTitleBtn" style="margin-bottom: 10px;margin-left: 10px">插入</button><br>' +
                                                                '<span class="change_title_tip">' +
                                                                '<span class="cur_title"></span>-<span class="all_title"></span>' +
                                                                '</span>' +
                                                                '<p class="findSensitive" style="color: red;"></p>' +
                                                                '</div>'+
                                                                '</div>';
                                                        }
                                                        $('#sortable').append(html);

                                                    }

                                                    if(vm.curTem.indexOf('p2')!=-1){
                                                        k+=2;
                                                    }
                                                    else{
                                                        k++;
                                                    }
                                                }

                                                $( "#sortable" ).sortable();
                                                $( "#sortable" ).disableSelection();
                                                that.$Spin.hide();
                                                if(repeatGoods>0){
                                                    layer.msg('自动过滤重复产品'+ repeatGoods +'个')
                                                }
                                            }
                                        );
                                    }
                                )
                            }
                            else{
                                layer.msg('您选择的'+ repeatGoods +'个产品都是重复的哦')
                            }
                        }
                        else{
                            layer.msg('产品总数应在6-20之间')
                        }
                    }
                },
                getTemplate(){
                    $.get(
                        '/admin/article/get_template_list',
                        {
                            platform:2,
                            _token:LA.token
                        },
                        function (res) {
                            var data=JSON.parse(res);

                            vm.defaultTem=data.data[0].template;
                            vm.curTem=data.data[0].template;
                            vm.temLen=data.data.length;
                            for(var i=0;i<vm.temLen;i++){
                                var obj={
                                    value: data.data[i].template,
                                    label: data.data[i].template_name
                                };
                                vm.tem.push(obj);
                            }
                            console.log(vm.tem);
                            console.log(vm.defaultTem);
                        }
                    )
                },
                changeTem(v){
                    console.log(v);
                    vm.curTem=v;
                },
                showTem(v){
                    var curTemArr=v.split(',');
                    console.log(curTemArr.length);
                    var html='';
                    var p1t1='https://p3a.pstatp.com/obj/temai/18f3e290b28dbd4ddb9fd5386f5918e3f77b0fe8www800-800';
                    var p1t2='https://p3a.pstatp.com/obj/temai/06caa0b31a489889e21911cbb0b655c62828d7d6www800-800';
                    var p1t3='https://p3a.pstatp.com/obj/temai/d60d133b496590eb02d8aa4a3d9308da749b6daewww800-800';
                    var p2t1='https://p3a.pstatp.com/obj/temai/1c704b3f88dc4cc91a23293cb18c218d017eec01www800-800';
                    var p2t2='https://p3a.pstatp.com/obj/temai/e3ffb157f3e33e22a46559667599528342dc32cbwww800-800';
                    var p2t3='https://p3a.pstatp.com/obj/temai/9523eb722ee4f8c9fe4c8cb3f4900a943f342645www800-800';
                    for(var j=0;j<curTemArr.length;j++) {

                        if (curTemArr[j].indexOf('t') != -1) {
                            var src='';
                            if(curTemArr[j].indexOf('p1_t1') != -1){
                                src=p1t1;
                            }
                            else if(curTemArr[j].indexOf('p1_t2') != -1){
                                src=p1t2;
                            }
                            else if(curTemArr[j].indexOf('p2_t1') != -1){
                                src=p2t1;
                            }
                            else if(curTemArr[j].indexOf('p2_t2') != -1){
                                src=p2t2;
                            }
                            html+='<p style="text-align: center; margin-bottom: 10px;"><img src="'+src+'"></p>'
                        }
                        else if (curTemArr[j].indexOf('m') != -1) {
                            html+='<p style="margin-bottom: 10px;">麦兜：麻烦你，鱼丸粗面,校长：没有粗面<p>';
                        }
                        else if (curTemArr[j].indexOf('p') != -1) {
                            var src=p1t3;
                            if(curTemArr[j].indexOf('p2') != -1){
                                src=p2t3;
                            }

                            html+='<div style="overflow: hidden;margin-bottom: 10px;border: 1px solid #ccc;">' +
                                '<div style="float: left; margin-right: 10px">' +
                                '<img src="'+src+'">'+
                                '</div>' +
                                '<div style="float: left;">' +
                                '<p>产品标题：是吗？来碗鱼丸河粉吧</p>' +
                                '<p>￥160</p>' +
                                '<p>梦梦家女装</p>' +
                                '</div>' +
                                '</div>';
                        }
                    }
                    $('html body').append('<div class="showTem">'+html+'</div>')
                },
                removeTem(){
                    $('.showTem').remove();
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

                            if(res.data.length > 0){
                                var reg = /[\u4e00-\u9fa5]/g;
                                var title = that.title.match(reg).join('').split("");
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
                                if(repetitiveRate >= 80){
                                    that.repetitionHint = `搜索到标题：${rTitle}；重复率：${repetitiveRate}%`;
                                    that.repetiveColor = 'red';
                                }else{
//                       that.repetitionHint = `重复率：${repetitiveRate}%`;
                                    that.repetitionHint = `标题检测通过`;
                                    that.repetiveColor = 'green';
                                }

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
                        localStorage.setItem('sensitiveTitle',response.data);
                    })
                },
                //内容敏感词
                getSensitiveWordCon() {
                    var that = this;
                    axios.get("/admin/article/sensitive_word",{
                        params: {
                            type: 2,
                        }
                    }) .then(response => {
                        that.sensitiveCon = response.data;
                        localStorage.setItem('sensitiveCon',response.data);
                    })
                },
                clearSensitive(){
                    var leads=$('.leads').val();
                    for(var i = 0; i< this.sensitiveCon.length; i++){
                        if(leads.indexOf(this.sensitiveCon[i]) != -1){
                            leads=leads.replace(this.sensitiveCon[i],'');
                            $('.leads').val(leads);
                        }
                    }
                    var len=$('.textareaDes').length;
                    if(len>0){
                        for (var k=0;k<len;k++){
                            var des=$('.textareaDes').eq(k).val();
                            for(var i = 0; i< this.sensitiveCon.length; i++){
                                if(des.indexOf(this.sensitiveCon[i]) != -1){
                                    console.log(this.sensitiveCon[i]);
                                    des=des.replace(this.sensitiveCon[i],'');
                                    $('.textareaDes').eq(k).val(des);
                                }
                            }
                        }
                        $('.findSensitive').text('');
                    }
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
                        var ChineseLength = this.title.match(reg).join('').length;
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
                    }
                    console.log(this.hint);
                    console.log(this.styleColor);
                },
                getProCount(){
                    var proCount=0;
                    var c=$('#sortable .IntSingle').length;
                    var idArr='';
                    for (var i=0;i<c;i++){
                        var text=$('#sortable .IntSingle').eq(i).find('.IntHead').text();
                        if(text.indexOf('产品卡')!=-1){
                            proCount++;
                            idArr+=$('#sortable .IntSingle').eq(i).attr('data-id')+',';
                        }
                    }
                    $('.firstImg_tm').attr('data-ids',idArr);
                    vm.goodsCardNum=proCount;
                    $.get(
                        '/admin/article/select_goods_data',
                        {
                            select_product_id: idArr,
                        },
                        function (res) {
                            var res=JSON.parse(res);
                            console.log(res.DATA.length);
                            $('.firstImgBox_tm').append('<p>已选产品: </p><ul class="all_pro_ul"></ul><div class="all_pro_div"><span>产品图片: </span></div>');
                            for(var k=0;k<res.DATA.length;k++){
                                var li='<li><img src="'+res.DATA[k].images[0]+'"></li>';
                                $('.all_pro_ul').append(li);
                                var ul_sin='<ul class="ul_sin">';
                                for(var z=0;z<res.DATA[k].images.length;z++){
                                    ul_sin+='<li><img src="'+res.DATA[k].images[z]+'"></li>';
                                }
                                ul_sin +='</ul>';
                                $('.all_pro_div').append(ul_sin);
                            }
                        }
                    );

                },
                getCache(){
                    var title=localStorage.getItem('timingTmTitle');
                    var leads=localStorage.getItem('timingTmLeads');
                    var timingData=localStorage.getItem('timingTmAlbum');
                    if(timingData || title || leads){
                        layer.confirm('是否加载缓存的文章数据',function (index) {
                            if(timingData!=''){
                                $('#sortable').html(timingData);
                                $('#sortable').sortable();
                                $('#sortable').disableSelection();
                                var len=$('.insertTitleBtn').length;
                                vm.goodsCardNum=len;
                            }

                            if(title!='' && title != undefined && title != null){
                                $('#article_title').val(title);
                            }

                            if(leads!='' && img != undefined && img != null){
                                $('.leads').val(leads);
                            }

                            layer.close(index);
                        },function (index) {
                            localStorage.removeItem('timingToutiaoAlbum');
                            layer.close(index);
                        });
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
        vm.getTemplate();
        vm.getProCount();
        vm.getSensitiveWordCon();
        vm.getSensitiveWordTitle();

    });

    //jq部分

</script>

