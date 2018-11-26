var table='<table class="table table-bordered imgTable">'+
    '<thead>'+
    '<tr>'+
    '<th>选择</th>'+
    '<th>类型</th>'+
    '<th>内容</th>'+
    '<th>分类</th>'+
    '<th>来源</th>'+
    '<th>关键字</th>'+
    '</tr>'+
    '</thead>'+
    '<tbody>'+
    '</tbody>'+
    '</table>'+
    '<div class="loadingText" style="text-align: center; width: 100%; margin-top: 250px; height: 300px;">玩命加载中......</div>' +
    '<div class="pagination-box" style="margin:0 0 20px 10px;">' +
    '<div id="pagination"></div>' +
    '</div>' ;
var content='<section class="content">'+
    '<div class="box" style="border:0 none;">'+
    '<ul id="imgTab" class="nav nav-tabs">'+
    '<li class="active"><a href="#selectImg" data-toggle="tab">选择图片</a></li>'+
    '<li><a href="#uploadImg" data-toggle="tab">上传图片</a></li>'+
    '<li><a href="#pieceImg" data-toggle="tab">图片拼合</a></li>'+
    '</ul>'+
    '<div class="box-body">'+
    '<div class="tab-content">'+
    '<div class="tab-pane fade in active" id="selectImg">'+
    '<div class="imgSource">'+
    '<span>来源:</span>'+
    '<select class="selectStyle" id="data_source">'+
    '<option value="">全部</option>'+
    '<option value="淘宝">淘宝</option>'+
    '<option value="今日头条">今日头条</option>'+
    '<option value="裁剪图">裁剪图</option>'+
    '<option value="其他">其他</option>'+
    '</select>'+
    '<span style="margin-left: 16px">分类:</span>'+
    '<select class="selectStyle" id="oneUp">'+
    '<option value="">全部</option>'+
    '</select>'+
    '<select class="selectStyle" id="twoUp">'+
    '<option value="">全部</option>'+
    '</select>'+
    '<select class="selectStyle" id="threeUp">'+
    '<option value="">全部</option>'+
    '</select>'+
    '<span style="margin-left: 16px">关键字:</span>'+
    '<select class="selectStyle" id="key_type">'+
    '<option value="1">关键字</option>'+
    '<option value="2">标题</option>'+
    '</select>'+
    '<input type="text" placeholder="请输入关键字/标题" class="inputStyle keywords">'+
    '<button type="button" class="btn btn-primary btn-sm getImgBtn" style="margin-left: 16px">筛选</button>'+
    '</div>'+table+
    '</div>'+
    '<div class="tab-pane fade" id="uploadImg">'+
    '<div class="uploadImgModel">' +
    '<button type="button" class="btn btn-primary selImgBtn">选择图片</button>\n' +
    '<div class="head">\n' +
    '<img id="targetImg" />\n' +
    '<input type="file" id="fileImg" style="display: none;"/>\n' +
    '</div>' +
    '</div>'+
    '</div>'+
    '<div class="tab-pane fade" id="pieceImg">'+
    '<div class="pieceImgModel" id="imgsortable">' +
    '<div class="pieceImgBox">' +
    '<img id="pieceTargetImg1" />' +
    '<span class="upImg1">上传图片</span>'+
    '<span class="cutSelImage">裁剪图片</span>'+
    '<input type="file" id="pieceFileImg1" style="display: none;"/>' +
    '</div>'+
    '<div class="pieceImgBox">' +
    '<img id="pieceTargetImg2" />' +
    '<span class="upImg2">上传图片</span>'+
    '<span class="cutSelImage">裁剪图片</span>'+
    '<input type="file" id="pieceFileImg2" style="display: none;"/>' +
    '</div>'+
    '<div class="pieceImgBox">' +
    '<img id="pieceTargetImg3" />' +
    '<span class="upImg3">上传图片</span>'+
    '<span class="cutSelImage">裁剪图片</span>'+
    '<input type="file" id="pieceFileImg3" style="display: none;"/>' +
    '</div>'+
    '<button type="button" class="btn btn-primary pImgBtn">拼合</button>\n' +
    '<div class="previewBox">' +
    '<img id="previewImg" />' +
    '</div>'+
    '</div>'+
    '</div>'+
    '</div>'+
    '</div>'+
    '</div>';
var desData='<section class="content">'+
    '<div class="box" style="border:0 none;">'+
    '<div class="box-body">'+
    '<div id="imgTab" class="tab-content">'+
    '<div class="tab-pane fade in active" id="selectImg">'+
    '<div class="imgSource">'+
    '<span>来源:</span>'+
    '<select class="selectStyle" id="data_source">'+
    '<option value="">全部</option>'+
    '<option value="淘宝">淘宝</option>'+
    '<option value="今日头条">今日头条</option>'+
    '<option value="裁剪图">裁剪图</option>'+
    '<option value="其他">其他</option>'+
    '</select>'+
    '<span style="margin-left: 16px">分类:</span>'+
    '<select class="selectStyle" id="oneUp">'+
    '<option value="">全部</option>'+
    '</select>'+
    '<select class="selectStyle" id="twoUp">'+
    '<option value="">全部</option>'+
    '</select>'+
    '<select class="selectStyle" id="threeUp">'+
    '<option value="">全部</option>'+
    '</select>'+
    '<span style="margin-left: 16px">关键字:</span>'+
    '<select class="selectStyle" id="key_type">'+
    '<option value="1">关键字</option>'+
    '<option value="2">内容</option>'+
    '</select>'+
    '<input type="text" placeholder="请输入关键字/内容" class="inputStyle keywords">'+
    '<button type="button" class="btn btn-primary btn-sm searchDesBtn" style="margin-left: 16px">筛选</button>'+
    '</div>'+table+
    '</div>'+
    '</div>'+
    '</div>'+
    '</div>';


$(document).on('click','.addCover label',function () {
    var type=$(this).text().trim();
    if(type=='单图'){
        $('.addCover .oneImgBox').show();
        $('.addCover .threeImgBox').hide();
    }
    else{
        $('.addCover .threeImgBox').show();
        $('.addCover .oneImgBox').hide();
    }
});
//单图
$(document).on('click','.addCover .oneImgBox',function () {
    var dialogCover='<div class="dialogCover">'+
        '<button type="button" class="btn btn-primary selImgBtn">选择图片</button>' +
        '<button type="button" class="btn btn-success sureImgBtn">确定</button>' +
        '<button type="button" class="btn btn-warning closeImgBtn">取消</button>' +
        '<div class="head">' +
        '<img id="target" />' +
        '<input type="file" id="file" style="display: none;"/>' +
        '</div>' +
        '</div>';
    $('html body').append(dialogCover);

    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        $target = $('#target');
    if(typeof($('.addCover .myImg').attr('src'))!='undefined'){
        var addImg=$('.addCover .myImg').attr('src');
        $('#target').attr('src',addImg);
        preImg(addImg);
    }

    $('.dialogCover .sureImgBtn').click(function () {
        if(typeof($('#target').attr('src'))=="undefined"){
            layer.msg('请选择图片进行裁剪');
            return;
        }
        var img = new Image();
        img.src = $('#target').attr('src');
        var realWidth = img.width;
        var realHeight = img.height;

        var showWidth=$('#target').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#target').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);

        // 真实图片和显示图片的宽比  高比
        var ratio=realWidth/showWidth;

        var width=$('.dialogCover .jcrop-holder>div').css('width');
        if(width=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        width=width.split('px');
        width=parseInt(width[0])*ratio;
        var height=$('.dialogCover .jcrop-holder>div').css('height');
        if(height=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        height=height.split('px');
        height=parseInt(height[0])*ratio;
        var top=$('.dialogCover .jcrop-holder>div').css('top');
        top=top.split('px');
        top=0-parseInt(top[0])*ratio;
        var left=$('.dialogCover .jcrop-holder>div').css('left');
        left=left.split('px');
        left=0-parseInt(left[0])*ratio;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        canvas.width = width;
        canvas.height = height;
        img.onload = function() {
            this.width = realWidth;
            this.height = realHeight;
            ctx.drawImage(this, left, top, this.width, this.height);
            base64 = canvas.toDataURL('image/jpeg', 1);
            $('.addCover .oneImgBox img').attr('src',base64);
            $('.dialogCover').remove();
            $('.addCover .oneImgBox .ImgBox').css({'display':'none'});
        }
    });
    $('.dialogCover .closeImgBtn').click(function () {
        $('.dialogCover').remove();
    });
    $('.dialogCover .selImgBtn').click(function () {
        openBrowseImg()
    });
    $('.dialogCover #file').change(function(){
        changeFileImg()
    });
    //1.
    function openBrowseImg(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("file").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("file").dispatchEvent(a);
        }
    }

    //2、从 file 域获取 本地图片 url
    function getFileUrlImg(sourceId) {
        var url;
        if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
            url = document.getElementById(sourceId).value;
        } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Safari")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        }
        return url;
    }
    //选择文件事件
    function changeFileImg() {
        var url = getFileUrlImg("file");//根据id获取文件路径
        preImg(url);
        return false;
    }
    //3、将本地图片 显示到浏览器上
    function preImg(url) {
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }
        initTargetImg();
        var image = document.getElementById('target');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;
                if(realWidth<750||realHeight<422){
                    $target.hide();
                    layer.msg('请选择尺寸不小于750*422px的图片')
                    return;
                }
                else{
                    initJcropImg();
                }
            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(){
        $target.removeAttr("style");//清空上一次初始化设置的样式
        var showWidth=$('#target').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#target').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);
        //比例
        var minWidth=showWidth/(realWidth/750);
        var minHeight=minWidth/(750/422);
        $target.Jcrop({
            minSize:[minWidth,minHeight],
            aspectRatio: 750 / 422
        },function(){
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度
            jcrop_api = this;
        });
    }
    function initTargetImg(){
        $target.removeAttr("style");//清空上一次初始化设置的样式
        $target.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }
});

//补充封面图
$(document).on('click','.sup .oneImgBox',function () {
    var dialogCover='<div class="dialogCoverSup">'+
        '<button type="button" class="btn btn-primary selImgBtn">选择图片</button>' +
        '<button type="button" class="btn btn-success sureImgBtn">确定</button>' +
        '<button type="button" class="btn btn-warning closeImgBtn">取消</button>' +
        '<div class="head">' +
        '<img id="tarsup" />' +
        '<input type="file" id="filesup" style="display: none;"/>' +
        '</div>' +
        '</div>';
    $('html body').append(dialogCover);
    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        $tarsup = $('#tarsup');

    if(typeof($('.supCover .myImg').attr('src'))!='undefined'){
        var addImg=$('.supCover .myImg').attr('src');
        $('#tarsup').attr('src',addImg);
        preImgSup(addImg);
    }

    $('.dialogCoverSup .selImgBtn').click(function(){
        openBrowseSup()
    });
    $('.dialogCoverSup .sureImgBtn').click(function(){
        if(typeof($('#tarsup').attr('src'))=="undefined"){
            layer.msg('请选择图片进行裁剪');
            return;
        }
        var img = new Image();
        img.src = $('#tarsup').attr('src');
        var realWidth = img.width;
        var realHeight = img.height;

        var showWidth=$('#tarsup').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#tarsup').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);

        // 真实图片和显示图片的宽比  高比
        var ratio=realWidth/showWidth;

        var width=$('.dialogCoverSup .jcrop-holder>div').css('width');
        if(width=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        width=width.split('px');
        width=parseInt(width[0])*ratio;
        var height=$('.dialogCoverSup .jcrop-holder>div').css('height');
        if(height=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        height=height.split('px');
        height=parseInt(height[0])*ratio;
        var top=$('.dialogCoverSup .jcrop-holder>div').css('top');
        top=top.split('px');
        top=0-parseInt(top[0])*ratio;
        var left=$('.dialogCoverSup .jcrop-holder>div').css('left');
        left=left.split('px');
        left=0-parseInt(left[0])*ratio;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        canvas.width = width;
        canvas.height = height;
        img.onload = function() {
            this.width = realWidth;
            this.height = realHeight;
            ctx.drawImage(this, left, top, this.width, this.height);
            base64 = canvas.toDataURL('image/jpeg', 1);
            $('.supCover .oneImgBox img').attr('src',base64);
            $('.dialogCoverSup').remove();
            $('.supCover .oneImgBox .ImgBox').css({'display':'none'});
        }
    });

    $('.dialogCoverSup #filesup').change(function(){
        changeFileSup()
    });
    $('.dialogCoverSup .closeImgBtn').click(function(){
        $('.dialogCoverSup').remove();
    });
//1、打开浏览器 onClick="openBrowse()" onchange="changeFile()" onClick="uploadFile()"
    function openBrowseSup(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("filesup").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("filesup").dispatchEvent(a);
        }
    }
    function getFileUrl(sourceId) {
        var url;
        if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
            url = document.getElementById(sourceId).value;
        } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Safari")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        }
        return url;
    }
//选择文件事件
    function changeFileSup() {
        var url = getFileUrl("filesup");//根据id获取文件路径
        preImgSup(url);
        return false;
    }

//3、将本地图片 显示到浏览器上
    function preImgSup(url) {
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }
        //初始化图片
        initTargetSup();
        var image = document.getElementById('tarsup');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;
                if(realWidth<513||realHeight<513){
                    $tarsup.hide();
                    layer.msg('请选择尺寸不小于513*513px的图片')
                    return;
                }
                else{
                    initJcropSup();
                }
            };
            img.src = url;
        };
        image.src = url;
    }

//初始化Jcrop插件
    function initJcropSup(){
        $tarsup.removeAttr("style");//清空上一次初始化设置的样式
        var showWidth=$tarsup.css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        //比例
        var minWidth=showWidth/(realWidth/513);
        $tarsup.Jcrop({
            minSize:[minWidth,minWidth],
            aspectRatio: 513 / 513
        },function(){
            //初始化后回调函数
            // 获取图片实际显示的大小
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度
            // 保存jcrop_api变量
            jcrop_api = this;
        });
    }
    function initTargetSup(){
        $tarsup.removeAttr("style");//清空上一次初始化设置的样式
        $tarsup.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }

});

//添加段落导语
$(document).on('click','.addIntBtn',function () {
    var intHtml='<div class="IntSingle">' +
        '<p class="IntHead">段落导语<span class="delBtn">X</span></p>' +
        '<div class="textareaBox">' +
        '<textarea class="form-control" rows="4" placeholder="请输入10～100个汉字的导语"></textarea>' +
        '<span class="des_tip">0/100</span>' +
        '</div>' +
        '</div>';
    $('#sortable').append(intHtml);
    if($('#isLocation').is(':checked')) {
        var len=$('#sortable .IntSingle').length;
        $('#sortable .IntSingle:last').attr('id',len);
        $("html,body").animate({scrollTop: $("#"+len).offset().top}, 500);
    }
});


$('html body').on('click','.IntSingle .delBtn',function () {
    var $IntSingle=$(this).parents('.IntSingle')
    layer.confirm('确定要删除改模块吗',function (index) {
        $IntSingle.remove();
        layer.close(index);
    },function (index) {
        layer.close(index);
    });

})
// 产品卡更换图片
$('html body').on('click','.IntSingle .change_img',function () {
    $imgSingle=$(this).siblings('.goods_img');
    var imgSrc=$(this).siblings('.goods_img').attr('src');
    var ul=$(this).parents('.IntSingle').find('.ul_img_box').html();
    var changeImgModel='<div class="changeImgModel">\n' +
        // '\t\t\t<button type="button" class="btn btn-primary selImgBtn">选择图片</button><small style="margin: 0 10px">可选择以下图片或点击选择图片</small>\n' +
        '\t\t\t\t<button type="button" class="btn btn-success sureImgBtn">确定</button>\n' +
        '\t\t\t\t<button type="button" class="btn btn-warning closeImgBtn">取消</button><div style="margin-left: 40px">' +ul+'</div>'+
        // '\t\t\t<div class="head">\n' +
        // '\t\t\t\t<img src="'+imgSrc+'"  id="targetImg"/>\n' +
        // '\t\t\t\t<input type="file" id="fileImg" style="display: none;"/>\n' +
        // '\t\t\t</div>\n' +
        '\t\t</div>';
    $('html body').append(changeImgModel);
    $('.changeImgModel .img_ul').css({'margin-left':'-50px','height': '134px'});
    // 定义一些使用的变量
    // var jcrop_api,//jcrop对象
    //     boundx,//图片实际显示宽度
    //     boundy,//图片实际显示高度
    //     realWidth,// 真实图片宽度
    //     realHeight, //真实图片高度
    //     // 使用的jquery对象
    //     $targetImg = $('#targetImg');
    //
    // preImgImg(imgSrc);
    // $('.changeImgModel .selImgBtn').click(function () {
    //     openBrowseImg()
    // });

    $('.changeImgModel .sureImgBtn').click(function () {
        // var img = new Image();
        // img.src = $('#targetImg').attr('src');
        // var realWidth = img.width;
        // var realHeight = img.height;
        // if(img.src.indexOf('http')!=-1){
        //     img.crossOrigin = "Anonymous";
        //     img.src = $('#targetImg').attr('src');
        // }
        //
        // var showWidth=$('#targetImg').css('width');
        // showWidth=showWidth.split('px');
        // showWidth=parseInt(showWidth[0]);
        // var showHeight=$('#targetImg').css('height');
        // showHeight=showHeight.split('px');
        // showHeight=parseInt(showHeight[0]);
        //
        // // 真实图片和显示图片的宽比  高比
        // var ratio=realWidth/showWidth;
        //
        // var width=$('.changeImgModel .jcrop-holder>div').css('width');
        // if(width=='0px'){
        //     // layer.msg('请裁剪图片再点击确定');
        //     // return;
        //     $imgSingle.attr('src',$('#targetImg').attr('src'));
        // }
        // else{
        //     width=width.split('px');
        //     width=parseInt(width[0])*ratio;
        //     var height=$('.changeImgModel .jcrop-holder>div').css('height');
        //     // if(height=='0px'){
        //     //     layer.msg('请裁剪图片再点击确定');
        //     //     return;
        //     // }
        //     height=height.split('px');
        //     height=parseInt(height[0])*ratio;
        //     var top=$('.changeImgModel .jcrop-holder>div').css('top');
        //     top=top.split('px');
        //     top=0-parseInt(top[0])*ratio;
        //     var left=$('.changeImgModel .jcrop-holder>div').css('left');
        //     left=left.split('px');
        //     left=0-parseInt(left[0])*ratio;
        //     var canvas = document.createElement("canvas");
        //     var ctx = canvas.getContext('2d');
        //     var base64;
        //     canvas.width = width;
        //     canvas.height = height;
        //
        //     img.onload = function() {
        //         this.width = realWidth;
        //         this.height = realHeight;
        //         ctx.drawImage(this, left, top, this.width, this.height);
        //         base64 = canvas.toDataURL('image/jpeg', 1);
        //         $.post(
        //             '/admin/toutiao/save_img',
        //             {
        //                 img:base64,
        //                 _token :  $("input[name='_token']").val()
        //             },
        //             function (res) {
        //                 res = JSON.parse(res);
        //                 console.log(res.url);
        //                 $imgSingle.attr('src',res.url);
        //             }
        //         )
        //     }
        // }
        var src=$('.img_ul .img_active').find('img').attr('src');
        $imgSingle.attr('src',src);
        $('.changeImgModel').remove();
    });
    // $('.changeImgModel .img_ul li').click(function () {
    //     var liSrc=$(this).find('img').attr('src');
    //     $('#targetImg').attr('src',liSrc);
    //     preImgImg(liSrc);
    // })
    $('.changeImgModel .closeImgBtn').click(function () {
        $('.changeImgModel').remove();
    });

    $('.changeImgModel #fileImg').change(function(){
        changeFileImg()
    });
    //1、打开浏览器 onClick="openBrowse()" onchange="changeFile()" onClick="uploadFile()"
    function openBrowseImg(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("fileImg").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("fileImg").dispatchEvent(a);
        }
    }

    //2、从 file 域获取 本地图片 url
    function getFileUrlImg(sourceId) {
        var url;
        if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
            url = document.getElementById(sourceId).value;
        } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Safari")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        }
        return url;
    }
    //选择文件事件
    function changeFileImg() {
        var url = getFileUrlImg("fileImg");//根据id获取文件路径
        preImgImg(url);
        return false;
    }

    //3、将本地图片 显示到浏览器上
    function preImgImg(url) {
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }
        initTargetImg();
        var image = document.getElementById('targetImg');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;
                initJcropImg();
            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.Jcrop({
            // aspectRatio: 513 / 513
        },function(){
            //初始化后回调函数
            // 获取图片实际显示的大小
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度
            jcrop_api = this;
        });
    }
    function initTargetImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }
})
//段落导语提示
$('html body').on('keyup','.IntSingle .textareaBox textarea',function () {
    var length = 100;
    var content_len = $(this).val().length;
    var in_len = length-content_len;
    $(this).siblings(".des_tip").html(content_len+'/100');
    if(content_len>length||content_len<10){
        $(this).siblings(".des_tip").addClass('warning');
    }
    else if(content_len<=length){
        $(this).siblings(".des_tip").removeClass('warning');
    }
});


$('html body').on('blur','.IntSingle .textareaBox textarea',function () {
    var length = 100;
    var content_len = $(this).val().length;
    var in_len = length-content_len;
    if(content_len!=''&&(content_len>length||content_len<10) ){
        //layer.msg('段落描述长度需要在10-100字之间')
    }
});
//产品卡描述提示
$('html body').on('keyup','.IntSingle .goods_des',function () {
    var length = 100;
    var content_len = $(this).val().length;
    var in_len = length-content_len;
    $(this).siblings(".card_tip").html(content_len+'/100');
    if(content_len>length||content_len<10){
        $(this).siblings(".card_tip").addClass('warning');
    }
    else if(content_len<=length){
        $(this).siblings(".card_tip").removeClass('warning');
    }
});
$('html body').on('blur','.IntSingle .goods_des',function () {
    var length = 100;
    var content_len = $(this).val().length;
    var in_len = length-content_len;
    if(content_len!=''&&(content_len>length||content_len<10) ){
        //layer.msg('产品描述长度需要在10-100字之间')
    }
});

//添加图片
$(document).on('click','.addImgBtn',function () {
    var addImgModel='<div class="addImgModel">\n' +
        '\t\t\t<button type="button" class="btn btn-primary selImgBtn">选择图片</button>\n' +
        '\t\t\t<button type="button" class="btn btn-success sureImgBtn">确定</button>\n' +
        '\t\t\t<button type="button" class="btn btn-warning closeImgBtn">取消</button>\n' +
        '\t\t\t<div class="head">\n' +
        '\t\t\t\t<img id="targetImg" />\n' +
        '\t\t\t\t<input type="file" id="fileImg" style="display: none;"/>\n' +
        '\t\t\t</div>\n' +
        '\t\t</div>';
    $('html body').append(addImgModel);
    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        // 使用的jquery对象
        $targetImg = $('#targetImg');

    $('.addImgModel .selImgBtn').click(function () {
        openBrowseImg()
    });

    $('.addImgModel .sureImgBtn').click(function () {
        if(typeof($('#targetImg').attr('src'))=="undefined"){
            layer.msg('请选择图片进行裁剪');
            return;
        }
        var img = new Image();
        img.src = $('#targetImg').attr('src');
        var realWidth = img.width;
        var realHeight = img.height;

        var showWidth=$('#targetImg').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#targetImg').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);

        // 真实图片和显示图片的宽比  高比
        var ratio=realWidth/showWidth;

        var width=$('.addImgModel .jcrop-holder>div').css('width');
        if(width=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        width=width.split('px');
        width=parseInt(width[0])*ratio;
        var height=$('.addImgModel .jcrop-holder>div').css('height');
        if(height=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        height=height.split('px');
        height=parseInt(height[0])*ratio;
        var top=$('.addImgModel .jcrop-holder>div').css('top');
        top=top.split('px');
        top=0-parseInt(top[0])*ratio;
        var left=$('.addImgModel .jcrop-holder>div').css('left');
        left=left.split('px');
        left=0-parseInt(left[0])*ratio;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        canvas.width = width;
        canvas.height = height;

        img.onload = function() {
            this.width = realWidth;
            this.height = realHeight;
            ctx.drawImage(this, left, top, this.width, this.height);
            base64 = canvas.toDataURL('image/jpeg', 1);
            $('.addImgModel').remove();
            var imgBoxHtml='<div class="IntSingle">' +
                '<p class="IntHead">段落图片<span class="delBtn">X</span></p>' +
                '<div class="IntContent">' +
                '<img class="imgSingle" src=""/>' +
                '<button type="button" class="btn btn-warning changeImgBtn">更换图片</button>' +
                '</div>'+
                '</div>';
            $('#sortable').append(imgBoxHtml);
            $('.imgSingle:last').attr('src',base64);
            if($('#isLocation').is(':checked')) {
                var len=$('#sortable .IntSingle').length;
                $('#sortable .IntSingle:last').attr('id',len);
                $("html,body").animate({scrollTop: $("#"+len).offset().top}, 500);
            }
        }

    });
    $('.addImgModel .closeImgBtn').click(function () {
        $('.addImgModel').remove();
    });

    $('.addImgModel #fileImg').change(function(){
        changeFileImg()
    });

    //1、打开浏览器
    function openBrowseImg(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("fileImg").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("fileImg").dispatchEvent(a);
        }
    }
    //2、从 file 域获取 本地图片 url
    function getFileUrlImg(sourceId) {
        var url;
        if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
            url = document.getElementById(sourceId).value;
        } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Safari")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        }
        return url;
    }
    //选择文件事件
    function changeFileImg() {
        var url = getFileUrlImg("fileImg");//根据id获取文件路径
        preImgImg(url);
        return false;
    }

    //3、将本地图片 显示到浏览器上
    function preImgImg(url) {

        console.log('url===' + url);
        //图片裁剪逻辑
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }

        //初始化图片
        initTargetImg();
        var image = document.getElementById('targetImg');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;

                //获取图片真实高度之后
                initJcropImg();//初始化Jcrop插件
                //initCanvasImg();//初始化Canvas内容
            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.Jcrop({
            //onChange: updatePreviewImg,
            //onSelect: updatePreviewImg
            // aspectRatio: 513 / 513
        },function(){
            //初始化后回调函数
            // 获取图片实际显示的大小
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度

            // 保存jcrop_api变量
            jcrop_api = this;

        });
    }

    //初始化预览div内容
    function initTargetImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }
})
$('html body').on('click','.IntSingle .changeImgBtnBefore',function () {
    $imgSingle=$(this).siblings('.imgSingle');
    var imgSrc=$(this).siblings('.imgSingle').attr('src');
    var changeImgModel='<div class="changeImgModel">\n' +
        '\t\t\t<button type="button" class="btn btn-primary selImgBtn">选择图片</button>\n' +
        '\t\t\t<button type="button" class="btn btn-success sureImgBtn">确定</button>\n' +
        '\t\t\t<button type="button" class="btn btn-warning closeImgBtn">取消</button>\n' +
        '\t\t\t<div class="head">\n' +
        '\t\t\t\t<img id="targetImg" src="'+imgSrc+'"/>\n' +
        '\t\t\t\t<input type="file" id="fileImg" style="display: none;"/>\n' +
        '\t\t\t</div>\n' +
        '\t\t</div>';
    $('html body').append(changeImgModel);
    // 定义一些使用的变量
    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        $targetImg = $('#targetImg');
    preImgImg(imgSrc);
    $('.changeImgModel .selImgBtn').click(function () {
        openBrowseImg()
    });

    $('.changeImgModel .sureImgBtn').click(function () {
        var img = new Image();
        img.src = $('#targetImg').attr('src');
        var realWidth = img.width;
        var realHeight = img.height;

        var showWidth=$('#targetImg').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#targetImg').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);

        // 真实图片和显示图片的宽比  高比
        var ratio=realWidth/showWidth;

        var width=$('.changeImgModel .jcrop-holder>div').css('width');
        if(width=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        width=width.split('px');
        width=parseInt(width[0])*ratio;
        var height=$('.changeImgModel .jcrop-holder>div').css('height');
        if(height=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        height=height.split('px');
        height=parseInt(height[0])*ratio;
        var top=$('.changeImgModel .jcrop-holder>div').css('top');
        top=top.split('px');
        top=0-parseInt(top[0])*ratio;
        var left=$('.changeImgModel .jcrop-holder>div').css('left');
        left=left.split('px');
        left=0-parseInt(left[0])*ratio;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        canvas.width = width;
        canvas.height = height;
        img.onload = function() {
            this.width = realWidth;
            this.height = realHeight;
            ctx.drawImage(this, left, top, this.width, this.height);
            base64 = canvas.toDataURL('image/jpeg', 1);
            $('.changeImgModel').remove();
            $imgSingle.attr('src',base64);
        }
    });
    $('.changeImgModel .closeImgBtn').click(function () {
        $('.changeImgModel').remove();
    });

    $('.changeImgModel #fileImg').change(function(){
        changeFileImg()
    });
    //1、打开浏览器
    function openBrowseImg(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("fileImg").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("fileImg").dispatchEvent(a);
        }
    }
    //2、从 file 域获取 本地图片 url
    function getFileUrlImg(sourceId) {
        var url;
        if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
            url = document.getElementById(sourceId).value;
        } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Safari")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        }
        return url;
    }
    //选择文件事件
    function changeFileImg() {
        var url = getFileUrlImg("fileImg");//根据id获取文件路径
        preImgImg(url);
        return false;
    }
    //3、将本地图片 显示到浏览器上
    function preImgImg(url) {
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }
        //初始化图片
        initTargetImg();
        var image = document.getElementById('targetImg');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;
                //获取图片真实高度之后
                initJcropImg();//初始化Jcrop插件
            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.Jcrop({
        },function(){
            //初始化后回调函数
            // 获取图片实际显示的大小
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度
            jcrop_api = this;
        });
    }
    function initTargetImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }

});

//添加宝贝--专辑
$(document).on('click','.addBaby',function () {
    var imgList=["https://img.alicdn.com/imgextra/i1/1112588309/TB24Znsh.UIL1JjSZFrXXb3xFXa_!!1112588309.jpg_430x430q90.jpg",
        "https://img.alicdn.com/imgextra/https://img.alicdn.com/imgextra/i3/3175436648/O1CN011yypVZH8Ez1AlGN_!!3175436648.jpg_430x430q90.jpg",
        "https://img.alicdn.com/imgextra/https://img.alicdn.com/imgextra/i2/3175436648/O1CN011yypVP4pLVeAV7M_!!3175436648.jpg_430x430q90.jpg",
        "https://img.alicdn.com/imgextra/https://img.alicdn.com/imgextra/i4/3175436648/O1CN011yypVPWDJRtclGe_!!3175436648.jpg_430x430q90.jpg",
        "https://img.alicdn.com/imgextra/i1/1112588309/TB2OlzLgJzJ8KJjSspkXXbF7VXa_!!1112588309.jpg_430x430q90.jpg"
    ];
    var imgRandom=parseInt(Math.random()*5);
    var goodsLink="https://detail.tmall.com/item.htm?id=568792074762&ali_trackid=2:mm_119430167_19686107_67938864:1539938240_260_873074974&track_params=null&spm=a21ye.index.richtext_item.d568792074762&pg1stepk=ucm:204019996122_2900201289_{%22common_content_page%22:daren}";

    var intHtml='<div class="IntSingle">' +
        '<p class="IntHead">产品卡<span class="delBtn">X</span></p>' +
        '<div style="width: 100%">' +
        '<div class="div_left"><img src="'+imgList[imgRandom]+'" class="goods_img"/><span class="change_img">更换图片</span></div>'+
        '<div class="div_center">' +
        '<div><a href="'+goodsLink+'" target="_blank">2018新款秋冬礼服吊带裙女小黑裙宴会聚会连衣裙气质修身短款裙</a></div>'+
        '<div><span>￥</span><span class="price">158</span></div>'+
        '<div><span class="shop_name">梦梦家旗舰店</span></div>'+
        '</div>'+
        '<div class="div_right">' +
        '<textarea class="goods_des" rows="4" placeholder="请输入导语"></textarea>' +
        '<span class="card_tip">0/100</span>' +
        '</div>'+
        '</div>'+
        '</div>';

    $('#sortable').append(intHtml);

    if($('#isLocation').is(':checked')) {
        var len=$('#sortable .IntSingle').length;
        $('#sortable .IntSingle:last').attr('id',len);
        $("html,body").animate({scrollTop: $("#"+len).offset().top}, 500);
    }
});

//添加宝贝--图集
$(document).on('click','.addBabyAtlas',function () {
    var imgList=["https://img.alicdn.com/imgextra/i1/1112588309/TB24Znsh.UIL1JjSZFrXXb3xFXa_!!1112588309.jpg_430x430q90.jpg",
        "https://img.alicdn.com/imgextra/https://img.alicdn.com/imgextra/i3/3175436648/O1CN011yypVZH8Ez1AlGN_!!3175436648.jpg_430x430q90.jpg",
        "https://img.alicdn.com/imgextra/https://img.alicdn.com/imgextra/i2/3175436648/O1CN011yypVP4pLVeAV7M_!!3175436648.jpg_430x430q90.jpg",
        "https://img.alicdn.com/imgextra/https://img.alicdn.com/imgextra/i4/3175436648/O1CN011yypVPWDJRtclGe_!!3175436648.jpg_430x430q90.jpg",
        "https://img.alicdn.com/imgextra/i1/1112588309/TB2OlzLgJzJ8KJjSspkXXbF7VXa_!!1112588309.jpg_430x430q90.jpg"
    ];
    var imgRandom=parseInt(Math.random()*5);
    var goodsLink="https://detail.tmall.com/item.htm?id=568792074762&ali_trackid=2:mm_119430167_19686107_67938864:1539938240_260_873074974&track_params=null&spm=a21ye.index.richtext_item.d568792074762&pg1stepk=ucm:204019996122_2900201289_{%22common_content_page%22:daren}";
    var intHtml='<div class="atlasSingle">' +
        // '<p class="IntHead">产品卡<span class="delAtlasBtn">X</span></p>' +

        '<span class="glyphicon glyphicon-remove delAtlasBtn"></span>' +
        '<div  class="atlas_img">' +
            '<div class="main_img">' +
                '<img src="'+imgList[imgRandom]+'"/>' +
            '</div>'+
            '<div class="vice_box">' +
                '<img class="vice_img" src="'+imgList[imgRandom]+'" class="goods_img"/>' +
                '<p class="vice_des">喜欢黑色的神秘和吞噬一切色彩强大气场...</p>' +
            '</div>'+
        '</div>' +
        '<div>' +
            '<p><a href="'+goodsLink+'" target="_blank">2018新款秋冬礼服吊带裙女小黑裙宴会聚会连衣裙气质修身短款裙</a></p>'+
            '<p class="vice_des">喜欢黑色的神秘和吞噬一切色彩强大气场，一席简约的赫本小黑裙足够你演绎出精彩的生活剧本！</p>' +
            '<p class="price">￥158</p>'+
            '<div><span class="shop_name">梦梦家旗舰店</span></div>'+
        '</div>'+

        '</div>';

    $('#sortable').append(intHtml);
});
//添加宝贝--删除图集
$(document).on('click','.atlasSingle .delAtlasBtn',function (){
    $(this).parents('.atlasSingle').remove();
})

//三图
$(document).on('click','.threeImgBox .sinImgBox',function () {
    var imgIndex=$('.threeImgBox .sinImgBox').index(this);
    console.log('第'+imgIndex+'张图')
    var threeImgModel='<div class="threeImgModel">\n' +
        '\t\t\t<button type="button" class="btn btn-primary selImgBtn">选择图片</button>\n' +
        '\t\t\t<button type="button" class="btn btn-success sureImgBtn">确定</button>\n' +
        '\t\t\t<button type="button" class="btn btn-warning closeImgBtn">取消</button>\n' +
        '\t\t\t<div class="head">\n' +
        '\t\t\t\t<img id="targetImg" />\n' +
        '\t\t\t\t<input type="file" id="fileImg" style="display: none;"/>\n' +
        '\t\t\t</div>\n' +
        '\t\t</div>';
    $('html body').append(threeImgModel);
    // 定义一些使用的变量
    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        $targetImg = $('#targetImg');

    if(typeof($('.threeImgBox .sinImgBox:eq('+imgIndex+') img').attr('src'))!="undefined"){
        var imgSrc=$('.threeImgBox .sinImgBox:eq('+imgIndex+') img').attr('src');
        $('#targetImg').attr('src',imgSrc);
        preImgImg(imgSrc);
    }
    $('.threeImgModel .selImgBtn').click(function () {
        openBrowseImg()
    });
    $('.threeImgModel .sureImgBtn').click(function () {
        if(typeof($('#targetImg').attr('src'))=="undefined"){
            layer.msg('请选择图片进行裁剪');
            return;
        }
        var img = new Image();
        img.src = $('#targetImg').attr('src');
        var realWidth = img.width;
        var realHeight = img.height;

        var showWidth=$('#targetImg').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#targetImg').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);

        // 真实图片和显示图片的宽比  高比
        var ratio=realWidth/showWidth;

        var width=$('.threeImgModel .jcrop-holder>div').css('width');
        if(width=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        width=width.split('px');
        width=parseInt(width[0])*ratio;
        var height=$('.threeImgModel .jcrop-holder>div').css('height');
        if(height=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        height=height.split('px');
        height=parseInt(height[0])*ratio;
        var top=$('.threeImgModel .jcrop-holder>div').css('top');
        top=top.split('px');
        top=0-parseInt(top[0])*ratio;
        var left=$('.threeImgModel .jcrop-holder>div').css('left');
        left=left.split('px');
        left=0-parseInt(left[0])*ratio;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        canvas.width = width;
        canvas.height = height;
        img.onload = function() {
            this.width = realWidth;
            this.height = realHeight;
            ctx.drawImage(this, left, top, this.width, this.height);
            base64 = canvas.toDataURL('image/jpeg', 1);
            $('.threeImgBox .sinImgBox:eq('+imgIndex+') .ImgBox').hide();
            $('.threeImgBox .sinImgBox:eq('+imgIndex+') img').attr('src',base64);
            $('.threeImgModel').remove();
        }
    });
    $('.threeImgModel .closeImgBtn').click(function () {
        $('.threeImgModel').remove();
    });

    $('.threeImgModel #fileImg').change(function(){
        changeFileImg()
    });
    //1.
    function openBrowseImg(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("fileImg").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("fileImg").dispatchEvent(a);
        }
    }

    //2、从 file 域获取 本地图片 url
    function getFileUrlImg(sourceId) {
        var url;
        if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
            url = document.getElementById(sourceId).value;
        } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Safari")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        }
        return url;
    }
    //选择文件事件
    function changeFileImg() {
        var url = getFileUrlImg("fileImg");//根据id获取文件路径
        preImgImg(url);
        return false;
    }
    //3、将本地图片 显示到浏览器上
    function preImgImg(url) {
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }
        initTargetImg();
        var image = document.getElementById('targetImg');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;
                if(realWidth<750||realHeight<422){
                    $targetImg.hide();
                    layer.msg('请选择尺寸不小于750*422px的图片')
                    return;
                }
                else{
                    initJcropImg();
                }
            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        var showWidth=$('#targetImg').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#targetImg').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);
        //比例
        var minWidth=showWidth/(realWidth/750);
        var minHeight=minWidth/(750/422);
        $targetImg.Jcrop({
            minSize:[minWidth,minHeight],
            aspectRatio: 750 / 422
        },function(){
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度
            jcrop_api = this;
        });
    }
    function initTargetImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }
});

//预览
$(document).on('click','.previewBtn',function () {
    var obj;
    var title=$('#titleInp').val();
    var leads=$('.leads').val();
    var t_img;
    if($('.firstImg img').length>0){
        var firstImg=$('.firstImg img').attr('src');
        t_img='<img src="'+firstImg+'">';
    }

    if(title==''){
        layer.msg('请填写标题');
        return;
    }
    else if (title.length<4){
        layer.msg('标题不能少于4个字');
        return;
    }
    else if (title.length>19){
        layer.msg('标题不能多于19个字');
        return;
    }

    if(leads==''){
        layer.msg('请填写导语');
        return;
    }
    else if (leads.length<10){
        layer.msg('导语不能少于10个字');
        return;
    }
    else if (leads.length>100){
        layer.msg('导语不能多于100个字');
        return;
    }
    var len=$('#sortable .IntSingle').length;
    var content=[];
    for (var i=0;i<len;i++){
        var single;
        var addType=$('#sortable .IntSingle:eq('+i+') .IntHead').text();
        if(addType.indexOf('图片')!=-1){
            single={
                type:2,
                img:$('#sortable .IntSingle:eq('+i+') img').attr('src'),
                describe:'',
                link:'',
                price:'',
                goods_name:'',
                shop_name:''

            }
        }
        else if(addType.indexOf('分割线')!=-1){
            single={
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
            else if (describe.length>100){
                layer.msg('段落导语不能多于100个字');
                return;
            }
            single={
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
            // var describe=$('#sortable .IntSingle:eq('+i+') textarea').val();
            // if(describe!=''&&(describe.length<10||describe.length>100)){
            //     layer.msg('产品卡的描述必须在10-100字之间');
            // }
            single={
                type:4,
                img:$('#sortable .IntSingle:eq('+i+') .div_left img').attr('src'),
                describe:'',
                // describe:$('#sortable .IntSingle:eq('+i+') .div_right textarea').val(),
                link:$('#sortable .IntSingle:eq('+i+') a').attr('href'),
                price:$('#sortable .IntSingle:eq('+i+') .price').text(),
                goods_name:$('#sortable .IntSingle:eq('+i+') a').text(),
                shop_name:$('#sortable .IntSingle:eq('+i+') .shop_name').text()
            }
        }
        content.push(single);
    }
    var article_content='';
    for (var i=0;i<len;i++){

        if(content[i].type==2 || content[i].type==5){
            article_content+= '<div class="article_img">' +
                '<img  class="tt-img" src="'+content[i].img+'" />' +
                '</div>' ;
        }
        else if(content[i].type==1){
            article_content+= '<div class="article_des">' +
                '<div class="tt-des">'+content[i].describe+'</div>' +
                '</div>' ;
        }
        else if(content[i].type==4){
            article_content+= '<div class="article_card">' +
                '<div class="tt-card">'+
                '<div class="tt-card-left">'+
                '<img  class="tt-img" src="'+content[i].img+'" />' +
                '</div>' +
                '<div class="tt-card-right">'+
                '<a class="tt-link" href="'+content[i].link+'" target="_blank">'+content[i].goods_name+ '</a>' +
                '<p class="tt-price" >￥'+content[i].price+ '</p>' +
                '</div>' +
                '</div>' +
                '</div>' ;
        }
    }

    var img = '<div class="phone-preview">' +
        '<div class="preview-article-content">' +
        '<div class="tt-title">'+title+'</div>' +
        '<div class="tt-first-img">'+t_img+'</div>' +
        '<div class="tt-leads">'+leads+'</div>' +
        '<div class="tt-content">'+article_content+'</div>' +
        '</div>'+
        '</div>' ;


    layer.open({
        type: 1,
        title: false, //不显示标题
        area:['auto','auto'],
        shade: [0.8, '#393D49'],
        shadeClose:true,
        content: img, //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        cancel: function () {
            //layer.msg('图片查看结束！', { time: 5000, icon: 6 });
        }
    });
    // layui-layer
    $('.phone-preview').parents('.layui-layer').css({'background-color':'transparent','box-shadow':'none'})
})

//预览-特卖专辑
$(document).on('click','.previewBtn_tm',function () {
    var title=$('#article_title').val();
    var leads=$('.leads').val();

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
        $draftBtn.css({'cursor':'pointer'});
        return;
    }

    if(leads==''){
        layer.msg('请填写导语');
        return;
    }
    else if (leads.length<10){
        layer.msg('导语不能少于10个字');
        return;
    }
    // else if (leads.length>100){
    //     layer.msg('导语不能多于100个字');
    //     return;
    // }
    var len=$('#sortable .IntSingle').length;
    var content=[];
    for (var i=0;i<len;i++){
        var single;
        var addType=$('#sortable .IntSingle:eq('+i+') .IntHead').text();
        if(addType.indexOf('图片')!=-1){
            single={
                type:2,
                img:$('#sortable .IntSingle:eq('+i+') img').attr('src'),
                describe:'',
                link:'',
                price:'',
                goods_name:'',
                shop_name:''

            }
        }
        else if(addType.indexOf('分割线')!=-1){
            single={
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
            //     return;
            // }
            single={
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
            // var describe=$('#sortable .IntSingle:eq('+i+') textarea').val();
            // if(describe!=''&&(describe.length<10||describe.length>100)){
            //     layer.msg('产品卡的描述必须在10-100字之间');
            // }
            single={
                type:4,
                img:$('#sortable .IntSingle:eq('+i+') .div_left img').attr('src'),
                describe:'',
                // describe:$('#sortable .IntSingle:eq('+i+') .div_right textarea').val(),
                link:$('#sortable .IntSingle:eq('+i+') a').attr('href'),
                price:$('#sortable .IntSingle:eq('+i+') .price').text(),
                goods_name:$('#sortable .IntSingle:eq('+i+') a').text(),
                shop_name:$('#sortable .IntSingle:eq('+i+') .shop_name').text()
            }
        }
        content.push(single);
    }
    var article_content='';
    for (var i=0;i<len;i++){

        if(content[i].type==2 || content[i].type==5){
            article_content+= '<div class="article_img">' +
                '<img  class="tt-img" src="'+content[i].img+'" />' +
                '</div>' ;
        }
        else if(content[i].type==1){
            article_content+= '<div class="article_des">' +
                '<div class="tt-des">'+content[i].describe+'</div>' +
                '</div>' ;
        }
        else if(content[i].type==4){
            article_content+= '<div class="article_card">' +
                '<div class="tt-card">'+
                '<div class="tt-card-left">'+
                '<img  class="tt-img" src="'+content[i].img+'" />' +
                '</div>' +
                '<div class="tt-card-right">'+
                '<a class="tt-link" href="'+content[i].link+'" target="_blank">'+content[i].goods_name+ '</a>' +
                '<p class="tt-price" >￥'+content[i].price+ '</p>' +
                '</div>' +
                '</div>' +
                '</div>' ;
        }
    }

    var img = '<div class="phone-preview">' +
        '<div class="preview-article-content">' +
        '<div class="tt-title">'+title+'</div>' +
        '<div class="tt-first-img"><img src="'+firstImg+'"></div>' +
        '<div class="tt-leads">'+leads+'</div>' +
        '<div class="tt-content">'+article_content+'</div>' +
        '</div>'+
        '</div>' ;


    layer.open({
        type: 1,
        title: false, //不显示标题
        area:['auto','auto'],
        shade: [0.8, '#393D49'],
        shadeClose:true,
        content: img, //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        cancel: function () {
            //layer.msg('图片查看结束！', { time: 5000, icon: 6 });
        }
    });
    // layui-layer
    $('.phone-preview').parents('.layui-layer').css({'background-color':'transparent','box-shadow':'none'})
})

//发布
$(document).on('click','.publishBtn',function () {
    var $publishBtn=$(this);
    $(this).css({'cursor':'not-allowed'});
    var obj;
    var title=$('#titleInp').val();
    var leads=$('.leads').val();
    var t_img;
    if($('.firstImg img').length>0){
        var firstImg=$('.firstImg img').attr('src');
    }

    if(title==''){
        layer.msg('请填写标题');
        $publishBtn.css({'cursor':'pointer'});
        return;
    }
    else if (title.length<4){
        layer.msg('标题不能少于4个字');
        $publishBtn.css({'cursor':'pointer'});
        return;

    }
    else if (title.length>19){
        layer.msg('标题不能多于19个字');
        $publishBtn.css({'cursor':'pointer'});
        return;
    }

    if($('.AddFirstImg').length>0){
        layer.msg('请添加首图');
        $publishBtn.css({'cursor':'pointer'});
        return;
    }

    if(leads==''){
        layer.msg('请填写导语');
        $publishBtn.css({'cursor':'pointer'});
        return;
    }
    else if (leads.length<10){
        layer.msg('导语不能少于10个字');
        $publishBtn.css({'cursor':'pointer'});
        return;
    }
    else if (leads.length>100){
        layer.msg('导语不能多于100个字');
        $publishBtn.css({'cursor':'pointer'});
        return;
    }
    var len=$('#sortable .IntSingle').length;
    var content=[];
    for (var i=0;i<len;i++){
        var single;
        var addType=$('#sortable .IntSingle:eq('+i+') .IntHead').text();
        if(addType.indexOf('图片')!=-1){
            single={
                type:2,
                img:$('#sortable .IntSingle:eq('+i+') img').attr('src'),
                describe:'',
                link:'',
                price:'',
                goods_name:'',
                shop_name:''

            }
        }
        else if(addType.indexOf('分割线')!=-1){
            single={
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
                $publishBtn.css({'cursor':'pointer'});
                return;
            }
            else if (describe.length<10){
                layer.msg('段落导语不能少于10个字');
                $publishBtn.css({'cursor':'pointer'});
                return;
            }
            else if (describe.length>100){
                layer.msg('段落导语不能多于100个字');
                $publishBtn.css({'cursor':'pointer'});
                return;
            }
            single={
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
                type:4,
                img:$('#sortable .IntSingle:eq('+i+') .div_left img').attr('src'),
                describe:'',
                // describe:$('#sortable .IntSingle:eq('+i+') .div_right textarea').val(),
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
            // articleType  7是专辑   6是图集
            // platform    1是头条   0是放心购
            id:article_id,
            publish_time:'',
            platform:1,
            articleType:7,
            saveType:3,
            title:title,
            firstImg:firstImg,
            leads:leads,
            content:content
        };
    }
    else{
        obj={
            publish_time:'',
            platform:1,
            articleType:7,
            saveType:3,
            title:title,
            firstImg:firstImg,
            leads:leads,
            content:content
        };
    }

    console.log(obj);
    $publishBtn.css({'cursor':'pointer'});

    $.post(
        '/admin/toutiao/save_article',
        {
            data:JSON.stringify(obj),
            _token :  $("input[name='_token']").val()
        },
        function(res) {
            var res=JSON.parse(res);
            if(res.status==0){
                layer.msg('发布成功');
                if($('#article_id').length>0){
                    var article_id=$('#article_id').val();
                    localStorage.removeItem('editToutiaoAlbum'+article_id);
                }
                else{
                    localStorage.removeItem('timingToutiaoAlbum');
                }

                window.location.reload();
            }
            else{
                layer.msg('发布失败');
            }
            setTimeout(function () {
                $publishBtn.css({'cursor':'pointer'});
            },5000)
        }
    )
});

//存草稿
$(document).on('click','.draftBtn',function () {
    var $draftBtn=$(this);
    $(this).css({'cursor':'not-allowed'});
    var obj;
    var title=$('#titleInp').val();
    var leads=$('.leads').val();
    var t_img;
    if($('.firstImg img').length>0){
        var firstImg=$('.firstImg img').attr('src');
    }

    if(title==''){
        layer.msg('请填写标题');
        $draftBtn.css({'cursor':'pointer'});
        return;
    }
    else if (title.length<4){
        layer.msg('标题不能少于4个字');
        $draftBtn.css({'cursor':'pointer'});
        return;
    }
    else if (title.length>19){
        layer.msg('标题不能多于19个字');
        $draftBtn.css({'cursor':'pointer'});
        return;
    }

    if($('.AddFirstImg').length>0){
        layer.msg('请添加首图');
        $draftBtn.css({'cursor':'pointer'});
        return;
    }

    if(leads==''){
        layer.msg('请填写导语');
        $draftBtn.css({'cursor':'pointer'});
        return;
    }
    else if (leads.length<10){
        layer.msg('导语不能少于10个字');
        $draftBtn.css({'cursor':'pointer'});
        return;
    }
    else if (leads.length>100){
        layer.msg('导语不能多于100个字');
        $draftBtn.css({'cursor':'pointer'});
        return;
    }
    var len=$('#sortable .IntSingle').length;
    var content=[];
    for (var i=0;i<len;i++){
        var single;
        var addType=$('#sortable .IntSingle:eq('+i+') .IntHead').text();
        if(addType.indexOf('图片')!=-1){
            single={
                type:2,
                img:$('#sortable .IntSingle:eq('+i+') img').attr('src'),
                describe:'',
                link:'',
                price:'',
                goods_name:'',
                shop_name:''

            }
        }
        else if(addType.indexOf('分割线')!=-1){
            single={
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
                $draftBtn.css({'cursor':'pointer'});
                return;
            }
            else if (describe.length<10){
                layer.msg('段落导语不能少于10个字');
                $draftBtn.css({'cursor':'pointer'});
                return;
            }
            else if (describe.length>100){
                layer.msg('段落导语不能多于100个字');
                $draftBtn.css({'cursor':'pointer'});
                return;
            }
            single={
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
            // var describe=$('#sortable .IntSingle:eq('+i+') textarea').val();
            // if(describe!=''&&(describe.length<10||describe.length>100)){
            //     layer.msg('产品卡的描述必须在10-100字之间');
            // }
            single={
                type:4,
                img:$('#sortable .IntSingle:eq('+i+') .div_left img').attr('src'),
                describe:'',
                // describe:$('#sortable .IntSingle:eq('+i+') .div_right textarea').val(),
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
            // articleType  7是专辑   6是图集
            // platform    1是头条   0是放心购
            id:article_id,
            publish_time:'',
            platform:1,
            articleType:7,
            saveType:2,
            title:title,
            firstImg:firstImg,
            leads:leads,
            content:content
        };
    }
    else{
        obj={
            publish_time:'',
            platform:1,
            articleType:7,
            saveType:2,
            title:title,
            firstImg:firstImg,
            leads:leads,
            content:content
        };
    }

    console.log(obj);
    $draftBtn.css({'cursor':'pointer'});

    $.post(
        '/admin/toutiao/save_article',
        {
            data:JSON.stringify(obj),
            _token :  $("input[name='_token']").val()
        },
        function(res) {
            var res=JSON.parse(res);
            if(res.status==0){
                layer.msg('存草稿成功');
                if($('#article_id').length>0){
                    var article_id=$('#article_id').val();
                    localStorage.removeItem('editToutiaoAlbum'+article_id);
                }
                else{
                    localStorage.removeItem('timingToutiaoAlbum');
                }
                window.location.reload();
            }
            else{
                layer.msg('存草稿失败');
            }
            setTimeout(function () {
                $draftBtn.css({'cursor':'pointer'});
            },5000)
        }
    )
});

//存草稿-特卖专辑
$(document).on('click','.draftBtn_tm',function () {
    var count=$('.textareaDes').length;
    var arTcontent='';
    if(count>0){
        for (var i=0;i<count;i++){
            arTcontent+=$('.textareaDes').eq(i).val();
        }
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
    var obj;
    var title=$('#article_title').val();
    var leads=$('.leads').val();

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
    else if (leads.length<10){
        layer.msg('导语不能少于10个字');
        return;
    }
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
            publish_time:'',
            articleType:2,
            saveType:2,
            title:title,
            firstImg:firstImg,
            leads:leads,
            content:content
        };
    }
    else{
        obj={
            publish_time:'',
            articleType:2,
            saveType:2,
            title:title,
            firstImg:firstImg,
            leads:leads,
            content:content
        };
    }

    console.log(obj);

    $.post(
        '/admin/article/save_article',
        {
            data:JSON.stringify(obj),
            _token :  $("input[name='_token']").val()
        },
        function(res) {
            var res=JSON.parse(res);
            if(res.status==0){
                layer.msg('存草稿成功');
                $('.commitBtn').siblings('button').prop('disabled', false);
                $('.commitBtn').prop('disabled', false);
                localStorage.removeItem('timingTmAlbum');
                localStorage.removeItem('timingTmTitle');
                localStorage.removeItem('timingTmLeads');
                localStorage.removeItem('timingTmImg');
                window.location.href='/admin/articles';
            }
            else{
                layer.msg('存草稿失败');
                $('.commitBtn').siblings('button').prop('disabled', false);
                $('.commitBtn').prop('disabled', false);
            }
            setTimeout(function () {
                $draftBtn.css({'cursor':'pointer'});
            },5000)
        }
    )
})

//提交审核-特卖专辑
$(document).on('click','.commitBtn',function () {
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

    var obj;
    var title=$('#article_title').val();
    // var leads=$('.leads').val();

    var sensitiveCon=localStorage.getItem('sensitiveCon');
    sensitiveCon=sensitiveCon.split(',');
    for(var i = 0; i< sensitiveCon.length; i++){
        if(leads.indexOf(sensitiveCon[i]) != -1){
            leads=leads.replace(sensitiveCon[i],'');
            $('.leads').val(leads);
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
    else if (leads.length<10){
        layer.msg('导语不能少于10个字');
        return;
    }
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
            publish_time:'',
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
            publish_time:'',
            articleType:2,
            saveType:3,
            title:title,
            firstImg:firstImg,
            leads:leads,
            content:content
        };
    }

    console.log(obj);
    $('.commitBtn').siblings('button').prop('disabled', true);
    $('.commitBtn').prop('disabled', true);

    $.post(
        '/admin/article/save_article',
        {
            data:JSON.stringify(obj),
            _token :  $("input[name='_token']").val()
        },
        function(res) {
            var res=JSON.parse(res);
            if(res.status==0){
                layer.msg('提交审核成功');
                $('.commitBtn').siblings('button').prop('disabled', false);
                $('.commitBtn').prop('disabled', false);
                localStorage.removeItem('timingTmAlbum');
                localStorage.removeItem('timingTmTitle');
                localStorage.removeItem('timingTmLeads');
                localStorage.removeItem('timingTmImg');
                window.location.href='/admin/articles';
            }
            else{
                $('.commitBtn').siblings('button').prop('disabled', false);
                $('.commitBtn').prop('disabled', false);
                layer.msg('提交审核失败');
            }
            setTimeout(function () {

            },5000)
        }
    )
})

// 定时发布
$(document).on('click','.timingPublishBtn',function () {
    var $timingPublishBtn=$(this);
    var isTiming=$('.timingPublishBtn').attr('data-timing');
    if(isTiming=='0'){
        var content='<div class="timeBox">' +
            '<span class="inputTime">请选择发表时间: </span>'+
            '<div class="form-group">'+
                '<div class="input-group date" id="datetimepicker2">'+
                    '<input type="text" class="form-control" />'+
                    '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span> </span>'+
                '</div>'+
            '</div>'+
            '<div class="" style="margin-top: 120px">'+
                '<button type="button" class="btn btn-primary surePubBtn">确认</button>' +
                '<button type="button" class="btn btn-default cancelBtn">取消</button>' +
            '</div>'+
        '</div>';
        layer.open({
            type: 1,
            title: false, //不显示标题
            area:['500px','390px'],
            shade: [0.8, '#393D49'],
            shadeClose:true,
            content: content,
            cancel: function () {}
        });
        $('#datetimepicker2').datetimepicker({
            locale: 'ru'
        })
    }
    else{
        layer.confirm('确定取消定时发布？',function (index) {
            $('.timingPublishBtn').text('定时发布');
            $('.timingPublishBtn').attr('data-timing','0');
            $('.publishTip').remove();
            layer.close(index);
        },function (index) {
            layer.close(index);
        });

    }
});
$(document).on('click','.timeBox .surePubBtn',function () {
    var timingTime=$('#datetimepicker2 input').val();
    if(timingTime==''){
        layer.msg('请选择发表时间')
    }
    else{
        var y=timingTime.substring(6,10);
        console.log(y);
        var m=timingTime.substring(3,5);
        console.log(m);
        var d=timingTime.substring(0,2);
        console.log(d);
        var time=timingTime.substring(11);
        console.log(time);
        var ptime=y+'-'+m+'-'+d+' '+time;
        console.log(ptime);

        var $surePubBtn=$(this);
        $(this).css({'cursor':'not-allowed'});
        var obj;
        var title=$('#titleInp').val();
        var leads=$('.leads').val();
        var t_img;
        if($('.firstImg img').length>0){
            var firstImg=$('.firstImg img').attr('src');
        }

        if(title==''){
            layer.msg('请填写标题');
            return;
        }
        else if (title.length<4){
            layer.msg('标题不能少于4个字');
            return;
        }
        else if (title.length>19){
            layer.msg('标题不能多于19个字');
            return;
        }

        if($('.AddFirstImg').length>0){
            layer.msg('请添加首图');
            return;
        }

        if(leads==''){
            layer.msg('请填写导语');
            return;
        }
        else if (leads.length<10){
            layer.msg('导语不能少于10个字');
            return;
        }
        else if (leads.length>100){
            layer.msg('导语不能多于100个字');
            return;
        }
        var len=$('#sortable .IntSingle').length;
        var content=[];
        for (var i=0;i<len;i++){
            var single;
            var addType=$('#sortable .IntSingle:eq('+i+') .IntHead').text();
            if(addType.indexOf('图片')!=-1){
                single={
                    type:2,
                    img:$('#sortable .IntSingle:eq('+i+') img').attr('src'),
                    describe:'',
                    link:'',
                    price:'',
                    goods_name:'',
                    shop_name:''

                }
            }
            else if(addType.indexOf('分割线')!=-1){
                single={
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
                else if (describe.length>100){
                    layer.msg('段落导语不能多于100个字');
                    return;
                }
                single={
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
                // var describe=$('#sortable .IntSingle:eq('+i+') textarea').val();
                // if(describe!=''&&(describe.length<10||describe.length>100)){
                //     layer.msg('产品卡的描述必须在10-100字之间');
                // }
                single={
                    type:4,
                    img:$('#sortable .IntSingle:eq('+i+') .div_left img').attr('src'),
                    describe:'',
                    // describe:$('#sortable .IntSingle:eq('+i+') .div_right textarea').val(),
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
                // articleType  7是专辑   6是图集
                // platform    1是头条   0是放心购
                id:article_id,
                publish_time:'',
                platform:1,
                articleType:7,
                saveType:3,
                title:title,
                firstImg:firstImg,
                leads:leads,
                content:content
            };
        }
        else{
            obj={
                publish_time:ptime,
                platform:1,
                articleType:7,
                saveType:3,
                title:title,
                firstImg:firstImg,
                leads:leads,
                content:content
            };
        }
        console.log(obj);
        $.post(
            '/admin/toutiao/save_article',
            {
                data:JSON.stringify(obj),
                _token :  $("input[name='_token']").val()
            },
            function(res) {
                var res=JSON.parse(res);
                if(res.status==0){
                    layer.msg('定时发布成功');
                    if($('#article_id').length>0){
                        var article_id=$('#article_id').val();
                        localStorage.removeItem('editToutiaoAlbum'+article_id);
                    }
                    else{
                        localStorage.removeItem('timingToutiaoAlbum');
                    }
                    $surePubBtn.parents('.layui-layer').siblings('.layui-layer-shade').remove();
                    $surePubBtn.parents('.layui-layer').remove();
                    $('.timingPublishBtn').text('取消定时发布');
                    $('.timingPublishBtn').attr('data-timing','1');
                    $('.timingPublishBtn').attr('data-time',time);
                    $('.timingPublishBtn').after('<p class="publishTip">本文将于'+time+'发布</p>');
                    window.location.reload();
                }
                else{
                    layer.msg('定时发布失败');
                }
                setTimeout(function () {
                    $surePubBtn.css({'cursor':'pointer'});
                },5)
            }
        )
    }
});
$(document).on('click','.timeBox .cancelBtn',function () {
    $(this).parents('.layui-layer').siblings('.layui-layer-shade').remove();
    $(this).parents('.layui-layer').remove();

});

//标题提示
$(document).on('keyup',"#titleInp",function(){
    var length = 19;
    var title=$("#titleInp").val();
    var content_len = $("#titleInp").val().length;
    var in_len = length-content_len;
    $(".title_tip").html(content_len+'/19');
    if(content_len>length||content_len<4){
        $(".title_tip").addClass('warning');
    }
    else if(content_len<=length){
        $(".title_tip").removeClass('warning');
    }
    $(this).attr('data-title',title);
});
$(document).on('blur',"#titleInp",function(){
    var length = 19;
    var content_len = $("#titleInp").val().length;
    var in_len = length-content_len;
    if(content_len!=''&&(content_len>length||content_len<4) ){
        layer.msg('标题长度需要在4-19字之间')
    }
});

//导语提示
$(document).on('keyup',".leads",function(){
    var length = 100;
    var leads = $(".leads").val();
    var content_len = $(".leads").val().length;
    var in_len = length-content_len;
    $(".leads_tip").html(content_len+'/100');
    if(content_len>length||content_len<10){
        $(".leads_tip").addClass('warning');
    }
    else if(content_len<=length){
        $(".leads_tip").removeClass('warning');
    }
    $(this).attr('data-leads',leads);

    var des=leads;

    var sensitiveCon=localStorage.getItem('sensitiveCon');
    sensitiveCon=sensitiveCon.split(',');
    for(var i = 0; i< sensitiveCon.length; i++){
        if(des.indexOf(sensitiveCon[i]) != -1){
            $(this).parents('.leadsBox').find('.findSensitive').text('发现敏感词【'+sensitiveCon[i]+'】');
            return;
        }
        else{
            $(this).parents('.leadsBox').find('.findSensitive').text('');
        }
    }
});
$(document).on('blur',".leads",function(){
    var length = 100;
    var content_len = $(".leads").val().length;
    var in_len = length-content_len;
    if(content_len!=''&&(content_len>length||content_len<10) ){
        //layer.msg('导语长度需要在10-100字之间')
    }
});

// 描述提示
$(document).on('keyup',".textareaDes",function(){
    var des=$(".textareaDes").val();
    $(this).attr('data-text',des);
});

// edit_title  修改标题
$('html body').on('click','.edit_title',function () {
    if($(this).text()=='修改标题'){
        $(this).parents('.IntSingle').find('.product_title').show();
        $(this).parents('.IntSingle').find('a').hide();
        $(this).text('修改完成');
    }
    else{
        var new_title=$(this).parents('.IntSingle').find('.product_title').val();
        var sensitiveTitle=localStorage.getItem('sensitiveTitle');
        sensitiveTitle=sensitiveTitle.split(',');
        var sensitiveCon=localStorage.getItem('sensitiveCon');
        sensitiveCon=sensitiveCon.split(',');
        if(new_title.length>20){
            layer.msg('产品标题不能大于20个字');
            return;
        }
        for(var i = 0; i< sensitiveTitle.length; i++){
            if(new_title.indexOf(sensitiveTitle[i]) != -1){
                layer.msg('发现敏感词【'+sensitiveTitle[i]+'】');
                return;
            }
        }
        for(var i = 0; i< sensitiveCon.length; i++){
            if(new_title.indexOf(sensitiveCon[i]) != -1){
                layer.msg('发现敏感词【'+sensitiveCon[i]+'】');
                return;
            }
        }

        $(this).parents('.IntSingle').find('.product_title').hide();
        $(this).parents('.IntSingle').find('a').show().text(new_title);
        $(this).text('修改标题');
    }
});

// 段落描述敏感词检测
$(document).on('keyup','.textareaDes',function () {
    var des=$(this).val();
    var sensitiveCon=localStorage.getItem('sensitiveCon');
    sensitiveCon=sensitiveCon.split(',');
    for(var i = 0; i< sensitiveCon.length; i++){
        if(des.indexOf(sensitiveCon[i]) != -1){
            $(this).parents('.IntSingle').find('.findSensitive').text('发现敏感词【'+sensitiveCon[i]+'】');
            return;
        }
        else{
            $(this).parents('.IntSingle').find('.findSensitive').text('');
        }
    }
})

// 产品卡标题敏感词检测
$(document).on('keyup','.product_title',function () {
    var des=$(this).val();
    var sensitiveCon=localStorage.getItem('sensitiveTitle');
    sensitiveCon=sensitiveCon.split(',');
    if(des.length>20 || des.length<6){
        layer.msg('产品标题应在6-20个字');
        return;
    }
    for(var i = 0; i< sensitiveCon.length; i++){
        if(des.indexOf(sensitiveCon[i]) != -1){
            $(this).parents('.IntSingle').find('.findSensitive').text('发现敏感词【'+sensitiveCon[i]+'】');
            return;
        }
        else{
            $(this).parents('.IntSingle').find('.findSensitive').text('');
        }
    }
})

// 生成模板
$('html body').on('click','.modelBtn',function () {
    var line;
    if($('.lineBox img').attr('src')!='undefine'){
        var lineSrc=$('.lineBox img').attr('src');
        line='<img class="lineImgSin" src="'+lineSrc+'">';
    }
    else{
        line='<img class="lineImgSin">';
    }

    var productNum=$('.productNum').val();
    var modelNum=productNum/2;
    var html='';
    for (var i=0;i<modelNum;i++){
        html+=
            '<div class="IntSingle" style="height: 94px">' +
            '<p class="IntHead">分割线<span class="delBtn">X</span></p>' +
            '<div class="IntContent">' +line+
            '</div>'+
            '</div>'+
            '<div class="IntSingle">' +
            '<p class="IntHead">段落图片<span class="delBtn">X</span></p>' +
            '<div class="IntContent">' +
            '<button type="button" class="btn btn-primary cardAddImgBtn">添加图片</button>' +
            '</div>'+
            '</div>'+
            '<div class="IntSingle">' +
            '<p class="IntHead">段落图片<span class="delBtn">X</span></p>' +
            '<div class="IntContent">' +
            '<button type="button" class="btn btn-primary cardAddImgBtn">添加图片</button>' +
            '</div>'+
            '</div>'+
            '<div class="IntSingle">' +
                '<p class="IntHead">段落导语<span class="delBtn">X</span></p>' +
                '<div class="IntSingleBox">' +
                    '<div class="textareaBox">' +
                        '<textarea class="form-control textareaDes" rows="4" placeholder="请输入10～100个汉字的导语"></textarea>' +
                        '<span class="des_tip">0/100</span>' +
                    '</div>' +
                    '<button type="button" class="btn btn-primary getDesBtn">获取描述</button>' +
                '</div>'+
            '</div>'+
            '<div class="IntSingle">' +
            '<p class="IntHead">产品卡<span class="delBtn">X</span></p>' +
            '<div class="IntContent">' +
            '<button type="button" class="btn btn-primary cardAddBabyBtn">添加宝贝</button>' +
            '</div>'+
            '</div>';
        if(productNum%2==0 || i<(modelNum-1)){
            html+=
                '<div class="IntSingle">' +
                '<p class="IntHead">产品卡<span class="delBtn">X</span></p>' +
                '<div class="IntContent">' +
                '<button type="button" class="btn btn-primary cardAddBabyBtn">添加宝贝</button>' +
                '</div>'+
                '</div>';
        }

    }
    var intLen=$('.IntSingle').length;
    if(intLen>0){
        layer.confirm(
            '是否重新生成模板？',
            {
                btn: ['重新生成','追加模板']
            },function (index) {
                $('#sortable').empty();
                layer.close(index);
                $('#sortable').append(html);
            },function (index) {
                layer.close(index);
                $('#sortable').append(html);
            }
        );
    }
    else{
        $('#sortable').append(html);
    }
})

$(document).on('click','.cardAddImg',function () {
    var $IntContent=$(this).parents('.IntContent');
    var addImgModel='<div class="addImgModel">\n' +
        '\t\t\t<button type="button" class="btn btn-primary selImgBtn">选择图片</button>\n' +
        '\t\t\t<button type="button" class="btn btn-success sureImgBtn">确定</button>\n' +
        '\t\t\t<button type="button" class="btn btn-warning closeImgBtn">取消</button>\n' +
        '\t\t\t<div class="head">\n' +
        '\t\t\t\t<img id="targetImg" />\n' +
        '\t\t\t\t<input type="file" id="fileImg" style="display: none;"/>\n' +
        '\t\t\t</div>\n' +
        '\t\t</div>';
    $('html body').append(addImgModel);
    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        // 使用的jquery对象
        $targetImg = $('#targetImg');

    $('.addImgModel .selImgBtn').click(function () {
        openBrowseImg()
    });

    $('.addImgModel .sureImgBtn').click(function () {
        if(typeof($('#targetImg').attr('src'))=="undefined"){
            layer.msg('请选择图片进行裁剪');
            return;
        }
        var img = new Image();
        img.src = $('#targetImg').attr('src');
        var realWidth = img.width;
        var realHeight = img.height;

        var showWidth=$('#targetImg').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#targetImg').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);

        // 真实图片和显示图片的宽比  高比
        var ratio=realWidth/showWidth;

        var width=$('.addImgModel .jcrop-holder>div').css('width');
        if(width=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        width=width.split('px');
        width=parseInt(width[0])*ratio;
        var height=$('.addImgModel .jcrop-holder>div').css('height');
        if(height=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        height=height.split('px');
        height=parseInt(height[0])*ratio;
        var top=$('.addImgModel .jcrop-holder>div').css('top');
        top=top.split('px');
        top=0-parseInt(top[0])*ratio;
        var left=$('.addImgModel .jcrop-holder>div').css('left');
        left=left.split('px');
        left=0-parseInt(left[0])*ratio;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        canvas.width = width;
        canvas.height = height;

        img.onload = function() {
            this.width = realWidth;
            this.height = realHeight;
            ctx.drawImage(this, left, top, this.width, this.height);
            base64 = canvas.toDataURL('image/jpeg', 1);
            $('.addImgModel').remove();
            var imgBoxHtml= '<img class="imgSingle" src="'+base64+'"/>' +
                            '<button type="button" class="btn btn-warning changeImgBtn">更换图片</button>';
            $IntContent.html(imgBoxHtml);
        }

    });
    $('.addImgModel .closeImgBtn').click(function () {
        $('.addImgModel').remove();
    });

    $('.addImgModel #fileImg').change(function(){
        changeFileImg()
    });

    //1、打开浏览器
    function openBrowseImg(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("fileImg").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("fileImg").dispatchEvent(a);
        }
    }
    //2、从 file 域获取 本地图片 url
    function getFileUrlImg(sourceId) {
        var url;
        if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
            url = document.getElementById(sourceId).value;
        } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Safari")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        }
        return url;
    }
    //选择文件事件
    function changeFileImg() {
        var url = getFileUrlImg("fileImg");//根据id获取文件路径
        preImgImg(url);
        return false;
    }

    //3、将本地图片 显示到浏览器上
    function preImgImg(url) {

        console.log('url===' + url);
        //图片裁剪逻辑
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }

        //初始化图片
        initTargetImg();
        var image = document.getElementById('targetImg');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;

                //获取图片真实高度之后
                initJcropImg();//初始化Jcrop插件
                //initCanvasImg();//初始化Canvas内容
            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.Jcrop({
            //onChange: updatePreviewImg,
            //onSelect: updatePreviewImg
            // aspectRatio: 513 / 513
        },function(){
            //初始化后回调函数
            // 获取图片实际显示的大小
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度

            // 保存jcrop_api变量
            jcrop_api = this;

        });
    }

    //初始化预览div内容
    function initTargetImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }
})

//添加段落图片
$(document).on('click','.cardAddImgBtn',function () {
    var $IntContent=$(this).parents('.IntContent');
    layer.open({
        type: 1,
        title: "添加图片", //不显示标题
        area:['80%','100%'],
        shade: [0.8, '#393D49'],
        shadeClose:false,
        content: content,
        closeBtn:0,
        btn: ['确认','取消'],
        yes:function(index, layero){
            if($('#imgTab li:eq(0)').hasClass('active')) {
                var imgSrc;
                var checkedLen=$('input[name="imgCheck"]:checked').length;
                if(checkedLen==0){
                    layer.msg('请选择图片')
                }
                else if(checkedLen==1){
                    imgSrc=$('input[name="imgCheck"]:checked').parents('tr').find('img').attr('src');
                    var imgBoxHtml = '<img class="imgSingle" src="' + imgSrc + '"/>' +
                        // '<button type="button" class="btn btn-info changeImgBtn">更换图片</button>' +
                        '<button type="button" class="btn btn-primary btn-sm changeImgBtn">\n' +
                        '  <span class="glyphicon glyphicon-pencil"></span>' +
                        '</button>'+
                        '<button type="button" class="btn btn-primary btn-sm cutImgBtn">\n' +
                        '  <span class="glyphicon glyphicon-scissors"></span>' +
                        '</button>';
                    $IntContent.html(imgBoxHtml);
                    layer.close(index);
                }
                else if(checkedLen==2 || checkedLen==3){
                    var imgList=[];
                    for(var i=0;i<checkedLen;i++){
                        $('input[name="imgCheck"]:checked').eq(i).parents('tr').find('img').attr('id','checkedImg'+i);
                        var img=$('input[name="imgCheck"]:checked').eq(i).parents('tr').find('img').attr('src');
                        imgList.push(img);
                    }
                    if(imgList.length==2 || imgList.length==3){
                        $('#imgTab li:eq(0)').removeClass('active');
                        $('#imgTab li:eq(2)').addClass('active');
                        $('.tab-content .tab-pane:eq(0)').removeClass('active');
                        $('.tab-content .tab-pane:eq(0)').removeClass('in');
                        $('.tab-content .tab-pane:eq(2)').addClass('active');
                        $('.tab-content .tab-pane:eq(2)').addClass('in');
                        $('#pieceTargetImg1').attr('src',imgList[0]);
                        $('#pieceTargetImg2').attr('src',imgList[1]);
                        $('.layui-layer-btn0', parent.document).text('确认');
                    }
                    if(imgList.length==3){
                        $('#pieceTargetImg3').attr('src',imgList[2]);
                    }
                }
                else{
                    layer.msg('选择的图片不能多于3张')
                }
            }
            else if($('#imgTab li:eq(1)').hasClass('active')) {
                if (typeof($('#targetImg').attr('src')) == "undefined") {
                    layer.msg('请选择图片进行裁剪');
                    return;
                }
                var img = new Image();
                img.src = $('#targetImg').attr('src');
                var realWidth = img.width;
                var realHeight = img.height;

                var showWidth = $('#targetImg').css('width');
                showWidth = showWidth.split('px');
                showWidth = parseInt(showWidth[0]);
                var showHeight = $('#targetImg').css('height');
                showHeight = showHeight.split('px');
                showHeight = parseInt(showHeight[0]);

                // 真实图片和显示图片的宽比  高比
                var ratio = realWidth / showWidth;

                var width = $('.uploadImgModel .jcrop-holder>div').css('width');
                if (width == '0px') {
                    layer.msg('请裁剪图片再点击确定');
                    return;
                }
                width = width.split('px');
                width = parseInt(width[0]) * ratio;
                var height = $('.uploadImgModel .jcrop-holder>div').css('height');
                if (height == '0px') {
                    layer.msg('请裁剪图片再点击确定');
                    return;
                }
                height = height.split('px');
                height = parseInt(height[0]) * ratio;
                var top = $('.uploadImgModel .jcrop-holder>div').css('top');
                top = top.split('px');
                top = 0 - parseInt(top[0]) * ratio;
                var left = $('.uploadImgModel .jcrop-holder>div').css('left');
                left = left.split('px');
                left = 0 - parseInt(left[0]) * ratio;
                var canvas = document.createElement("canvas");
                var ctx = canvas.getContext('2d');
                var base64;
                canvas.width = width;
                canvas.height = height;

                img.onload = function () {
                    this.width = realWidth;
                    this.height = realHeight;
                    ctx.drawImage(this, left, top, this.width, this.height);
                    base64 = canvas.toDataURL('image/jpeg', 1);
                    $.post(
                        '/admin/toutiao/save_img',
                        {
                            img:base64,
                            _token :  $("input[name='_token']").val()
                        },
                        function (res) {
                            res=JSON.parse(res);
                            console.log(res.url);
                            var imgBoxHtml = '<img class="imgSingle" src="' + res.url + '" />' +
                                '<button type="button" class="btn btn-primary btn-sm changeImgBtn">\n' +
                                '  <span class="glyphicon glyphicon-pencil"></span>' +
                                '</button>'+
                                '<button type="button" class="btn btn-primary btn-sm cutImgBtn">\n' +
                                '  <span class="glyphicon glyphicon-scissors"></span>' +
                                '</button>';
                            $IntContent.html(imgBoxHtml);
                            layer.close(index);
                        }
                    )
                }
            }
            else if($('#imgTab li:eq(2)').hasClass('active')) {
                var base64=$('#previewImg').attr('src');
                $.post(
                    '/admin/toutiao/save_img',
                    {
                        img:base64,
                        _token :  $("input[name='_token']").val()
                    },
                    function (res) {
                        res=JSON.parse(res);
                        console.log(res.url);
                        var imgBoxHtml = '<img class="imgSingle" src="' + res.url + '"/>' +
                            '<button type="button" class="btn btn-primary btn-sm changeImgBtn">\n' +
                            '  <span class="glyphicon glyphicon-pencil"></span>' +
                            '</button>'+
                            '<button type="button" class="btn btn-primary btn-sm cutImgBtn">\n' +
                            '  <span class="glyphicon glyphicon-scissors"></span>' +
                            '</button>';
                        $IntContent.html(imgBoxHtml);
                        layer.close(index);
                    }
                )
            }

        }
    });
    showImgModel();
})
//添加图片--更换图片
$(document).on('click','.IntSingle .changeImgBtn',function () {
    var $imgSingle=$(this).siblings('.imgSingle');
    layer.open({
        type: 1,
        title: "添加图片", //不显示标题
        area:['80%','100%'],
        shade: [0.8, '#393D49'],
        shadeClose:false,
        content: content,
        closeBtn:0,
        btn: ['确认','取消'],
        yes:function(index, layero){
            if($('#imgTab li:eq(0)').hasClass('active')) {
                var imgSrc;
                var checkedLen=$('input[name="imgCheck"]:checked').length;
                if(checkedLen==0){
                    layer.msg('请选择图片')
                }
                else if(checkedLen==1){
                    imgSrc=$('input[name="imgCheck"]:checked').parents('tr').find('img').attr('src');
                    $imgSingle.attr('src',imgSrc);
                    layer.close(index);
                }
                else if(checkedLen==2 || checkedLen==3){
                    var imgList=[];
                    for(var i=0;i<checkedLen;i++){
                        $('input[name="imgCheck"]:checked').eq(i).parents('tr').find('img').attr('id','checkedImg'+i);
                        var img=$('input[name="imgCheck"]:checked').eq(i).parents('tr').find('img').attr('src');
                        imgList.push(img);
                    }
                    if(imgList.length==2 || imgList.length==3){
                        $('#imgTab li:eq(0)').removeClass('active');
                        $('#imgTab li:eq(2)').addClass('active');
                        $('.tab-content .tab-pane:eq(0)').removeClass('active');
                        $('.tab-content .tab-pane:eq(0)').removeClass('in');
                        $('.tab-content .tab-pane:eq(2)').addClass('active');
                        $('.tab-content .tab-pane:eq(2)').addClass('in');
                        $('#pieceTargetImg1').attr('src',imgList[0]);
                        $('#pieceTargetImg2').attr('src',imgList[1]);
                        $('.layui-layer-btn0', parent.document).text('确认');
                    }
                    if(imgList.length==3){
                        $('#pieceTargetImg3').attr('src',imgList[2]);
                    }
                }
                else{
                    layer.msg('选择的图片不能多于3张')
                }
            }
            else if($('#imgTab li:eq(1)').hasClass('active')) {
                if (typeof($('#targetImg').attr('src')) == "undefined") {
                    layer.msg('请选择图片进行裁剪');
                    return;
                }
                var img = new Image();
                img.src = $('#targetImg').attr('src');
                var realWidth = img.width;
                var realHeight = img.height;

                var showWidth = $('#targetImg').css('width');
                showWidth = showWidth.split('px');
                showWidth = parseInt(showWidth[0]);
                var showHeight = $('#targetImg').css('height');
                showHeight = showHeight.split('px');
                showHeight = parseInt(showHeight[0]);

                // 真实图片和显示图片的宽比  高比
                var ratio = realWidth / showWidth;

                var width = $('.uploadImgModel .jcrop-holder>div').css('width');
                if (width == '0px') {
                    layer.msg('请裁剪图片再点击确定');
                    return;
                }
                width = width.split('px');
                width = parseInt(width[0]) * ratio;
                var height = $('.uploadImgModel .jcrop-holder>div').css('height');
                if (height == '0px') {
                    layer.msg('请裁剪图片再点击确定');
                    return;
                }
                height = height.split('px');
                height = parseInt(height[0]) * ratio;
                var top = $('.uploadImgModel .jcrop-holder>div').css('top');
                top = top.split('px');
                top = 0 - parseInt(top[0]) * ratio;
                var left = $('.uploadImgModel .jcrop-holder>div').css('left');
                left = left.split('px');
                left = 0 - parseInt(left[0]) * ratio;
                var canvas = document.createElement("canvas");
                var ctx = canvas.getContext('2d');
                var base64;
                canvas.width = width;
                canvas.height = height;

                img.onload = function () {
                    this.width = realWidth;
                    this.height = realHeight;
                    ctx.drawImage(this, left, top, this.width, this.height);
                    base64 = canvas.toDataURL('image/jpeg', 1);
                    $.post(
                        '/admin/toutiao/save_img',
                        {
                            img:base64,
                            _token :  $("input[name='_token']").val()
                        },
                        function (res) {
                            res=JSON.parse(res);
                            console.log(res.url);
                            $imgSingle.attr('src',res.url);
                            layer.close(index);
                        }
                    )
                }
            }
            else if($('#imgTab li:eq(2)').hasClass('active')) {
                var base64=$('#previewImg').attr('src');
                $.post(
                    '/admin/toutiao/save_img',
                    {
                        img:base64,
                        _token :  $("input[name='_token']").val()
                    },
                    function (res) {
                        res=JSON.parse(res);
                        console.log(res.url);
                        $imgSingle.attr('src',res.url);
                        layer.close(index);
                    }
                )
            }

        }
    });
    showImgModel();
})
//添加图片--裁剪图片
$(document).on('click','.IntSingle .cutImgBtn', function () {
    var $imgSingle=$(this).siblings('.imgSingle');
    cropImgFn($imgSingle);
});

//添加产品卡
$(document).on('click','.cardAddBabyBtn',function () {
    var $IntContent=$(this).parents('.IntContent');
    var url = '/admin/toutiao/get_goods_data_view';
    layer.open({
        type: 2,
        title: "添加宝贝",
        area:['80%','100%'],
        shade: [0.8, '#393D49'],
        shadeClose:false,
        content: url,
        closeBtn:0,
        btn: ['确认','取消'],
        yes:function(index, layero){
            var res = window["layui-layer-iframe" + index].callbackdata();
            var intHtml=
                '<div class="ul_img_box" style="display: none">'+res.img_box+'</div>'+
                '<div class="div_left"><img src="'+res.img+'" class="goods_img"/><span class="change_img">更换图片</span></div>'+
                '<div class="div_center">' +
                '<div><a href="'+res.url+'" target="_blank"><input type="hidden" class="goods_url" value="'+res.url+'"/><span class="title">'+res.title+'</span></a></div>'+
                '<div><span>￥</span><span class="price">'+res.price+'</span></div>'+
                '<div><span class="shop_name">'+res.shop_name+'</span></div>'+
                '</div>'+
                '<button type="button" class="btn btn-default changeProductBtn">更换产品</button>';
            $IntContent.html(intHtml);
            layer.close(index);

        }
    });
});

//更换产品
$(document).on('click','.changeProductBtn',function () {
    var $IntContent=$(this).parents('.IntContent');
    var url = '/admin/toutiao/get_goods_data_view';
    layer.open({
        type: 2,
        title: "添加宝贝",
        area:['80%','100%'],
        shade: [0.8, '#393D49'],
        shadeClose:false,
        content: url,
        closeBtn:0,
        btn: ['确认','取消'],
        yes:function(index, layero){
            var res = window["layui-layer-iframe" + index].callbackdata();
            $IntContent.find('.ul_img_box').html(res.img_box);
            $IntContent.find('img').attr('src',res.img);
            $IntContent.find('a').text(res.title);
            $IntContent.find('a').attr('href',res.url);
            $IntContent.find('.price').text(res.price);
            $IntContent.find('.shop_name').text(res.shop_name);
            layer.close(index);

        }
    });
});

//分割线
$(document).on('click','.lineBtn',function () {
    var content='<ul class="lineUl">'+
                    '<li><img src="http://p3a.pstatp.com/large/1f7a00011c5c6e4a259e"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7700011f8c20db3b29"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7a0001206f6b39453a"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7a0001208841c25f69"></li>'+

        '<li><img src="http://p3a.pstatp.com/large/1f7a000120a25e02c8b2"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7a000120cc70fa8fdf"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7900011ff28caa449d"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f79000122e187d3f9a5"></li>'+

        '<li><img src="http://p3a.pstatp.com/large/1f79000124f9c78620f0"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f77000127ed4e84a22a"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f77000127fc2ccf88e9"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7a000128dfdcd131de"></li>'+

        '<li><img src="http://p3a.pstatp.com/large/1f7a00012c6abf228cfa"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f79000128b7d52594bb"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7900012981d473c944"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7a00012dc141df0d18"></li>'+

        '<li><img src="http://p3a.pstatp.com/large/1f7700012f1f6535ed61"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7a00013029745e1eb3"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7a000131229e0b6704"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7a00013152f52a4d8a"></li>'+

        '<li><img src="http://p3a.pstatp.com/large/1f770001312c5f566959"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7a000132146bc45ada"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7900012f75521df20b"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7a0001345bcfd3c01f"></li>'+

        '<li><img src="http://p3a.pstatp.com/large/1f79000131058bb7f42f"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7900013118e6b7ed6e"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f7900013151b0e49725"></li>'+
        '<li><img src="http://p3a.pstatp.com/large/1f79000133b64a5a3cff"></li>'+
                '</ul>';
    layer.open({
        type: 1,
        title: "分割线", //不显示标题
        area:['80%','80%'],
        shade: [0.8, '#393D49'],
        shadeClose:false,
        content: content,
        closeBtn:0,
        btn: ['确认','取消'],
        yes:function(index, layero){
            var lilen=$('.lineUl li').length;
            for(var i=0;i<lilen;i++){
                if($('.lineUl li:eq('+i+')').hasClass('select')){
                    var lineSrc=$('.lineUl li:eq('+i+') img').attr('src');
                    $('.lineBox img').attr('src',lineSrc);
                    break;
                }
            }
            $('.lineImgSin').attr('src',lineSrc);
            layer.close(index);
        }
    });
    $(document).on('click','.lineUl li',function () {
        $(this).addClass('select').siblings('li').removeClass('select');
    })
})

//刷新预览
$(document).on('click','.refreshBtn',function () {
    var title=$('#titleInp').val();
    var leads=$('.leads').val();
    var t_img;
    if($('.firstImg img').length>0){
        var firstImg=$('.firstImg img').attr('src');
        t_img='<img src="'+firstImg+'">';
    }

    if(title==''){
        layer.msg('请填写标题');
        return;
    }
    else if (title.length<4){
        layer.msg('标题不能少于4个字');
        return;
    }
    else if (title.length>19){
        layer.msg('标题不能多于19个字');
        return;
    }

    if(leads==''){
        layer.msg('请填写导语');
        return;
    }
    else if (leads.length<10){
        layer.msg('导语不能少于10个字');
        return;
    }
    else if (leads.length>100){
        layer.msg('导语不能多于100个字');
        return;
    }
    var len=$('#sortable .IntSingle').length;
    var content=[];
    for (var i=0;i<len;i++){
        var single;
        var addType=$('#sortable .IntSingle:eq('+i+') .IntHead').text();
        if(addType.indexOf('图片')!=-1){
            single={
                type:2,
                img:$('#sortable .IntSingle:eq('+i+') img').attr('src'),
                describe:'',
                link:'',
                price:'',
                goods_name:'',
                shop_name:''

            }
        }
        else if(addType.indexOf('分割线')!=-1){
            single={
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
            }
            else if (describe.length<10){
                layer.msg('段落导语不能少于10个字');
            }
            else if (describe.length>100){
                layer.msg('段落导语不能多于100个字');
            }
            single={
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
            // var describe=$('#sortable .IntSingle:eq('+i+') textarea').val();
            // if(describe!=''&&(describe.length<10||describe.length>100)){
            //     layer.msg('产品卡的描述必须在10-100字之间');
            // }
            single={
                type:4,
                img:$('#sortable .IntSingle:eq('+i+') .div_left img').attr('src'),
                describe:'',
                // describe:$('#sortable .IntSingle:eq('+i+') .div_right textarea').val(),
                link:$('#sortable .IntSingle:eq('+i+') a').attr('href'),
                price:$('#sortable .IntSingle:eq('+i+') .price').text(),
                goods_name:$('#sortable .IntSingle:eq('+i+') a').text(),
                shop_name:$('#sortable .IntSingle:eq('+i+') .shop_name').text()
            }
        }
        content.push(single);
    }
    var article_content='';
    for (var i=0;i<len;i++){

        if(content[i].type==2 || content[i].type==5){
            article_content+= '<div class="article_img">' +
                '<img  class="tt-img" src="'+content[i].img+'" />' +
                '</div>' ;
        }
        else if(content[i].type==1){
            article_content+= '<div class="article_des">' +
                '<div class="tt-des">'+content[i].describe+'</div>' +
                '</div>' ;
        }
        else if(content[i].type==4){
            article_content+= '<div class="article_card">' +
                '<div class="tt-card">'+
                '<div class="tt-card-left">'+
                '<img  class="tt-img" src="'+content[i].img+'" />' +
                '</div>' +
                '<div class="tt-card-right">'+
                '<a class="tt-link" href="'+content[i].link+'" target="_blank">'+content[i].goods_name+ '</a>' +
                '<p class="tt-price" >￥'+content[i].price+ '</p>' +
                '</div>' +
                '</div>' +
                '</div>' ;
        }
    }

    $('.refresh-preview .tt-title').text(title);
    $('.refresh-preview .tt-first-img').html(t_img);
    $('.refresh-preview .tt-leads').text(leads);
    $('.refresh-preview .tt-content').html(article_content);
})

//刷新预览-特卖专辑
$(document).on('click','.refreshBtn_tm',function () {
    var title=$('#article_title').val();
    var leads=$('.leads').val();


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
    else if (leads.length<10){
        layer.msg('导语不能少于10个字');
        return;
    }
    // else if (leads.length>100){
    //     layer.msg('导语不能多于100个字');
    //     return;
    // }
    var len=$('#sortable .IntSingle').length;
    var content=[];
    for (var i=0;i<len;i++){
        var single;
        var addType=$('#sortable .IntSingle:eq('+i+') .IntHead').text();
        if(addType.indexOf('图片')!=-1){
            single={
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
            }
            else if (describe.length<10){
                layer.msg('段落导语不能少于10个字');
            }
            // else if (describe.length>100){
            //     layer.msg('段落导语不能多于100个字');
            // }
            single={
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
    var article_content='';
    for (var i=0;i<len;i++){

        if(content[i].type==2 || content[i].type==5){
            article_content+= '<div class="article_img">' +
                '<img  class="tt-img" src="'+content[i].img+'" />' +
                '</div>' ;
        }
        else if(content[i].type==1){
            article_content+= '<div class="article_des">' +
                '<div class="tt-des">'+content[i].describe+'</div>' +
                '</div>' ;
        }
        else if(content[i].type==4){
            article_content+= '<div class="article_card">' +
                '<div class="tt-card">'+
                '<div class="tt-card-left">'+
                '<img  class="tt-img" src="'+content[i].img+'" />' +
                '</div>' +
                '<div class="tt-card-right">'+
                '<a class="tt-link" href="'+content[i].link+'" target="_blank">'+content[i].goods_name+ '</a>' +
                '<p class="tt-price" >￥'+content[i].price+ '</p>' +
                '</div>' +
                '</div>' +
                '</div>' ;
        }
    }

    $('.refresh-preview .tt-title').text(title);
    $('.refresh-preview .tt-first-img').html('<img src="'+firstImg+'">');
    $('.refresh-preview .tt-leads').text(leads);
    $('.refresh-preview .tt-content').html(article_content);
})

//添加首图
$(document).on('click','.AddFirstImg',function () {
    layer.open({
        type: 1,
        title: "添加图片", //不显示标题
        area:['80%','100%'],
        shade: [0.8, '#393D49'],
        shadeClose:false,
        content: content,
        closeBtn:0,
        btn: ['确认','取消'],
        yes:function(index, layero){
            if($('#imgTab li:eq(0)').hasClass('active')) {
                var imgSrc;
                var checkedLen=$('input[name="imgCheck"]:checked').length;
                if(checkedLen==0){
                    layer.msg('请选择图片')
                }
                else if(checkedLen==1){
                    imgSrc=$('input[name="imgCheck"]:checked').parents('tr').find('img').attr('src');
                    var imgBoxHtml = '<img class="imgSingle" src="' + imgSrc + '" />' +
                        '<button type="button" class="btn btn-primary btn-sm changeImgBtn">\n' +
                        '  <span class="glyphicon glyphicon-pencil"></span>' +
                        '</button>'+
                        '<button type="button" class="btn btn-primary btn-sm cutImgBtn">\n' +
                        '  <span class="glyphicon glyphicon-scissors"></span>' +
                        '</button>';
                    $('.firstImg').html(imgBoxHtml);
                    layer.close(index);
                }
                else if(checkedLen==2 || checkedLen==3){
                    var imgList=[];
                    for(var i=0;i<checkedLen;i++){
                        $('input[name="imgCheck"]:checked').eq(i).parents('tr').find('img').attr('id','checkedImg'+i);
                        $('input[name="imgCheck"]:checked').eq(i).parents('tr').find('img').attr('crossOrigin', 'anonymous');
                        var imgSrc=$('input[name="imgCheck"]:checked').eq(i).parents('tr').find('img').attr('src');
                        imgList.push(imgSrc);
                    }
                    if(imgList.length==2 || imgList.length==3){
                        $('#imgTab li:eq(0)').removeClass('active');
                        $('#imgTab li:eq(2)').addClass('active');
                        $('.tab-content .tab-pane:eq(0)').removeClass('active');
                        $('.tab-content .tab-pane:eq(0)').removeClass('in');
                        $('.tab-content .tab-pane:eq(2)').addClass('active');
                        $('.tab-content .tab-pane:eq(2)').addClass('in');
                        $('#pieceTargetImg1').attr('src',imgList[0]);
                        $('#pieceTargetImg2').attr('src',imgList[1]);
                        $('.layui-layer-btn0', parent.document).text('确认');
                    }
                    if(imgList.length==3){
                        $('#pieceTargetImg3').attr('src',imgList[2]);
                    }
                }
                else{
                    layer.msg('选择的图片不能多于3张')
                }
            }
            else if($('#imgTab li:eq(1)').hasClass('active')) {
                if (typeof($('#targetImg').attr('src')) == "undefined") {
                    layer.msg('请选择图片进行裁剪');
                    return;
                }
                var img = new Image();
                img.src = $('#targetImg').attr('src');
                var realWidth = img.width;
                var realHeight = img.height;

                var showWidth = $('#targetImg').css('width');
                showWidth = showWidth.split('px');
                showWidth = parseInt(showWidth[0]);
                var showHeight = $('#targetImg').css('height');
                showHeight = showHeight.split('px');
                showHeight = parseInt(showHeight[0]);

                // 真实图片和显示图片的宽比  高比
                var ratio = realWidth / showWidth;

                var width = $('.uploadImgModel .jcrop-holder>div').css('width');
                if (width == '0px') {
                    layer.msg('请裁剪图片再点击确定');
                    return;
                }
                width = width.split('px');
                width = parseInt(width[0]) * ratio;
                var height = $('.uploadImgModel .jcrop-holder>div').css('height');
                if (height == '0px') {
                    layer.msg('请裁剪图片再点击确定');
                    return;
                }
                height = height.split('px');
                height = parseInt(height[0]) * ratio;
                var top = $('.uploadImgModel .jcrop-holder>div').css('top');
                top = top.split('px');
                top = 0 - parseInt(top[0]) * ratio;
                var left = $('.uploadImgModel .jcrop-holder>div').css('left');
                left = left.split('px');
                left = 0 - parseInt(left[0]) * ratio;
                var canvas = document.createElement("canvas");
                var ctx = canvas.getContext('2d');
                var base64;
                canvas.width = width;
                canvas.height = height;

                img.onload = function () {
                    this.width = realWidth;
                    this.height = realHeight;
                    ctx.drawImage(this, left, top, this.width, this.height);
                    base64 = canvas.toDataURL('image/jpeg', 1);
                    $.post(
                        '/admin/toutiao/save_img',
                        {
                            img:base64,
                            _token :  $("input[name='_token']").val()

                        },
                        function (res) {
                            res=JSON.parse(res);
                            console.log(res.url);
                            var imgBoxHtml = '<img class="imgSingle" src="' + res.url + '" />' +
                                '<button type="button" class="btn btn-primary btn-sm changeImgBtn">\n' +
                                '  <span class="glyphicon glyphicon-pencil"></span>' +
                                '</button>'+
                                '<button type="button" class="btn btn-primary btn-sm cutImgBtn">\n' +
                                '  <span class="glyphicon glyphicon-scissors"></span>' +
                                '</button>';
                            $('.firstImg').html(imgBoxHtml);
                            layer.close(index);
                        }
                    )
                }
            }
            else if($('#imgTab li:eq(2)').hasClass('active')) {
                var base64=$('#previewImg').attr('src');
                $.post(
                    '/admin/toutiao/save_img',
                    {
                        img:base64,
                        _token :  $("input[name='_token']").val()
                    },
                    function (res) {
                        res=JSON.parse(res);
                        console.log(res.url);
                        var imgBoxHtml = '<img class="imgSingle" src="' + res.url + '"/>' +
                            '<button type="button" class="btn btn-primary btn-sm changeImgBtn">\n' +
                            '  <span class="glyphicon glyphicon-pencil"></span>' +
                            '</button>'+
                            '<button type="button" class="btn btn-primary btn-sm cutImgBtn">\n' +
                            '  <span class="glyphicon glyphicon-scissors"></span>' +
                            '</button>';
                        $('.firstImg').html(imgBoxHtml);
                        layer.close(index);
                    }
                )
            }

        }
    });
    showImgModel();
})

//添加首图--更换图片
$(document).on('click','.firstImg .changeImgBtn',function () {
    layer.open({
        type: 1,
        title: "添加图片", //不显示标题
        area:['80%','100%'],
        shade: [0.8, '#393D49'],
        shadeClose:false,
        content: content,
        closeBtn:0,
        btn: ['确认','取消'],
        yes:function(index, layero){
            if($('#imgTab li:eq(0)').hasClass('active')) {
                var imgSrc;
                var checkedLen=$('input[name="imgCheck"]:checked').length;
                if(checkedLen==0){
                    layer.msg('请选择图片')
                }
                else if(checkedLen==1){
                    imgSrc=$('input[name="imgCheck"]:checked').parents('tr').find('img').attr('src');
                    $('.firstImg img').attr('src',imgSrc);
                    layer.close(index);
                }
                else if(checkedLen==2 || checkedLen==3){
                    var imgList=[];
                    for(var i=0;i<checkedLen;i++){
                        $('input[name="imgCheck"]:checked').eq(i).parents('tr').find('img').attr('id','checkedImg'+i);
                        $('input[name="imgCheck"]:checked').eq(i).parents('tr').find('img').attr('crossOrigin', 'anonymous');
                        var imgSrc=$('input[name="imgCheck"]:checked').eq(i).parents('tr').find('img').attr('src');
                        imgList.push(imgSrc);
                    }
                    if(imgList.length==2 || imgList.length==3){
                        $('#imgTab li:eq(0)').removeClass('active');
                        $('#imgTab li:eq(2)').addClass('active');
                        $('.tab-content .tab-pane:eq(0)').removeClass('active');
                        $('.tab-content .tab-pane:eq(0)').removeClass('in');
                        $('.tab-content .tab-pane:eq(2)').addClass('active');
                        $('.tab-content .tab-pane:eq(2)').addClass('in');
                        $('#pieceTargetImg1').attr('src',imgList[0]);
                        $('#pieceTargetImg2').attr('src',imgList[1]);
                        $('.layui-layer-btn0', parent.document).text('确认');
                    }
                    if(imgList.length==3){
                        $('#pieceTargetImg3').attr('src',imgList[2]);
                    }
                }
                else{
                    layer.msg('选择的图片不能多于3张')
                }
            }
            else if($('#imgTab li:eq(1)').hasClass('active')) {
                if (typeof($('#targetImg').attr('src')) == "undefined") {
                    layer.msg('请选择图片进行裁剪');
                    return;
                }
                var img = new Image();
                img.src = $('#targetImg').attr('src');
                var realWidth = img.width;
                var realHeight = img.height;

                var showWidth = $('#targetImg').css('width');
                showWidth = showWidth.split('px');
                showWidth = parseInt(showWidth[0]);
                var showHeight = $('#targetImg').css('height');
                showHeight = showHeight.split('px');
                showHeight = parseInt(showHeight[0]);

                // 真实图片和显示图片的宽比  高比
                var ratio = realWidth / showWidth;

                var width = $('.uploadImgModel .jcrop-holder>div').css('width');
                if (width == '0px') {
                    layer.msg('请裁剪图片再点击确定');
                    return;
                }
                width = width.split('px');
                width = parseInt(width[0]) * ratio;
                var height = $('.uploadImgModel .jcrop-holder>div').css('height');
                if (height == '0px') {
                    layer.msg('请裁剪图片再点击确定');
                    return;
                }
                height = height.split('px');
                height = parseInt(height[0]) * ratio;
                var top = $('.uploadImgModel .jcrop-holder>div').css('top');
                top = top.split('px');
                top = 0 - parseInt(top[0]) * ratio;
                var left = $('.uploadImgModel .jcrop-holder>div').css('left');
                left = left.split('px');
                left = 0 - parseInt(left[0]) * ratio;
                var canvas = document.createElement("canvas");
                var ctx = canvas.getContext('2d');
                var base64;
                canvas.width = width;
                canvas.height = height;

                img.onload = function () {
                    this.width = realWidth;
                    this.height = realHeight;
                    ctx.drawImage(this, left, top, this.width, this.height);
                    base64 = canvas.toDataURL('image/jpeg', 1);
                    $.post(
                        '/admin/toutiao/save_img',
                        {
                            img:base64,
                            _token :  $("input[name='_token']").val()
                        },
                        function (res) {
                            res=JSON.parse(res);
                            console.log(res.url);
                            $('.firstImg img').attr('src',res.url);
                            layer.close(index);
                        }
                    );
                }
            }
            else if($('#imgTab li:eq(2)').hasClass('active')) {
                var base64=$('#previewImg').attr('src');
                $.post(
                    '/admin/toutiao/save_img',
                    {
                        img:base64,
                        _token :  $("input[name='_token']").val()
                    },
                    function (res) {
                        res=JSON.parse(res);
                        console.log(res.url);
                        $('.firstImg img').attr('src',res.url);
                        layer.close(index);
                    }
                );
            }

        }
    });
    showImgModel();
})
//添加首图--裁剪图片
$(document).on('click','.firstImg .cutImgBtn', function () {
    var $imgSingle=$('.firstImg img');
    cropImgFn($imgSingle);
})
//添加首图--拼合之裁剪图片
$(document).on('click','.cutSelImage', function () {
    var $imgSingle=$(this).siblings('img');
    cropImgToPiece($imgSingle);
})

//获取描述
$(document).on('click','.getDesBtn',function () {
    var $IntSingle=$(this).parents('.IntSingle');
    layer.open({
        type: 1,
        title: "获取描述", //不显示标题则false
        area:['80%','100%'],
        shade: [0.8, '#393D49'],
        shadeClose:false,
        content: desData,
        closeBtn:0,
        btn: ['确认','取消'],
        yes:function(index, layero){
            var checkedLen=$('input[name="imgRadio"]:checked').length;
            if(checkedLen==1){
                var des=$('input[name="imgRadio"]:checked').parents('tr').find('.desBox').text();
                var desLen=des.length;
                $IntSingle.find('textarea').val(des);
                $IntSingle.find('textarea').attr('data-text',des);
                $IntSingle.find('.des_tip').text(desLen+'/100');
                if(desLen<10 || desLen>100){
                    $IntSingle.find('.des_tip').addClass('warning');
                }
                layer.close(index);
            }
            else{
                layer.msg('请选择文本')
            }

        }
    });
    getDesData();
});

//级联
$(document).on('change','#oneUp',function(){
    var claData=JSON.parse(localStorage.getItem('get_categories'));
    $(this).siblings('#twoUp').empty();
    $(this).siblings('#threeUp').empty();
    $(this).siblings('#twoUp').append('<option value="">全部</option>');
    $(this).siblings('#threeUp').append('<option value="">全部</option>');
    var sel=$(this).find('option:selected').val();
    var num=0;
    for (var i=0;i<claData.length;i++) {
        var parent_id=claData[i]['parent_id'];
        if(parent_id==sel){
            num++;
            var option=`<option value="${claData[i]['id']}">${claData[i]['name']}</option>`;
            $(this).siblings('#twoUp').append(option);
            if(num==1){
                var sel_two=$(this).siblings('#twoUp').find('option:selected').val();
                console.log('二级ID'+sel_two);
                for (var k=0;k<claData.length;k++) {
                    var parent_id=claData[k]['parent_id'];
                    if(parent_id==sel_two){
                        var option=`<option value="${claData[k]['id']}">${claData[k]['name']}</option>`;
                        $(this).siblings('#threeUp').append(option);
                    }
                }
            }
        }
    }
})

$(document).on('change','#twoUp',function(){
    var claData=JSON.parse(localStorage.getItem('get_categories'));
    $(this).siblings('#threeUp').empty();
    $(this).siblings('#threeUp').append('<option value="">全部</option>');
    var sel=$(this).find('option:selected').val();
    for (var i=0;i<claData.length;i++) {
        var parent_id=claData[i]['parent_id'];
        if(parent_id==sel){
            var option=`<option value="${claData[i]['id']}">${claData[i]['name']}</option>`;
            $(this).siblings('#threeUp').append(option);
        }
    }
})

//筛选图片
$(document).on('click','.getImgBtn',function () {
    $.post(
        '/admin/base/get_img_data',
        {
            _token :  $("input[name='_token']").val(),
            first_cid:$('#oneUp').val(),
            second_cid:$('#twoUp').val(),
            third_cid:$('#threeUp').val(),
            data_source:$('#data_source').val(),
            key_type:$('#key_type').val(),
            keywords:$('.keywords').val(),
            page_count:20,
            page:1
        },
        function (res) {
            var data=JSON.parse(res);
            $("#pagination").pagination({
                currentPage: data.current_page,
                totalPage: data.last_page,
                callback: function(current) {
                    getImgList(current)
                }
            });
            data=data.data;
            console.log(data);
            var html;

            for(var i=0;i<data.length;i++){
                var category='';
                var category_id=data[i].category_id;
                var category_sub_id=data[i].category_sub_id;
                var category_third_id=data[i].category_third_id;
                var claData=JSON.parse(localStorage.getItem('get_categories'));
                for (var j=0;j<claData.length;j++) {
                    var id=claData[j]['id'];
                    if(id==category_id || id==category_sub_id || id==category_third_id ){
                        category+=claData[j]['name']+' ';
                    }
                }

                html+=
                '<tr>'+
                '<td><input type="checkbox" name="imgCheck" class="imgCheck"></td>'+
                '<td>图片</td>'+
                '<td><p>文章标题: '+data[i].title+'</p><div class="imgBox"><img src="'+data[i].content+'"></div></td>'+
                '<td>'+category+'</td>'+
                '<td>'+data[i].source+'</td>'+
                '<td>'+data[i].keywords+'</td>'+
                '</tr>';
            }
            $('.imgTable tbody').html(html);
        }
    )
})

//筛选描述
$(document).on('click','.searchDesBtn',function () {
    $.post(
        '/admin/base/get_des_data',
        {
            _token :  $("input[name='_token']").val(),
            first_cid:$('#oneUp').val(),
            second_cid:$('#twoUp').val(),
            third_cid:$('#threeUp').val(),
            data_source:$('#data_source').val(),
            key_type:$('#key_type').val(),
            keywords:$('.keywords').val(),
            page_count:20,
            page:1
        },
        function (res) {
            var data=JSON.parse(res);
            $("#pagination").pagination({
                currentPage: data.current_page,
                totalPage: data.last_page,
                callback: function(current) {
                    getDesList(current)
                }
            });
            data=data.data;
            console.log(data);
            var html;

            for(var i=0;i<data.length;i++){
                var category='';
                var category_id=data[i].category_id;
                var category_sub_id=data[i].category_sub_id;
                var category_third_id=data[i].category_third_id;
                var claData=JSON.parse(localStorage.getItem('get_categories'));
                for (var j=0;j<claData.length;j++) {
                    var id=claData[j]['id'];
                    if(id==category_id || id==category_sub_id || id==category_third_id ){
                        category+=claData[j]['name']+' ';
                    }
                }

                html+=
                    '<tr>'+
                    '<td><input type="radio" name="imgRadio" class="imgCheck"></td>'+
                    '<td>文本</td>'+
                    '<td><p>文章标题: '+data[i].title+'</p><div class="desBox">'+data[i].content+'</div></td>'+
                    '<td>'+category+'</td>'+
                    '<td>'+data[i].source+'</td>'+
                    '<td>'+data[i].keywords+'</td>'+
                    '</tr>';
            }
            $('.imgTable tbody').html(html);
        }
    )
})

$(document).on('dblclick','.firstImg img',function () {
    var path = $(this).attr('src');
    showBigImg(path);
});


$(document).on('dblclick','.headImg',function () {
    var path = $(this).attr('src');
    showBigImg(path);
});

$(document).on('dblclick','.IntSingle img',function () {
    var path = $(this).attr('src');
    showBigImg(path);
});


$(document).on('dblclick','.imgBox img',function () {
    var path = $(this).attr('src');
    showBigImg(path);
});

function showBigImg(path){
    var img = "<img src='" + path + "' style='max-height: 600px'/>";
    layer.open({
        type: 1,
        title: false, //不显示标题
        area:['auto','auto'],
        shade: [0.8, '#393D49'],
        shadeClose:true,
        content: img
    });
}


function getImgList(page) {
    $('.imgTable tbody').empty();
    $('.loadingText').show();
    $.post(
        '/admin/base/get_img_data',
        {
            _token :  $("input[name='_token']").val(),
            first_cid:$('#oneUp').val(),
            second_cid:$('#twoUp').val(),
            third_cid:$('#threeUp').val(),
            data_source:$('#data_source').val(),
            key_type:$('#key_type').val(),
            keywords:$('.keywords').val(),
            page_count:20,
            page:page
        },
        function (res) {
            var data=JSON.parse(res);
            data=data.data;
            console.log(data);
            var html;

            for(var i=0;i<data.length;i++){
                var category='';
                var category_id=data[i].category_id;
                var category_sub_id=data[i].category_sub_id;
                var category_third_id=data[i].category_third_id;
                var claData=JSON.parse(localStorage.getItem('get_categories'));
                for (var j=0;j<claData.length;j++) {
                    var id=claData[j]['id'];
                    if(id==category_id || id==category_sub_id || id==category_third_id ){
                        category+=claData[j]['name']+' ';
                    }
                }

                html+=
                    '<tr>'+
                    '<td><input type="checkbox" name="imgCheck" class="imgCheck"></td>'+
                    '<td>图片</td>'+
                    '<td><p>文章标题: '+data[i].title+'</p><div class="imgBox"><img src="'+data[i].content+'"></div></td>'+
                    '<td>'+category+'</td>'+
                    '<td>'+data[i].source+'</td>'+
                    '<td>'+data[i].keywords+'</td>'+
                    '</tr>';
            }
            $('.imgTable tbody').html(html);
            $('.loadingText').hide();
        }
    )
}

function getDesList(page) {
    $('.imgTable tbody').empty();
    $('.loadingText').show();
    $.post(
        '/admin/base/get_des_data',
        {
            _token :  $("input[name='_token']").val(),
            first_cid:$('#oneUp').val(),
            second_cid:$('#twoUp').val(),
            third_cid:$('#threeUp').val(),
            data_source:$('#data_source').val(),
            key_type:$('#key_type').val(),
            keywords:$('.keywords').val(),
            page_count:20,
            page:page
        },
        function (res) {
            var data=JSON.parse(res);
            data=data.data;
            console.log(data);
            var html;

            for(var i=0;i<data.length;i++){
                var category='';
                var category_id=data[i].category_id;
                var category_sub_id=data[i].category_sub_id;
                var category_third_id=data[i].category_third_id;
                var claData=JSON.parse(localStorage.getItem('get_categories'));
                for (var j=0;j<claData.length;j++) {
                    var id=claData[j]['id'];
                    if(id==category_id || id==category_sub_id || id==category_third_id ){
                        category+=claData[j]['name']+' ';
                    }
                }

                html+=
                    '<tr>'+
                    '<td><input type="radio" name="imgRadio" class="imgCheck"></td>'+
                    '<td>文本</td>'+
                    '<td><p>文章标题: '+data[i].title+'</p><div class="desBox">'+data[i].content+'</div></td>'+
                    '<td>'+category+'</td>'+
                    '<td>'+data[i].source+'</td>'+
                    '<td>'+data[i].keywords+'</td>'+
                    '</tr>';
            }
            $('.imgTable tbody').html(html);
            $('.loadingText').hide();
        }
    )
}

function saveImg(img) {
    $.post(
        '/admin/toutiao/save_img',
        {
            img:img,
            _token :  $("input[name='_token']").val()
        },
        function (res) {
            console.log(res)
        }
    )
}

function cropImgFn($imgSingle){
    var imgSrc=$imgSingle.attr('src');
    if(imgSrc.indexOf('ttcdn-tos.pstatp.com') !== -1){
        imgSrc= imgSrc.split('.com');
        imgSrc= 'https://p3a.pstatp.com'+imgSrc[1];
    }
    var changeImgModel='<div class="changeImgModel">\n' +
        '\t\t\t\t<button type="button" class="btn btn-success sureImgBtn">确定</button>\n' +
        '\t\t\t\t<button type="button" class="btn btn-warning closeImgBtn">取消</button>'+
        '\t\t\t<div class="head">\n' +
        '\t\t\t\t<img src="'+imgSrc+'"  id="target"/>\n' +
        '\t\t\t</div>\n' +
        '\t\t</div>';
    $('html body').append(changeImgModel);
    // 定义一些使用的变量
    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        // 使用的jquery对象
        $targetImg = $('#target');

    preImgImg(imgSrc);
    $('.changeImgModel .sureImgBtn').click(function () {
        var img = new Image();
        img.src = $('#target').attr('src');
        var realWidth = img.width;
        var realHeight = img.height;
        if(img.src.indexOf('http')!=-1){
            img.crossOrigin = "Anonymous";
            img.src = $('#target').attr('src');
        }

        var showWidth=$('#target').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#target').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);

        // 真实图片和显示图片的宽比  高比
        var ratio=realWidth/showWidth;

        var width=$('.changeImgModel .jcrop-holder>div').css('width');
        if(width=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        width=width.split('px');
        width=parseInt(width[0])*ratio;
        var height=$('.changeImgModel .jcrop-holder>div').css('height');
        if(height=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        height=height.split('px');
        height=parseInt(height[0])*ratio;
        var top=$('.changeImgModel .jcrop-holder>div').css('top');
        top=top.split('px');
        top=0-parseInt(top[0])*ratio;
        var left=$('.changeImgModel .jcrop-holder>div').css('left');
        left=left.split('px');
        left=0-parseInt(left[0])*ratio;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        canvas.width = width;
        canvas.height = height;

        img.onload = function() {
            this.width = realWidth;
            this.height = realHeight;
            ctx.drawImage(this, left, top, this.width, this.height);
            base64 = canvas.toDataURL('image/jpeg', 1);
            console.log(base64);
            $('.changeImgModel').remove();
            $.post(
                '/admin/toutiao/save_img',
                {
                    img:base64,
                    _token :  $("input[name='_token']").val()
                },
                function (res) {
                    res = JSON.parse(res);
                    console.log(res.url);
                    $imgSingle.attr('src',res.url);
                }
            )

        }


    });

    $('.changeImgModel .closeImgBtn').click(function () {
        $('.changeImgModel').remove();
    });
    function preImgImg(url) {
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }
        initTargetImg();
        var image = document.getElementById('target');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;
                initJcropImg();
            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.Jcrop({

            // aspectRatio: 513 / 513
        },function(){
            //初始化后回调函数
            // 获取图片实际显示的大小
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度
            jcrop_api = this;
        });
    }
    function initTargetImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }
}

function cropAtlasImgFn($imgSingle,goodsDataIndex,type){
    var imgSrc=$imgSingle.attr('src');
    if(imgSrc.indexOf('ttcdn-tos.pstatp.com') !== -1){
        imgSrc= imgSrc.split('.com');
        imgSrc= 'https://p3a.pstatp.com'+imgSrc[1];
    }
    var changeImgModel='<div class="changeImgModel">\n' +
        '<button type="button" class="btn btn-primary selImgBtn">选择图片</button>\n' +
        '<button type="button" class="btn btn-success sureNoCropBtn">确定(不裁剪)</button>\n' +
        '<button type="button" class="btn btn-success sureImgBtn">确定</button>\n' +
        '<button type="button" class="btn btn-warning closeImgBtn">取消</button>'+
        '<label class="checkbox-inline" style="font-size: 18px; color: red; margin-left: 100px">'+
            '<input type="checkbox" class="checkSquare" checked style="zoom: 120%"> 正方形'+
        '</label>'+
        '<div class="head">\n' +
        '<img src="'+imgSrc+'"  id="target"/>\n' +
        '<input type="file" id="file" style="display: none;"/>' +
        '</div>\n' +
        '</div>';
    $('html body').append(changeImgModel);
    // 定义一些使用的变量
    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        // 使用的jquery对象
        $targetImg = $('#target');

    preImgImg(imgSrc,1);

    $('.changeImgModel .sureImgBtn').click(function () {
        var img = new Image();
        img.src = $('#target').attr('src');
        // var realWidth = img.width;
        // var realHeight = img.height;
        if(img.src.indexOf('http')!=-1){
            img.crossOrigin = "Anonymous";
            img.src = $('#target').attr('src');
        }

        var showWidth=$('#target').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#target').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);

        // 真实图片和显示图片的宽比  高比
        var ratio=realWidth/showWidth;

        var width=$('.changeImgModel .jcrop-holder>div').css('width');
        if(width=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        width=width.split('px');
        width=parseInt(width[0])*ratio;
        var height=$('.changeImgModel .jcrop-holder>div').css('height');
        if(height=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        height=height.split('px');
        height=parseInt(height[0])*ratio;
        var top=$('.changeImgModel .jcrop-holder>div').css('top');
        top=top.split('px');
        top=0-parseInt(top[0])*ratio;
        var left=$('.changeImgModel .jcrop-holder>div').css('left');
        left=left.split('px');
        left=0-parseInt(left[0])*ratio;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        canvas.width = width;
        canvas.height = height;

        img.onload = function() {
            this.width = realWidth;
            this.height = realHeight;
            ctx.drawImage(this, left, top, this.width, this.height);
            base64 = canvas.toDataURL('image/jpeg', 1);
            var crop_tip='<div class="crop_tip">' +
                    '<div class="crop_tip_cancel"><span class="cancelTipBtn">X</span></div>' +
                    '<p>图片上传中...</p>' +
                '</div>';
            $('html body').append(crop_tip);
            $('.cancelTipBtn').click(function () {
                console.log('123');
                $(this).parents('.crop_tip').remove();
            });
            $.post(
                '/admin/article/save_img',
                {
                    img:base64,
                    _token :  $("input[name='_token']").val()
                },
                function (res) {
                    res = JSON.parse(res);
                    console.log(res.url);
                    if(type=='main_pic'){
                        vm.goodsDatas[goodsDataIndex].main_pic=res.url;
                    }else{
                        vm.goodsDatas[goodsDataIndex].sub_pic=res.url;
                    }
                    $imgSingle.attr('src',res.url);
                    $('.crop_tip p').text('图片上传成功');
                    setTimeout(function () {
                        $('.crop_tip').remove();
                        $('.changeImgModel').remove();
                    },500)
                }
            )

        }


    });

    $('.changeImgModel .sureNoCropBtn').click(function () {
        var imgPre=$('#target').attr('src');
        if(imgPre.indexOf('blob')!=-1){
            var img = new Image();
            img.src = $('#target').attr('src');
            var realWidth = img.width;
            var realHeight = img.height;
            var canvas = document.createElement("canvas");
            var ctx = canvas.getContext('2d');
            var base64;
            canvas.width = realWidth;
            canvas.height = realHeight;

            img.onload = function() {
                this.width = realWidth;
                this.height = realHeight;
                ctx.drawImage(this, 0, 0, this.width, this.height);
                base64 = canvas.toDataURL('image/jpeg', 1);
                var crop_tip='<div class="crop_tip">' +
                    '<div class="crop_tip_cancel"><span class="cancelTipBtn">X</span></div>' +
                    '<p>图片上传中...</p>' +
                    '</div>';
                $('html body').append(crop_tip);
                $('.cancelTipBtn').click(function () {
                    console.log('123');
                    $(this).parents('.crop_tip').remove();
                });
                $.post(
                    '/admin/article/save_img',
                    {
                        img:base64,
                        _token :  $("input[name='_token']").val()
                    },
                    function (res) {
                        res = JSON.parse(res);
                        console.log(res.url);
                        $imgSingle.attr('src',res.url);
                        $('.crop_tip p').text('图片上传成功');
                        setTimeout(function () {
                            $('.crop_tip').remove();
                            $('.changeImgModel').remove();
                        },500)
                    }
                )

            }
        }
        else{
            $imgSingle.attr('src',imgPre);
            $('.changeImgModel').remove();
        }

    });


    $('.changeImgModel .closeImgBtn').click(function () {
        $('.changeImgModel').remove();
    });
    $('.checkSquare').change(function () {
        var imgPre=$('#target').attr('src');
        if($(this).is(':checked')){
            preImgImg(imgPre,1);
        }
        else {
            preImgImg(imgPre,0);
        }
    });
    $('.changeImgModel .selImgBtn').click(function () {
        openBrowseImg()
    });
    $('.changeImgModel #file').change(function(){
        changeFileImg()
    });
    //1.
    function openBrowseImg(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("file").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("file").dispatchEvent(a);
        }
    }

    //2、从 file 域获取 本地图片 url
    function getFileUrlImg(sourceId) {
        var url;
        if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
            url = document.getElementById(sourceId).value;
        } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Safari")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        }
        return url;
    }
    //选择文件事件
    function changeFileImg() {
        var url = getFileUrlImg("file");//根据id获取文件路径
        preImgImg(url);
        return false;
    }
    function preImgImg(url,isSquare) {
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }
        initTargetImg();
        var image = document.getElementById('target');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;
                if(isSquare==1){
                    initJcropImg(1);
                }
                else{
                    initJcropImg(0);
                }

            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(aspectRatio){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.Jcrop({
            minSize:[420,420],
            setSelect:[100,100,520,520],
            onChange: updateCoords,
            aspectRatio: aspectRatio
        },function(){
            //初始化后回调函数
            // 获取图片实际显示的大小
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度
            jcrop_api = this;
        });
    }
    function updateCoords(c)
    {
        var pxText=c.w +' x '+ c.h;
        if($('.showPx').length==0){
            var span='<span class="showPx"></span>';
            $('.jcrop-holder').prepend(span);
        }
        $('.showPx').css({
            'width': '80px',
            'height': '30px',
            'display': 'inline-block',
            'position': 'absolute',
            'background': 'rgba(0,0,0,0.5)',
            'top': (c.y-30-4)+'px',
            'left': (c.x2+4)+'px',
            'color': 'white',
            'line-height': '30px',
            'text-align': 'center',
            'z-index': 999,
            'border-radius': '4px'
        });
        $('.showPx').text(pxText);

    };
    function initTargetImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }
}

// edit_img
$(document).on('click','.edit_img',function () {
    var $ul=$(this).parents('.IntSingle').find('.ul_img_box');
    if($ul.html()==''){
        var goods_id=$(this).parents('.IntSingle').attr('data-id');
        $.get(
            '/admin/article/select_goods_data',
            {
                select_product_id: goods_id,
            },
            function (res) {
                var res=JSON.parse(res);
                var ul='<ul class="img_ul">';
                for(var m=0;m<res.DATA[0].images.length;m++){
                    if(m == 0){
                        ul += '<li class="img_active"><img src="'+res.DATA[0].images[m]+'" class="tb_goods_imgs" /></li>'
                    }
                    else{
                        ul += '<li><img src="'+res.DATA[0].images[m]+'" class="tb_goods_imgs img-rounded" alt="Cinque Terre"/></li>'
                    }
                }
                ul +='</ul>';
                $ul.append(ul);
                $('.model_ul').append(ul);
                $('.changeImgModel .img_ul').css({'margin-left':'-50px','height': '134px'});
                $('.img_ul li').click(function () {
                    var src=$(this).find('img').attr('src');
                    if(src.indexOf('ttcdn-tos.pstatp.com') !== -1){
                        src= src.split('.com');
                        src= 'https://p3a.pstatp.com'+src[1];
                    }
                    $('#target').attr('src',src);
                    preImgImg(src);
                });
            }
        )
    }
    var ul=$(this).parents('.IntSingle').find('.ul_img_box').html();
    $imgSingle=$(this).parents('.IntSingle').find('.div_left img');
    var imgSrc=$imgSingle.attr('src');
    if(imgSrc.indexOf('ttcdn-tos.pstatp.com') !== -1){
        imgSrc= imgSrc.split('.com');
        imgSrc= 'https://p3a.pstatp.com'+imgSrc[1];
    }
    var changeImgModel='<div class="changeImgModel">\n' +
        '<button type="button" class="btn btn-primary selImgBtn">选择图片</button>\n' +
        '<button type="button" class="btn btn-success sureNoCropBtn">确定(不裁剪)</button>\n' +
        '<button type="button" class="btn btn-success sureImgBtn">确定</button>\n' +
        '<button type="button" class="btn btn-warning closeImgBtn">取消</button>'+
        '<label class="checkbox-inline" style="font-size: 18px; color: red; margin-left: 100px">'+
        '<input type="checkbox" class="checkSquare" checked style="zoom: 120%"> 正方形'+
        '</label><div style="margin-left: 40px" class="model_ul">' +ul+'</div>'+
        '<div class="head">\n' +
        '<img src="'+imgSrc+'"  id="target"/>\n' +
        '<input type="file" id="file" style="display: none;"/>' +
        '</div>\n' +
        '</div>';
    $('html body').append(changeImgModel);
    $('.changeImgModel .img_ul').css({'margin-left':'-50px','height': '134px'});
    // 定义一些使用的变量
    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        // 使用的jquery对象
        $targetImg = $('#target');

    preImgImg(imgSrc,1);

    $('.img_ul li').click(function () {
        var src=$(this).find('img').attr('src');
        if(src.indexOf('ttcdn-tos.pstatp.com') !== -1){
            src= src.split('.com');
            src= 'https://p3a.pstatp.com'+src[1];
        }
        $('#target').attr('src',src);
        preImgImg(src);
    });

    $('.changeImgModel .sureImgBtn').click(function () {
        var img = new Image();
        img.src = $('#target').attr('src');
        // var realWidth = img.width;
        // var realHeight = img.height;
        if(img.src.indexOf('http')!=-1){
            img.crossOrigin = "Anonymous";
            img.src = $('#target').attr('src');
        }

        var showWidth=$('#target').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#target').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);

        // 真实图片和显示图片的宽比  高比
        var ratio=realWidth/showWidth;

        var width=$('.changeImgModel .jcrop-holder>div').css('width');
        if(width=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        width=width.split('px');
        width=parseInt(width[0])*ratio;
        var height=$('.changeImgModel .jcrop-holder>div').css('height');
        if(height=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        height=height.split('px');
        height=parseInt(height[0])*ratio;
        var top=$('.changeImgModel .jcrop-holder>div').css('top');
        top=top.split('px');
        top=0-parseInt(top[0])*ratio;
        var left=$('.changeImgModel .jcrop-holder>div').css('left');
        left=left.split('px');
        left=0-parseInt(left[0])*ratio;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        canvas.width = width;
        canvas.height = height;

        img.onload = function() {
            this.width = realWidth;
            this.height = realHeight;
            ctx.drawImage(this, left, top, this.width, this.height);
            base64 = canvas.toDataURL('image/jpeg', 1);
            var crop_tip='<div class="crop_tip">' +
                '<div class="crop_tip_cancel"><span class="cancelTipBtn">X</span></div>' +
                '<p>图片上传中...</p>' +
                '</div>';
            $('html body').append(crop_tip);
            $('.cancelTipBtn').click(function () {
                console.log('123');
                $(this).parents('.crop_tip').remove();
            });
            $.post(
                '/admin/article/save_img',
                {
                    img:base64,
                    _token :  $("input[name='_token']").val()
                },
                function (res) {
                    res = JSON.parse(res);
                    console.log(res.url);
                    $imgSingle
                    $imgSingle.attr('src',res.url);
                    $('.crop_tip p').text('图片上传成功');
                    setTimeout(function () {
                        $('.crop_tip').remove();
                        $('.changeImgModel').remove();
                    },500)
                }
            )

        }


    });

    // sureNoCropBtn
    $('.changeImgModel .sureNoCropBtn').click(function () {
        var imgPre=$('#target').attr('src');
        if(imgPre.indexOf('blob')!=-1){
            var img = new Image();
            img.src = $('#target').attr('src');
            var realWidth = img.width;
            var realHeight = img.height;
            var canvas = document.createElement("canvas");
            var ctx = canvas.getContext('2d');
            var base64;
            canvas.width = realWidth;
            canvas.height = realHeight;

            img.onload = function() {
                this.width = realWidth;
                this.height = realHeight;
                ctx.drawImage(this, 0, 0, this.width, this.height);
                base64 = canvas.toDataURL('image/jpeg', 1);
                var crop_tip='<div class="crop_tip">' +
                    '<div class="crop_tip_cancel"><span class="cancelTipBtn">X</span></div>' +
                    '<p>图片上传中...</p>' +
                    '</div>';
                $('html body').append(crop_tip);
                $('.cancelTipBtn').click(function () {
                    console.log('123');
                    $(this).parents('.crop_tip').remove();
                });
                $.post(
                    '/admin/article/save_img',
                    {
                        img:base64,
                        _token :  $("input[name='_token']").val()
                    },
                    function (res) {
                        res = JSON.parse(res);
                        console.log(res.url);
                        $imgSingle.attr('src',res.url);
                        $('.crop_tip p').text('图片上传成功');
                        setTimeout(function () {
                            $('.crop_tip').remove();
                            $('.changeImgModel').remove();
                        },500)
                    }
                )

            }
        }
        else{
            $imgSingle.attr('src',imgPre);
            $('.changeImgModel').remove();
        }

    });

    $('.changeImgModel .closeImgBtn').click(function () {
        $('.changeImgModel').remove();
    });
    $('.checkSquare').change(function () {
        var imgPre=$('#target').attr('src');
        if($(this).is(':checked')){
            preImgImg(imgPre,1);
        }
        else {
            preImgImg(imgPre,0);
        }
    });
    $('.changeImgModel .selImgBtn').click(function () {
        openBrowseImg()
    });
    $('.changeImgModel #file').change(function(){
        changeFileImg()
    });
    //1.
    function openBrowseImg(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("file").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("file").dispatchEvent(a);
        }
    }

    //2、从 file 域获取 本地图片 url
    function getFileUrlImg(sourceId) {
        var url;
        if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
            url = document.getElementById(sourceId).value;
        } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Safari")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        }
        return url;
    }
    //选择文件事件
    function changeFileImg() {
        var url = getFileUrlImg("file");//根据id获取文件路径
        preImgImg(url);
        return false;
    }
    function preImgImg(url,isSquare) {
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }
        initTargetImg();
        var image = document.getElementById('target');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;
                if(isSquare==1){
                    initJcropImg(1);
                }
                else{
                    initJcropImg(0);
                }

            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(aspectRatio){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.Jcrop({
            minSize:[420,420],
            setSelect:[100,100,520,520],
            onChange: updateCoords,
            aspectRatio: aspectRatio
        },function(){
            //初始化后回调函数
            // 获取图片实际显示的大小
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度
            jcrop_api = this;
        });
    }
    function updateCoords(c)
    {
        var pxText=c.w +' x '+ c.h;
        if($('.showPx').length==0){
            var span='<span class="showPx"></span>';
            $('.jcrop-holder').prepend(span);
        }
        $('.showPx').css({
            'width': '80px',
            'height': '30px',
            'display': 'inline-block',
            'position': 'absolute',
            'background': 'rgba(0,0,0,0.5)',
            'top': (c.y-30-4)+'px',
            'left': (c.x2+4)+'px',
            'color': 'white',
            'line-height': '30px',
            'text-align': 'center',
            'z-index': 999,
            'border-radius': '4px'
        });
        $('.showPx').text(pxText);

    };
    function initTargetImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }
})

// edit_img_btn
$(document).on('click','.edit_img_btn',function () {
    var $ul=$(this).parents('.IntSingle').find('.ul_img_box');
    if($ul.html()==''){
        var goods_id=$(this).parents('.IntSingle').attr('data-id');
        $.get(
            '/admin/article/select_goods_data',
            {
                select_product_id: goods_id,
            },
            function (res) {
                var res=JSON.parse(res);
                var ul='<ul class="img_ul">';
                for(var m=0;m<res.DATA[0].images.length;m++){
                    if(m == 0){
                        ul += '<li class="img_active"><img src="'+res.DATA[0].images[m]+'" class="tb_goods_imgs" /></li>'
                    }
                    else{
                        ul += '<li><img src="'+res.DATA[0].images[m]+'" class="tb_goods_imgs img-rounded" alt="Cinque Terre"/></li>'
                    }
                }
                ul +='</ul>';
                $ul.append(ul);
                $('.model_ul').append(ul);
                $('.changeImgModel .img_ul').css({'margin-left':'-50px','height': '134px'});
                $('.img_ul li').click(function () {
                    var src=$(this).find('img').attr('src');
                    if(src.indexOf('ttcdn-tos.pstatp.com') !== -1){
                        src= src.split('.com');
                        src= 'https://p3a.pstatp.com'+src[1];
                    }
                    $('#target').attr('src',src);
                    preImgImg(src);
                });
            }
        )
    }

    var ul=$(this).parents('.IntSingle').find('.ul_img_box').html();
    $imgSingle=$(this).parents('.IntSingle').find('.IntContent img');
    var imgSrc=$imgSingle.attr('src');
    if(imgSrc.indexOf('ttcdn-tos.pstatp.com') !== -1){
        imgSrc= imgSrc.split('.com');
        imgSrc= 'https://p3a.pstatp.com'+imgSrc[1];
    }
    var changeImgModel='<div class="changeImgModel">\n' +
        '<button type="button" class="btn btn-primary selImgBtn">选择图片</button>\n' +
        '<button type="button" class="btn btn-success sureNoCropBtn">确定(不裁剪)</button>\n' +
        '<button type="button" class="btn btn-success sureImgBtn">确定</button>\n' +
        '<button type="button" class="btn btn-warning closeImgBtn">取消</button>'+
        '<label class="checkbox-inline" style="font-size: 18px; color: red; margin-left: 100px">'+
        '<input type="checkbox" class="checkSquare" checked style="zoom: 120%"> 正方形'+
        '</label><div style="margin-left: 40px" class="model_ul">' +ul+'</div>'+
        '<div class="head">\n' +
        '<img src="'+imgSrc+'"  id="target"/>\n' +
        '<input type="file" id="file" style="display: none;"/>' +
        '</div>\n' +
        '</div>';
    $('html body').append(changeImgModel);
    $('.changeImgModel .img_ul').css({'margin-left':'-50px','height': '134px'});


    // 定义一些使用的变量
    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        // 使用的jquery对象
        $targetImg = $('#target');

    preImgImg(imgSrc,1);

    $('.img_ul li').click(function () {
        var src=$(this).find('img').attr('src');
        if(src.indexOf('ttcdn-tos.pstatp.com') !== -1){
            src= src.split('.com');
            src= 'https://p3a.pstatp.com'+src[1];
        }
        $('#target').attr('src',src);
        preImgImg(src);
    });

    $('.changeImgModel .sureNoCropBtn').click(function () {
        var imgPre=$('#target').attr('src');
        if(imgPre.indexOf('blob')!=-1){
            var img = new Image();
            img.src = $('#target').attr('src');
            var realWidth = img.width;
            var realHeight = img.height;
            var canvas = document.createElement("canvas");
            var ctx = canvas.getContext('2d');
            var base64;
            canvas.width = realWidth;
            canvas.height = realHeight;

            img.onload = function() {
                this.width = realWidth;
                this.height = realHeight;
                ctx.drawImage(this, 0, 0, this.width, this.height);
                base64 = canvas.toDataURL('image/jpeg', 1);
                var crop_tip='<div class="crop_tip">' +
                    '<div class="crop_tip_cancel"><span class="cancelTipBtn">X</span></div>' +
                    '<p>图片上传中...</p>' +
                    '</div>';
                $('html body').append(crop_tip);
                $('.cancelTipBtn').click(function () {
                    console.log('123');
                    $(this).parents('.crop_tip').remove();
                });
                $.post(
                    '/admin/article/save_img',
                    {
                        img:base64,
                        _token :  $("input[name='_token']").val()
                    },
                    function (res) {
                        res = JSON.parse(res);
                        console.log(res.url);
                        $imgSingle.attr('src',res.url);
                        $('.crop_tip p').text('图片上传成功');
                        setTimeout(function () {
                            $('.crop_tip').remove();
                            $('.changeImgModel').remove();
                        },500)
                    }
                )

            }
        }
        else{
            $imgSingle.attr('src',imgPre);
            $('.changeImgModel').remove();
        }

    });

    $('.changeImgModel .sureImgBtn').click(function () {
        var img = new Image();
        img.src = $('#target').attr('src');
        // var realWidth = img.width;
        // var realHeight = img.height;
        if(img.src.indexOf('http')!=-1){
            img.crossOrigin = "Anonymous";
            img.src = $('#target').attr('src');
        }

        var showWidth=$('#target').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#target').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);

        // 真实图片和显示图片的宽比  高比
        var ratio=realWidth/showWidth;

        var width=$('.changeImgModel .jcrop-holder>div').css('width');
        if(width=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        width=width.split('px');
        width=parseInt(width[0])*ratio;
        var height=$('.changeImgModel .jcrop-holder>div').css('height');
        if(height=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        height=height.split('px');
        height=parseInt(height[0])*ratio;
        var top=$('.changeImgModel .jcrop-holder>div').css('top');
        top=top.split('px');
        top=0-parseInt(top[0])*ratio;
        var left=$('.changeImgModel .jcrop-holder>div').css('left');
        left=left.split('px');
        left=0-parseInt(left[0])*ratio;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        canvas.width = width;
        canvas.height = height;

        img.onload = function() {
            this.width = realWidth;
            this.height = realHeight;
            ctx.drawImage(this, left, top, this.width, this.height);
            base64 = canvas.toDataURL('image/jpeg', 1);
            var crop_tip='<div class="crop_tip">' +
                '<div class="crop_tip_cancel"><span class="cancelTipBtn">X</span></div>' +
                '<p>图片上传中...</p>' +
                '</div>';
            $('html body').append(crop_tip);
            $('.cancelTipBtn').click(function () {
                console.log('123');
                $(this).parents('.crop_tip').remove();
            });
            $.post(
                '/admin/article/save_img',
                {
                    img:base64,
                    _token :  $("input[name='_token']").val()
                },
                function (res) {
                    res = JSON.parse(res);
                    console.log(res.url);
                    $imgSingle.attr('src',res.url);
                    $('.crop_tip p').text('图片上传成功');
                    setTimeout(function () {
                        $('.crop_tip').remove();
                        $('.changeImgModel').remove();
                    },500)
                }
            )

        }


    });


    $('.changeImgModel .closeImgBtn').click(function () {
        $('.changeImgModel').remove();
    });
    $('.checkSquare').change(function () {
        var imgPre=$('#target').attr('src');
        if($(this).is(':checked')){
            preImgImg(imgPre,1);
        }
        else {
            preImgImg(imgPre,0);
        }
    });
    $('.changeImgModel .selImgBtn').click(function () {
        openBrowseImg()
    });
    $('.changeImgModel #file').change(function(){
        changeFileImg()
    });
    //1.
    function openBrowseImg(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("file").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("file").dispatchEvent(a);
        }
    }

    //2、从 file 域获取 本地图片 url
    function getFileUrlImg(sourceId) {
        var url;
        if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
            url = document.getElementById(sourceId).value;
        } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Safari")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        }
        return url;
    }
    //选择文件事件
    function changeFileImg() {
        var url = getFileUrlImg("file");//根据id获取文件路径
        preImgImg(url);
        return false;
    }
    function preImgImg(url,isSquare) {
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }
        initTargetImg();
        var image = document.getElementById('target');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;
                if(isSquare==1){
                    initJcropImg(1);
                }
                else{
                    initJcropImg(0);
                }

            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(aspectRatio){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.Jcrop({
            minSize:[420,420],
            setSelect:[100,100,520,520],
            onChange: updateCoords,
            aspectRatio: aspectRatio
        },function(){
            //初始化后回调函数
            // 获取图片实际显示的大小
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度
            jcrop_api = this;
        });
    }
    function updateCoords(c)
    {
        var pxText=c.w +' x '+ c.h;
        if($('.showPx').length==0){
            var span='<span class="showPx"></span>';
            $('.jcrop-holder').prepend(span);
        }
        $('.showPx').css({
            'width': '80px',
            'height': '30px',
            'display': 'inline-block',
            'position': 'absolute',
            'background': 'rgba(0,0,0,0.5)',
            'top': (c.y-30-4)+'px',
            'left': (c.x2+4)+'px',
            'color': 'white',
            'line-height': '30px',
            'text-align': 'center',
            'z-index': 999,
            'border-radius': '4px'
        });
        $('.showPx').text(pxText);

    };
    function initTargetImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }
})

// edit_img_first
$(document).on('click','.edit_img_first',function () {
    var ul='';
    if($('.all_pro_ul').length>0){
        ul=$('.firstImgBox_tm').html();
    }
    else if($('.firstImg_tm').attr('data-ids')!=undefined){
        var goods_id=$('.firstImg_tm').attr('data-ids');
        $.get(
            '/admin/article/select_goods_data',
            {
                select_product_id: goods_id,
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
                var ul_first=$('.firstImgBox_tm').html();
                $('.ul_fir').append(ul_first);
                $('.changeImgModel .img_ul').css({'margin-left':'-50px','height': '134px'});
            }
        )
    }
    $imgSingle=$(this).siblings('img');
    var imgSrc=$imgSingle.attr('src');
    if(imgSrc.indexOf('ttcdn-tos.pstatp.com') !== -1){
        imgSrc= imgSrc.split('.com');
        imgSrc= 'https://p3a.pstatp.com'+imgSrc[1];
    }
    var changeImgModel='<div class="changeImgModel">\n' +
        '<button type="button" class="btn btn-primary selImgBtn">选择图片</button>\n' +
        '<button type="button" class="btn btn-success sureNoCropBtn">确定(不裁剪)</button>\n' +
        '<button type="button" class="btn btn-success sureImgBtn">确定</button>\n' +
        '<button type="button" class="btn btn-warning closeImgBtn">取消</button>'+
        '<label class="checkbox-inline" style="font-size: 18px; color: red; margin-left: 100px">'+
        '<input type="checkbox" class="checkSquare" checked style="zoom: 120%"> 正方形'+
        '</label><div class="ul_fir">' +ul+'</div>'+
        '<div class="head">\n' +
        '<img src="'+imgSrc+'"  id="target"/>\n' +
        '<input type="file" id="file" style="display: none;"/>' +
        '</div>\n' +
        '</div>';
    $('html body').append(changeImgModel);
    $('.changeImgModel .img_ul').css({'margin-left':'-50px','height': '134px'});
    // 定义一些使用的变量
    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        // 使用的jquery对象
        $targetImg = $('#target');

    preImgImg(imgSrc,1);

    $(document).on('click','.all_pro_ul li',function () {
        var index=$('.all_pro_ul li').index(this);
        $('.all_pro_div .ul_sin').eq(index).show().siblings('.ul_sin').hide();
    })
    $(document).on('click','.ul_sin li',function () {
        $(this).addClass('active').siblings('li').removeClass('active');
        var src=$(this).find('img').attr('src');
        if(src.indexOf('ttcdn-tos.pstatp.com') !== -1){
            src= src.split('.com');
            src= 'https://p3a.pstatp.com'+src[1];
        }
        $('#target').attr('src',src);
        preImgImg(src);
    })

    $('.changeImgModel .sureNoCropBtn').click(function () {
        var imgPre=$('#target').attr('src');
        if(imgPre.indexOf('blob')!=-1){
            var img = new Image();
            img.src = $('#target').attr('src');
            var realWidth = img.width;
            var realHeight = img.height;
            var canvas = document.createElement("canvas");
            var ctx = canvas.getContext('2d');
            var base64;
            canvas.width = realWidth;
            canvas.height = realHeight;

            img.onload = function() {
                this.width = realWidth;
                this.height = realHeight;
                ctx.drawImage(this, 0, 0, this.width, this.height);
                base64 = canvas.toDataURL('image/jpeg', 1);
                var crop_tip='<div class="crop_tip">' +
                    '<div class="crop_tip_cancel"><span class="cancelTipBtn">X</span></div>' +
                    '<p>图片上传中...</p>' +
                    '</div>';
                $('html body').append(crop_tip);
                $('.cancelTipBtn').click(function () {
                    console.log('123');
                    $(this).parents('.crop_tip').remove();
                });
                $.post(
                    '/admin/article/save_img',
                    {
                        img:base64,
                        _token :  $("input[name='_token']").val()
                    },
                    function (res) {
                        res = JSON.parse(res);
                        console.log(res.url);
                        $imgSingle.attr('src',res.url);
                        $('.headImg').attr('data-edit','1');
                        $('.emptyImg').hide();
                        $('.crop_tip p').text('图片上传成功');
                        setTimeout(function () {
                            $('.crop_tip').remove();
                            $('.changeImgModel').remove();
                        },500)
                    }
                )

            }
        }
        else{
            $imgSingle.attr('src',imgPre);
            $('.headImg').attr('data-edit','1');
            $('.emptyImg').hide();
            $('.changeImgModel').remove();
        }

    });

    $('.changeImgModel .sureImgBtn').click(function () {
        var img = new Image();
        img.src = $('#target').attr('src');
        // var realWidth = img.width;
        // var realHeight = img.height;
        if(img.src.indexOf('http')!=-1){
            img.crossOrigin = "Anonymous";
            img.src = $('#target').attr('src');
        }

        var showWidth=$('#target').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#target').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);

        // 真实图片和显示图片的宽比  高比
        var ratio=realWidth/showWidth;

        var width=$('.changeImgModel .jcrop-holder>div').css('width');
        if(width=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        width=width.split('px');
        width=parseInt(width[0])*ratio;
        var height=$('.changeImgModel .jcrop-holder>div').css('height');
        if(height=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        height=height.split('px');
        height=parseInt(height[0])*ratio;
        var top=$('.changeImgModel .jcrop-holder>div').css('top');
        top=top.split('px');
        top=0-parseInt(top[0])*ratio;
        var left=$('.changeImgModel .jcrop-holder>div').css('left');
        left=left.split('px');
        left=0-parseInt(left[0])*ratio;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        canvas.width = width;
        canvas.height = height;

        img.onload = function() {
            this.width = realWidth;
            this.height = realHeight;
            ctx.drawImage(this, left, top, this.width, this.height);
            base64 = canvas.toDataURL('image/jpeg', 1);
            var crop_tip='<div class="crop_tip">' +
                '<div class="crop_tip_cancel"><span class="cancelTipBtn">X</span></div>' +
                '<p>图片上传中...</p>' +
                '</div>';
            $('html body').append(crop_tip);
            $('.cancelTipBtn').click(function () {
                console.log('123');
                $(this).parents('.crop_tip').remove();
            });
            $.post(
                '/admin/article/save_img',
                {
                    img:base64,
                    _token :  $("input[name='_token']").val()
                },
                function (res) {
                    res = JSON.parse(res);
                    console.log(res.url);
                    $imgSingle.attr('src',res.url);
                    $('.crop_tip p').text('图片上传成功');
                    $('.headImg').attr('data-edit','1');
                    $('.emptyImg').hide();
                    setTimeout(function () {
                        $('.crop_tip').remove();
                        $('.changeImgModel').remove();
                    },500)
                }
            )

        }


    });


    $('.changeImgModel .closeImgBtn').click(function () {
        $('.changeImgModel').remove();
    });
    $('.checkSquare').change(function () {
        var imgPre=$('#target').attr('src');
        if($(this).is(':checked')){
            preImgImg(imgPre,1);
        }
        else {
            preImgImg(imgPre,0);
        }
    });
    $('.changeImgModel .selImgBtn').click(function () {
        openBrowseImg()
    });
    $('.changeImgModel #file').change(function(){
        changeFileImg()
    });
    //1.
    function openBrowseImg(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("file").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("file").dispatchEvent(a);
        }
    }

    //2、从 file 域获取 本地图片 url
    function getFileUrlImg(sourceId) {
        var url;
        if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
            url = document.getElementById(sourceId).value;
        } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Safari")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        }
        return url;
    }
    //选择文件事件
    function changeFileImg() {
        var url = getFileUrlImg("file");//根据id获取文件路径
        preImgImg(url);
        return false;
    }
    function preImgImg(url,isSquare) {
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }
        initTargetImg();
        var image = document.getElementById('target');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;
                if(isSquare==1){
                    initJcropImg(1);
                }
                else{
                    initJcropImg(0);
                }

            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(aspectRatio){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.Jcrop({
            minSize:[420,420],
            setSelect:[100,100,520,520],
            onChange: updateCoords,
            aspectRatio: aspectRatio
        },function(){
            //初始化后回调函数
            // 获取图片实际显示的大小
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度
            jcrop_api = this;
        });
    }
    function updateCoords(c)
    {
        var pxText=c.w +' x '+ c.h;
        if($('.showPx').length==0){
            var span='<span class="showPx"></span>';
            $('.jcrop-holder').prepend(span);
        }
        $('.showPx').css({
            'width': '80px',
            'height': '30px',
            'display': 'inline-block',
            'position': 'absolute',
            'background': 'rgba(0,0,0,0.5)',
            'top': (c.y-30-4)+'px',
            'left': (c.x2+4)+'px',
            'color': 'white',
            'line-height': '30px',
            'text-align': 'center',
            'z-index': 999,
            'border-radius': '4px'
        });
        $('.showPx').text(pxText);

    };
    function initTargetImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }
})



function changeImgFn($imgSingle){
    var imgSrc=$imgSingle.attr('src');
    if(imgSrc.indexOf('sf6-ttcdn-tos.pstatp.com')!=-1 || imgSrc.indexOf('ttcdn-tos.pstatp.com') !== -1){
        imgSrc= imgSrc.split('.com');
        imgSrc= 'https://p3a.pstatp.com'+imgSrc[1];
    }
    var changeImgModel='<div class="changeImgModel" style="z-index: 2076">\n' +
        '\t\t\t\t<button type="button" class="btn btn-primary selImgBtn">选择图片</button>\n' +
        '\t\t\t\t<button type="button" class="btn btn-success sureImgBtn">确定</button>\n' +
        '\t\t\t\t<button type="button" class="btn btn-warning closeImgBtn">取消</button>'+
        '\t\t\t<div class="head">\n' +
        '\t\t\t\t<img src="'+imgSrc+'"  id="targetImg"/>\n' +
        '<input type="file" id="file" style="display: none;"/>' +
        '\t\t\t</div>\n' +
        '\t\t</div>';
    $('html body').append(changeImgModel);
    // 定义一些使用的变量
    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        // 使用的jquery对象
        $targetImg = $('#targetImg');

    preImgImg(imgSrc);

    $('.changeImgModel .sureImgBtn').click(function () {
        var img = new Image();
        img.src = $('#targetImg').attr('src');
        var realWidth = img.width;
        var realHeight = img.height;
        if(img.src.indexOf('http')!=-1){
            img.crossOrigin = "Anonymous";
            img.src = $('#targetImg').attr('src');
        }

        var showWidth=$('#targetImg').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#targetImg').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);

        // 真实图片和显示图片的宽比  高比
        var ratio=realWidth/showWidth;

        var width=$('.changeImgModel .jcrop-holder>div').css('width');
        if(width=='0px'){
            $imgSingle.attr('src',$('#targetImg').attr('src'));
            $('.changeImgModel').remove();
            return;
            // layer.msg('请裁剪图片再点击确定');
            // return;
        }
        width=width.split('px');
        width=parseInt(width[0])*ratio;
        var height=$('.changeImgModel .jcrop-holder>div').css('height');
        if(height=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        height=height.split('px');
        height=parseInt(height[0])*ratio;
        var top=$('.changeImgModel .jcrop-holder>div').css('top');
        top=top.split('px');
        top=0-parseInt(top[0])*ratio;
        var left=$('.changeImgModel .jcrop-holder>div').css('left');
        left=left.split('px');
        left=0-parseInt(left[0])*ratio;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        canvas.width = width;
        canvas.height = height;

        img.onload = function() {
            this.width = realWidth;
            this.height = realHeight;
            ctx.drawImage(this, left, top, this.width, this.height);
            base64 = canvas.toDataURL('image/jpeg', 1);
            $('.changeImgModel').remove();
            $('.layui-layer-btn', parent.document).show();
            $.post(
                '/admin/article/save_img',
                {
                    img:base64,
                    _token :  $("input[name='_token']").val()
                },
                function (res) {
                    res = JSON.parse(res);
                    console.log(res.url);
                    $imgSingle.attr('src',res.url);
                }
            )

        }
    });

    $('.changeImgModel .closeImgBtn').click(function () {
        $('.changeImgModel').remove();
        $('.layui-layer-btn', parent.document).show();
    });

    $('.changeImgModel .selImgBtn').click(function () {
        openBrowseImg()
    });
    $('.changeImgModel #file').change(function(){
        changeFileImg()
    });
    //1.
    function openBrowseImg(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("file").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("file").dispatchEvent(a);
        }
    }

    //2、从 file 域获取 本地图片 url
    function getFileUrlImg(sourceId) {
        var url;
        if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
            url = document.getElementById(sourceId).value;
        } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Safari")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        }
        return url;
    }
    //选择文件事件
    function changeFileImg() {
        var url = getFileUrlImg("file");//根据id获取文件路径
        preImgImg(url);
        return false;
    }
    function preImgImg(url) {
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }
        initTargetImg();
        var image = document.getElementById('targetImg');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;
                if(realWidth<400 || realHeight<400){
                    $targetImg.hide();
                    layer.msg('请选择尺寸不小于400*400px的图片');
                    return;
                }
                else{
                    initJcropImg();
                }
            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.Jcrop({
            // aspectRatio: 513 / 513
        },function(){
            //初始化后回调函数
            // 获取图片实际显示的大小
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度
            jcrop_api = this;
        });
    }
    function initTargetImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }
}

function cropImgToPiece($imgSingle){
    var imgSrc=$imgSingle.attr('src');
    var changeImgModel='<div class="changeImgModel">\n' +
        '\t\t\t\t<button type="button" class="btn btn-success sureImgBtn">确定</button>\n' +
        '\t\t\t\t<button type="button" class="btn btn-warning closeImgBtn">取消</button>'+
        '\t\t\t<div class="head">\n' +
        '\t\t\t\t<img src="'+imgSrc+'"  id="target"/>\n' +
        '\t\t\t</div>\n' +
        '\t\t</div>';
    $('html body').append(changeImgModel);
    // 定义一些使用的变量
    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        // 使用的jquery对象
        $targetImg = $('#target');

    preImgImg(imgSrc);
    $('.changeImgModel .sureImgBtn').click(function () {
        var img = new Image();
        img.src = $('#target').attr('src');
        var realWidth = img.width;
        var realHeight = img.height;
        if(img.src.indexOf('http')!=-1){
            img.crossOrigin = "Anonymous";
            img.src = $('#target').attr('src');
        }

        var showWidth=$('#target').css('width');
        showWidth=showWidth.split('px');
        showWidth=parseInt(showWidth[0]);
        var showHeight=$('#target').css('height');
        showHeight=showHeight.split('px');
        showHeight=parseInt(showHeight[0]);

        // 真实图片和显示图片的宽比  高比
        var ratio=realWidth/showWidth;

        var width=$('.changeImgModel .jcrop-holder>div').css('width');
        if(width=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        width=width.split('px');
        width=parseInt(width[0])*ratio;
        var height=$('.changeImgModel .jcrop-holder>div').css('height');
        if(height=='0px'){
            layer.msg('请裁剪图片再点击确定');
            return;
        }
        height=height.split('px');
        height=parseInt(height[0])*ratio;
        var top=$('.changeImgModel .jcrop-holder>div').css('top');
        top=top.split('px');
        top=parseInt(top[0])*ratio;
        var left=$('.changeImgModel .jcrop-holder>div').css('left');
        left=left.split('px');
        left=parseInt(left[0])*ratio;
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        canvas.width = 300;
        canvas.height = 640;

        img.onload = function() {
            this.width = realWidth;
            this.height = realHeight;
            ctx.drawImage(this, left, top, width, height,0,0,300,640);
            base64 = canvas.toDataURL('image/jpeg', 1);
            $('.changeImgModel').remove();
            $.post(
                '/admin/toutiao/save_img',
                {
                    img:base64,
                    _token :  $("input[name='_token']").val()
                },
                function (res) {
                    res = JSON.parse(res);
                    console.log(res.url);
                    $imgSingle.attr('src',res.url);
                }
            )

        }
    });

    $('.changeImgModel .closeImgBtn').click(function () {
        $('.changeImgModel').remove();
    });
    function preImgImg(url) {
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }
        initTargetImg();
        var image = document.getElementById('target');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;
                initJcropImg();
            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.Jcrop({
            aspectRatio: 300 / 640
        },function(){
            //初始化后回调函数
            // 获取图片实际显示的大小
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度
            jcrop_api = this;
        });
    }
    function initTargetImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }
}

function showImgModel() {
    var firstCla=[];
    var secondCla=[];
    var thirdCla=[];
    var claData;
    claData=JSON.parse(localStorage.getItem('get_categories'));
    console.log(claData);
    for (var i=0;i<claData.length;i++) {
        var parent_id=claData[i]['parent_id'];
        if(parent_id==0){
            firstCla.push(claData[i]);
        }
        if(parent_id==5){
            secondCla.push(claData[i]);
        }
        if(parent_id==48){
            thirdCla.push(claData[i]);
        }
    }
    //一级分类
    var firLen=firstCla.length;
    for (var i=0;i<firLen;i++){
        var option='<option value="'+firstCla[i]['id']+'">'+firstCla[i]['name']+'</option>';
        $('#oneUp').append(option);
        // $("#oneUp").find("option:contains('服饰内衣')").attr("selected",true);
    }
    //二级分类
    var secLen=secondCla.length;
    for (var i=0;i<secLen;i++){
        var option=`<option value="${secondCla[i]['id']}">${secondCla[i]['name']}</option>`;
        $('#twoUp').append(option);
        // $("#twoUp").find("option:contains('女装')").attr("selected",true);
    }
    //三级分类
    var thiLen=thirdCla.length;
    for (var i=0;i<thiLen;i++){
        var option=`<option value="${thirdCla[i]['id']}">${thirdCla[i]['name']}</option>`;
        $('#threeUp').append(option);
        // $("#threeUp").find("option:contains('连衣裙')").attr("selected",true);
    }

    $.post(
        '/admin/base/get_img_data',
        {
            _token :  $("input[name='_token']").val(),
            first_cid:$('#oneUp').val(),
            second_cid:$('#twoUp').val(),
            third_cid:$('#threeUp').val(),
            data_source:$('#data_source').val(),
            key_type:$('#key_type').val(),
            keywords:$('.keywords').val(),
            page_count:20,
            page:1
        },
        function (res) {
            var data=JSON.parse(res);

            $("#pagination").pagination({
                currentPage: data.current_page,
                totalPage: data.last_page,
                callback: function(current) {
                    getImgList(current)
                }
            });


            data=data.data;
            console.log(data);
            var html;

            for(var i=0;i<data.length;i++){
                var category='';
                var category_id=data[i].category_id;
                var category_sub_id=data[i].category_sub_id;
                var category_third_id=data[i].category_third_id;
                // var claData=JSON.parse(localStorage.getItem('get_categories'));
                for (var j=0;j<claData.length;j++) {
                    var id=claData[j]['id'];
                    if(id==category_id || id==category_sub_id || id==category_third_id ){
                        category+=claData[j]['name']+' ';
                    }
                }

                html+=
                    '<tr>'+
                    '<td><input type="checkbox" name="imgCheck" class="imgCheck"></td>'+
                    '<td>图片</td>'+
                    '<td><p>文章标题: '+data[i].title+'</p><div class="imgBox"><img src="'+data[i].content+'"></div></td>'+
                    '<td>'+category+'</td>'+
                    '<td>'+data[i].source+'</td>'+
                    '<td>'+data[i].keywords+'</td>'+
                    '</tr>';
            }
            $('.imgTable tbody').html(html);
            $('.loadingText').hide();
        }
    );

    $( "#imgsortable" ).sortable();
    $( "#imgsortable" ).disableSelection();
    $('.pImgBtn').click(function () {
        for (var i=0;i<3;i++) {
            if($('.pieceImgBox:eq('+i+') img').attr('src')!='undefined'){
                $('.pieceImgBox:eq('+i+') img').attr('id','pieceTargetImg'+(i+1));
            }
            else{
                $('.pieceImgBox:eq('+i+') img').attr('id','pieceTargetImg'+0);
            }
        }
        var img1=$('#pieceTargetImg1').attr('src');
        var img2=$('#pieceTargetImg2').attr('src');
        var img3=$('#pieceTargetImg3').attr('src');
        if(img1!=undefined && img2!=undefined && img3==undefined){
            if(img1.indexOf('kol')==-1 || img2.indexOf('kol')==-1){
                layer.msg('请裁剪图片再拼合');
                return;
            }
        }
        if(img1!=undefined && img2!=undefined && img3!=undefined){
            if(img1.indexOf('kol')==-1 || img2.indexOf('kol')==-1 || img3.indexOf('kol')==-1){
                layer.msg('请裁剪图片再拼合');
                return;
            }
        }

        var img1Width;
        var img1Height;
        var img2Width;
        var img2Height;
        var img3Width;
        var img3Height;
        if(img1!='undefined'){
            img1Width = document.getElementById('pieceTargetImg1').naturalWidth;
            img1Height = document.getElementById('pieceTargetImg1').naturalHeight;
        }
        if(img2!='undefined'){
            img2Width = document.getElementById('pieceTargetImg2').naturalWidth;
            img2Height = document.getElementById('pieceTargetImg2').naturalHeight;
        }
        if(img3!='undefined'){
            img3Width = document.getElementById('pieceTargetImg3').naturalWidth;
            img3Height = document.getElementById('pieceTargetImg3').naturalHeight;
        }
        var img1 = new Image();
        img1.src = $('#pieceTargetImg1').attr('src');
        var img2 = new Image();
        img2.src = $('#pieceTargetImg2').attr('src');
        var img3 = new Image();
        img3.src = $('#pieceTargetImg3').attr('src');

        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var base64;
        if(img1!='undefined'&&img2!='undefined'&&img3!='undefined'){
            canvas.width = img1Width+img2Width+img3Width;
            canvas.height = img1Height;
            ctx.drawImage(img1, 0, 0, img1Width, img1Height);
            ctx.drawImage(img2, img1Width, 0, img2Width, img2Height);
            ctx.drawImage(img3, (img1Width+img2Width), 0, img3Width, img3Height);
        }
        else if (img1!='undefined'&&img2!='undefined'&&img3=='undefined') {
            canvas.width = img1Width+img2Width;
            canvas.height = img1Height;
            ctx.drawImage(img1, 0, 0, img1Width, img1Height);
            ctx.drawImage(img2, img1Width, 0, img2Width, img2Height);
        }
        base64 = canvas.toDataURL('image/jpeg', 1);
        // console.log(base64);
        $('#previewImg').attr('src',base64);
    });
    var jcrop_api,//jcrop对象
        boundx,//图片实际显示宽度
        boundy,//图片实际显示高度
        realWidth,// 真实图片宽度
        realHeight, //真实图片高度
        // 使用的jquery对象
        $targetImg = $('#targetImg');

    $('.uploadImgModel .selImgBtn').click(function () {
        openBrowseImg()
    });

    $('.uploadImgModel #fileImg').change(function(){
        changeFileImg()
    });

    //1、打开浏览器
    function openBrowseImg(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("fileImg").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("fileImg").dispatchEvent(a);
        }
    }
    //2、从 file 域获取 本地图片 url
    function getFileUrlImg(sourceId) {
        var url;
        if (navigator.userAgent.indexOf("MSIE")>=1) { // IE
            url = document.getElementById(sourceId).value;
        } else if(navigator.userAgent.indexOf("Firefox")>0) { // Firefox
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Chrome")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        } else if(navigator.userAgent.indexOf("Safari")>0) { // Chrome
            url = window.URL.createObjectURL(document.getElementById(sourceId).files.item(0));
        }
        return url;
    }
    //选择文件事件
    function changeFileImg() {
        var url = getFileUrlImg("fileImg");//根据id获取文件路径
        preImgImg(url);
        return false;
    }

    //3、将本地图片 显示到浏览器上
    function preImgImg(url) {

        console.log('url===' + url);
        //图片裁剪逻辑
        if(jcrop_api)//判断jcrop_api是否被初始化过
        {
            jcrop_api.destroy();
        }

        //初始化图片
        initTargetImg();
        var image = document.getElementById('targetImg');
        image.onload=function(){//图片加载是一个异步的过程
            //获取图片文件真实宽度和大小
            var img = new Image();
            img.onload=function(){
                realWidth = img.width;
                realHeight = img.height;

                //获取图片真实高度之后
                initJcropImg();//初始化Jcrop插件
                //initCanvasImg();//初始化Canvas内容
            };
            img.src = url;
        };
        image.src = url;
    }

    //初始化Jcrop插件
    function initJcropImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.Jcrop({
            //onChange: updatePreviewImg,
            //onSelect: updatePreviewImg
            // aspectRatio: 513 / 513
        },function(){
            //初始化后回调函数
            // 获取图片实际显示的大小
            var bounds = this.getBounds();
            boundx = bounds[0];//图片实际显示宽度
            boundy = bounds[1];//图片实际显示高度

            // 保存jcrop_api变量
            jcrop_api = this;

        });
    }

    //初始化预览div内容
    function initTargetImg(){
        $targetImg.removeAttr("style");//清空上一次初始化设置的样式
        $targetImg.css({
            maxWidth:  '100%',
            maxHeight: '100%'
        });
    }

    $('.pieceImgModel .upImg1').click(function () {
        openBrowseImg1()
    });

    $('.pieceImgModel #pieceFileImg1').change(function(){
        changeFileImg1()
    });
    function openBrowseImg1(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("pieceFileImg1").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("pieceFileImg1").dispatchEvent(a);
        }
    }
    function changeFileImg1() {
        var url = getFileUrlImg("pieceFileImg1");
        $('#pieceTargetImg1').attr('src',url);
        return false;
    }

    $('.pieceImgModel .upImg2').click(function () {
        openBrowseImg2()
    });

    $('.pieceImgModel #pieceFileImg2').change(function(){
        changeFileImg2()
    });
    function openBrowseImg2(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("pieceFileImg2").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("pieceFileImg2").dispatchEvent(a);
        }
    }
    function changeFileImg2() {
        var url = getFileUrlImg("pieceFileImg2");
        $('#pieceTargetImg2').attr('src',url);
        return false;
    }

    $('.pieceImgModel .upImg3').click(function () {
        openBrowseImg3()
    });

    $('.pieceImgModel #pieceFileImg3').change(function(){
        changeFileImg3()
    });
    function openBrowseImg3(){
        var ie=navigator.appName=="Microsoft Internet Explorer" ? true : false;
        if(ie){
            document.getElementById("pieceFileImg3").click();
        }else{
            var a=document.createEvent("MouseEvents");
            a.initEvent("click", true, true);
            document.getElementById("pieceFileImg3").dispatchEvent(a);
        }
    }
    function changeFileImg3() {
        var url = getFileUrlImg("pieceFileImg3");
        $('#pieceTargetImg3').attr('src',url);
        return false;
    }
}

function getDesData() {
    var firstCla=[];
    var secondCla=[];
    var thirdCla=[];
    var claData;
    claData=JSON.parse(localStorage.getItem('get_categories'));
    console.log(claData);
    for (var i=0;i<claData.length;i++) {
        var parent_id=claData[i]['parent_id'];
        if(parent_id==0){
            firstCla.push(claData[i]);
        }
        if(parent_id==5){
            secondCla.push(claData[i]);
        }
        if(parent_id==48){
            thirdCla.push(claData[i]);
        }
    }
    //一级分类
    var firLen=firstCla.length;
    for (var i=0;i<firLen;i++){
        var option='<option value="'+firstCla[i]['id']+'">'+firstCla[i]['name']+'</option>';
        $('#oneUp').append(option);
        // $("#oneUp").find("option:contains('服饰内衣')").attr("selected",true);
    }
    //二级分类
    var secLen=secondCla.length;
    for (var i=0;i<secLen;i++){
        var option=`<option value="${secondCla[i]['id']}">${secondCla[i]['name']}</option>`;
        $('#twoUp').append(option);
        // $("#twoUp").find("option:contains('女装')").attr("selected",true);
    }
    //三级分类
    var thiLen=thirdCla.length;
    for (var i=0;i<thiLen;i++){
        var option=`<option value="${thirdCla[i]['id']}">${thirdCla[i]['name']}</option>`;
        $('#threeUp').append(option);
        // $("#threeUp").find("option:contains('连衣裙')").attr("selected",true);
    }

    $.post(
        '/admin/base/get_des_data',
        {
            _token :  $("input[name='_token']").val(),
            first_cid:$('#oneUp').val(),
            second_cid:$('#twoUp').val(),
            third_cid:$('#threeUp').val(),
            data_source:$('#data_source').val(),
            key_type:$('#key_type').val(),
            keywords:$('.keywords').val(),
            page_count:20,
            page:1
        },
        function (res) {
            var data=JSON.parse(res);

            $("#pagination").pagination({
                currentPage: data.current_page,
                totalPage: data.last_page,
                callback: function(current) {
                    getDesList(current)
                }
            });


            data=data.data;
            console.log(data);
            var html;

            for(var i=0;i<data.length;i++){
                var category='';
                var category_id=data[i].category_id;
                var category_sub_id=data[i].category_sub_id;
                var category_third_id=data[i].category_third_id;
                // var claData=JSON.parse(localStorage.getItem('get_categories'));
                for (var j=0;j<claData.length;j++) {
                    var id=claData[j]['id'];
                    if(id==category_id || id==category_sub_id || id==category_third_id ){
                        category+=claData[j]['name']+' ';
                    }
                }

                html+=
                    '<tr>'+
                    '<td><input type="radio" name="imgRadio" class="imgCheck"></td>'+
                    '<td>文本</td>'+
                    '<td><p>文章标题: '+data[i].title+'</p><div class="desBox">'+data[i].content+'</div></td>'+
                    '<td>'+category+'</td>'+
                    '<td>'+data[i].source+'</td>'+
                    '<td>'+data[i].keywords+'</td>'+
                    '</tr>';
            }
            $('.imgTable tbody').html(html);
            $('.loadingText').hide();
        }
    )
}

$(document).on('change','input[name="imgCheck"]',function () {
    var checkedLen=$('input[name="imgCheck"]:checked').length;
    if(checkedLen>1){
        $('.layui-layer-btn0', parent.document).text('拼合');
    }
    else{
        $('.layui-layer-btn0', parent.document).text('确认');
    }
});
$(document).on('click','ul#imgTab li',function () {
    var checkedLen=$('input[name="imgCheck"]:checked').length;
    var status='确认';
    if(checkedLen>1){
        status='拼合';
    }
    var index=$('ul#imgTab li').index(this);
    if(index>0){
        $('.layui-layer-btn0', parent.document).text('确认');
    }
    else{
        $('.layui-layer-btn0', parent.document).text(status);
    }
});
// 换描述
$(document).on('click','.changeDesBtn',function () {
    var id=$(this).parents('.IntSingle').attr('data-id');
    var $IntSingle=$(this).parents('.IntSingle');
    if($IntSingle.find('.des_cache').length==0){
        $.get(
            '/admin/article/get_change_goods_describe',
            {
                goods_id: id,
                type:1
            },
            function (res) {
                var res=JSON.parse(res);
                $IntSingle.find('.des_recommend').text(res.DATA[0]);
                $IntSingle.find('.cur_des').text('1');
                $IntSingle.find('.all_des').text(res.DATA.length);
                var des='<div class="des_cache" style="display: none"></div>';
                $IntSingle.append(des);
                for (var i=0;i<res.DATA.length;i++){
                    $('.des_cache').append('<p>'+res.DATA[i]+'</p>');
                }
            }
        )
    }
    else{
        var cur=parseInt($IntSingle.find('.cur_des').text());
        var all=parseInt($IntSingle.find('.all_des').text());

        if(cur<all){
            var curDes=$IntSingle.find('.des_cache p').eq(cur).text();
            $IntSingle.find('.des_recommend').text(curDes);
            $IntSingle.find('.cur_des').text(cur+1);
        }
        else if(cur==all){
            var curDes=$IntSingle.find('.des_cache p').eq(0).text();
            $IntSingle.find('.des_recommend').text(curDes);
            $IntSingle.find('.cur_des').text('1');
        }
    }

});

// insertDesBtn
$(document).on('click','.insertDesBtn',function () {
    var des=$(this).parents('.IntSingle').find('.des_recommend').text();
    $(this).parents('.IntSingle').find('.textareaDes').val(des);
    $(this).parents('.IntSingle').find('.findSensitive').text('');
});

// 换标题
$(document).on('click','.changeTitleBtn',function () {
    var id=$(this).parents('.IntSingle').attr('data-id');
    var $IntSingle=$(this).parents('.IntSingle');
    if($IntSingle.find('.title_cache').length==0){
        $.get(
            '/admin/article/get_change_goods_title',
            {
                goods_id: id
            },
            function (res) {
                var res=JSON.parse(res);
                $IntSingle.find('a').text(res.DATA[0]);
                $IntSingle.find('.cur_title').text('1');
                $IntSingle.find('.all_title').text(res.DATA.length);
                var tit='<div class="title_cache" style="display: none"></div>';
                $IntSingle.append(tit);
                for (var i=0;i<res.DATA.length;i++){
                    $('.title_cache').append('<p>'+res.DATA[i]+'</p>');
                }
            }
        )
    }
    else{
        var cur=parseInt($IntSingle.find('.cur_title').text());
        var all=parseInt($IntSingle.find('.all_title').text());

        if(cur<all){
            var curDes=$IntSingle.find('.title_cache p').eq(cur).text();
            $IntSingle.find('a').text(curDes);
            $IntSingle.find('.cur_title').text(cur+1);
        }
        else if(cur==all){
            var curTitle=$IntSingle.find('.title_cache p').eq(0).text();
            $IntSingle.find('a').text(curTitle);
            $IntSingle.find('.cur_title').text('1');
        }
    }

});

// insertTitleBtn
$(document).on('click','.insertTitleBtn',function () {
    var title=$(this).parents('.IntSingle').find('a').text();
    $(this).parents('.IntSingle').find('.product_title').val(title);
    $(this).parents('.IntSingle').find('.findSensitive').text('');

});

setInterval(function () {
    if($('#article_id').length==0){
        if($('.publishBtn').length>0){
            var title=$('#titleInp').val().length;
            var leads=$('.leads').val().length;
            var len=$('.IntSingle').length;
            var firstImg=$('.firstImg .imgSingle').length;
            if(title>0 || leads>0 || len>0 || firstImg>0){
                var content=$('.content-box-left').html();
                localStorage.setItem('timingToutiaoAlbum',content);
            }
        }
        else if($('.commitBtn').length>0){
            var title=$('#article_title').val().length;
            var leads=$('.leads').val().length;
            var len=$('.IntSingle').length;
            var flag=$('.headImg').attr('data-edit');
            if(len>0){
                var content=$('#sortable').html();
                localStorage.setItem('timingTmAlbum',content);
            }
            if(title>0){
                localStorage.setItem('timingTmTitle',$('#article_title').val());
            }
            if(leads>0){
                localStorage.setItem('timingTmLeads',$('.leads').val());
            }
            if(flag=='1'){
                var src=$('.headImg').attr('src');
                localStorage.setItem('timingTmImg',src);
            }
        }
    }
},2000);











