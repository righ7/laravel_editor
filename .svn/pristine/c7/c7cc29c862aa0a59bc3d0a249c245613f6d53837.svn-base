/**
 * Created by Administrator on 2018-09-13.
 */

// $('.addBabyBtn').click(function () {
$(document).on('click','.addBabyBtn',function () {
    var url = '/admin/toutiao/get_goods_data_view';
    layer.open({
        type: 2,
        title: "添加淘宝商品", //不显示标题
        area:['80%','100%'],
        shade: [0.8, '#393D49'],
        shadeClose:false,
        // area: [img.width + 'px', img.height+'px'],
        content: url, //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        closeBtn:0,
        //右下角按钮文本和数目控制
        btn: ['确认','取消'],
        yes:function(index, layero){
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

            $('#sortable').append(intHtml);
            var goodsImgSrc=$('.goods_img:last').attr('src');
            if(goodsImgSrc.indexOf('http')!=-1){
                getUrlBase64(goodsImgSrc, 'jpeg', function (base64) {
                    $('.goods_img:last').attr('src',base64);
                });
            }
            var width=$('.IntSingle .goods_img').width();
            $('.IntSingle .change_img').css({'width':width+'px'});

            // $('.IntSingle .change_img').click(function () {


            layer.close(index);
            if($('#isLocation').is(':checked')) {
                var len=$('#sortable .IntSingle').length;
                $('#sortable .IntSingle:last').attr('id',len);
                $("html,body").animate({scrollTop: $("#"+len).offset().top}, 500);
            }


            function getUrlBase64(url, ext, callback) {
                var canvas = document.createElement("canvas");   //创建canvas DOM元素
                var ctx = canvas.getContext("2d");
                var img = new Image;
                img.crossOrigin = 'Anonymous';
                img.src = url;
                img.onload = function () {
                    canvas.height = 733; //指定画板的高度,自定义
                    canvas.width = 733; //指定画板的宽度，自定义
                    ctx.drawImage(img, 0, 0, 733, 733); //参数可自定义
                    var dataURL = canvas.toDataURL("image/" + ext);
                    callback.call(this, dataURL); //回掉函数获取Base64编码
                    canvas = null;
                };
            }
        }
    });
});