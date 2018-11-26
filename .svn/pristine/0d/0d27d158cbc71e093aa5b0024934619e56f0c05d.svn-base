/**
 * Created by Administrator on 2018-09-13.
 */

$('#get_goods_data').click(function () {
    $('#goods_url_data .request-tip').show();
    if($('#img_panel')){
        $('#img_panel').hide();
    }
    if($('#goods_data')){
        $('#goods_data').hide();
    }

    var url = $('#tb_goods_link').val();

    if(url == "" ){
        layer.alert('请输入url进行查询!');
        return;
    }
    else{
        $.post(
            '/admin/toutiao/get_goods_data',
            {
                url:url,
                _token :  $("input[name='_token']").val()
            },
            function(res) {
                console.log(res);
                $('#img_box').empty();
                $('#goods_data_box').empty();
                var status = res.status;
                var msg = res.msg;
                var data = res.data;
                $('#goods_url_data .request-tip').hide();
                if(status == 0){
                    if(data.imgs.length>0){
                        $('#img_panel').show();

                        var img_ul = '<ul class="img_ul">';
                        for (var i=0;i<data.imgs.length;i++){
                            if(i == 0){
                                img_ul += '<li class="img_active"><img src="'+data.imgs[i]+'" class="tb_goods_imgs" /></li>'
                            }
                            else{
                                img_ul += '<li><img src="'+data.imgs[i]+'" class="tb_goods_imgs img-rounded" alt="Cinque Terre"/></li>'
                            }
                        }
                        img_ul +='</ul>';
                        $('#img_box').html(img_ul);
                    }

                    if(data.open_id != ""){
                        $('#goods_data').show();
                        var data_html = "";

                        data_html += '<div class="box-body">';

                        data_html += '<div class="box-body-left">';
                        data_html += '<div class="goods_img_box">';
                        data_html += '<img src="'+data.pic_url+'" id="now_goods_img"/>';
                        // data_html += '<span class="cut-img-tip">裁剪图片</span>';
                        data_html += '</div>';
                        data_html += '</div>';
                        data_html += '<div class="box-body-right">';
                        data_html += '<div class="goods_data_datail">';
                        data_html += '<div class="datail_box">';
                        data_html += '<span class="datail_title">产品名称：</span>';
                        data_html += '<a class="goods_title" href="'+url+'" target="_blank"><span id="title">'+data.title+'</span></a>';
                        data_html += '</div>';
                        data_html += '<div class="datail_box">';
                        data_html += '<span class="datail_title">价钱：</span><span id="price">'+data.price+'</span>';
                        data_html += '</div>';
                        data_html += '<div class="datail_box">';
                        data_html += '<span class="datail_title">原价：</span><span id="reserve_price">'+data.reserve_price+'</span>';
                        data_html += '</div>';
                        data_html += '<div class="datail_box">';
                        data_html += '<span class="datail_title">店铺名称：</span><span id="shop_name">'+data.shop_name+'</span>';
                        data_html += '</div>';
                        data_html += '</div>';
                        data_html += '</div>';
                        data_html += '</div>';

                        $('#goods_data_box').html(data_html);
                    }

                }
                else{
                    $('#img_panel').hide();
                    layer.alert(msg);
                }
            }
        );
    }
});


$(document).on('click','.tb_goods_imgs',function () {
    $('.img_ul li').removeClass('img_active');

    $(this).parent().addClass('img_active');
    var path = $(this)[0].src;
    $('#now_goods_img').attr('src',path);
});


$(document).on('dblclick','.tb_goods_imgs',function () {
    var path = $(this)[0].src;
    var img = "<img src='" + path + "' style='height:733px'/>";


    layer.open({
        type: 1,
        title: false, //不显示标题
        area:['auto','auto'],
        shade: [0.8, '#393D49'],
        shadeClose:true,

        // area: [img.width + 'px', img.height+'px'],
        content: img, //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        cancel: function () {
            //layer.msg('图片查看结束！', { time: 5000, icon: 6 });
        }
    });

});



function callbackdata() {
    var data = {};
    var img_box = $('#img_box').html();
    var title = $('#title').html();
    var price = $('#price').html();
    var reserve_price = $('#reserve_price').html();
    var shop_name = $('#shop_name').html();
    var url = $('.goods_title').attr('href');
    var img = $('#now_goods_img')[0].src;
    data['img_box'] = img_box;
    data['title'] = title;
    data['price'] = price;
    data['reserve_price'] = reserve_price;
    data['shop_name'] = shop_name;
    data['url'] = url;
    data['img'] = img;
    return data;
}


function cropImg($imgSingle){
    var imgSrc=$imgSingle.attr('src');
    var changeImgModel='<div class="changeImgModel" style="z-index: 999999999">\n' +
        '\t\t\t\t<button type="button" class="btn btn-success sureImgBtn">确定</button>\n' +
        '\t\t\t\t<button type="button" class="btn btn-warning closeImgBtn">取消</button>'+
        '\t\t\t<div class="head">\n' +
        '\t\t\t\t<img src="'+imgSrc+'"  id="targetImg"/>\n' +
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
    $('.layui-layer-btn', parent.document).hide();
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
            $('.changeImgModel').remove();
            $('.layui-layer-btn', parent.document).show();
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
        $('.layui-layer-btn', parent.document).show();
    });
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
}

// 裁剪图片
$(document).on('click','.goods_img_box .cut-img-tip',function () {
    var $imgSingle=$(this).siblings('img');

    cropImg($imgSingle);

})