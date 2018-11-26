<style>

	p{
		/*text-indent: 2em; *//*em是相对单位，2em即现在一个字大小的两倍*/
		padding-left:0px;
	}
	p img{
		padding-left:0px;
	}
	/*手机预览*/
	.pics_phone-preview {
		background-image: url(https://tms3.bytecdn.cn/dist/online/public/img/iphone_7_plus_a6f7b5c.png);
		background-size: cover;
		width: 362px;
		height: 738px;
		padding-top: 94px;
		float: left;
		margin: 10px;
	}
	.preview-pics-content{
		width: 312px;
		height: 555px;
		background-color: #1b1b1b;
		overflow: hidden;
		margin-left: 25px;
		padding-top: 90px;
		position: relative;
	}
	.preview-pics-content img{
		width: 100%;
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

<div class="content-box">

	<input type="hidden" id="article_id" value="{{$article_id or ''}}"/>
	<div class="content-box-body">

	</div>
	<div style="margin:0 auto;text-align: center;position: fixed;top:150px;right:100px">
		<label class="btn-group">
			<button class="btn btn-primary btn-sm" onclick="closeUrl()">关闭</button>
		</label>
	</div>
</div>


<script data-exec-on-popstate>
    $(function () {
        var article_id=$('#article_id').val();
        $.get(
            '/admin/article/get_preview_data',
			{
                article_id:article_id,
                _token :  $("input[name='_token']").val()
			},
			function (res) {
                res=JSON.parse(res);
                var content=res.data.content;
                var title=res.data.title;
                var face_image=res.data.face_image;
                var desc=res.data.desc;
                var type=res.data.type;
                if(type==2 || type==7){
                    var article_content='';
                    for (var i=0;i<content.length;i++){
                        if(content[i].detail_type==2 || content[i].detail_type==5){
                            article_content+= '<div class="article_img">' +
                                '<img  class="tt-img" src="'+content[i].image+'" />' +
                                '</div>' ;
                        }
                        else if(content[i].detail_type==1){
                            article_content+= '<div class="article_des">' +
                                '<div class="tt-des">'+content[i].describe+'</div>' +
                                '</div>' ;
                        }
                        else if(content[i].detail_type==4){
                            article_content+= '<div class="article_card">' +
                                '<div class="tt-card">'+
                                '<div class="tt-card-left">'+
                                '<img  class="tt-img" src="'+content[i].image+'" />' +
                                '</div>' +
                                '<div class="tt-card-right">'+
                                '<a class="tt-link" href="'+content[i].goods_url+'" target="_blank">'+content[i].title+ '</a>' +
                                '<p class="tt-price" >￥'+content[i].price+ '</p>' +
                                '</div>' +
                                '</div>' +
                                '</div>' ;
                        }
                    }

                    var preview = '<div class="phone-preview">' +
                        '<div class="preview-article-content">' +
                        '<div class="tt-title">'+title+'</div>' +
                        '<div class="tt-first-img"><img src="'+face_image+'"></div>' +
                        '<div class="tt-leads">'+desc+'</div>' +
                        '<div class="tt-content">'+article_content+'</div>' +
                        '</div>'+
                        '</div>' ;
                    $('.content-box-body').append(preview);
				}
                else if(type==1 || type==6){
                    var preview='';
                    preview+='<div  class="widget-body mt10"  style="min-height:0px;padding-bottom: 5px;float:left;border-right: none;border-left:none;">'+
							'<div class="widget-body no-padding">'+
							'<div  style="overflow-x:hidden;overflow-y:hidden;text-align:left;">';

                    for (var i=0;i<content.length;i++){
                        preview +='<div class="atlas-preview">' +
                            '<div class="preview-atlas-content">' +
                            '<p><img src="'+content[i].main_picture+'" style="max-width: 312px;"></p> ' +
                            '<div class="phone-des">' +
                            '<p class="goods-title">'+content[i].goods_name+'</p> ' +
                            '<p class="tt-des">'+content[i].main_description+'</p>' +
                            '</div> ' +
                            '<div style="clear: both;"></div>' +
                            '</div>' +
                            '</div>' +
							'<div class="atlas-preview">' +
							'<div class="preview-atlas-content">' +
							'<p><img src="'+content[i].vice_picture+'" style="max-width: 312px;"></p> ' +
							'<div class="phone-des">' +
							'<p class="goods-title"> </p> ' +
							'<p class="tt-des">'+content[i].vice_description+' </p>' +
							'</div> ' +
							'<div style="clear: both;"></div>' +
							'</div>' +
							'</div>' ;
					}
                    preview +='</div></div></div>';

					// var cover='<h3 class="preview-h3">'+title+'</h3><div class="cover-box">' +
                    //     '<p>三图预览：</p>' +
					// 	'<div class="cover-box-three">' +
					//
					// 		'<div class="cover-box-three-big">'+
                    //     		'<img src="'+content[0].main_picture+'">' +
					// 		'</div>' +
					// 		'<div class="cover-box-three-small">'+
					// 			'<img src="'+content[0].main_picture+'" style="margin-bottom: 10px">' +
					// 			'<img src="'+content[1].main_picture+'">' +
					// 		'</div>' +
					// 	'</div>' +
					//
                    // '</div>' ;

                    var cover= '<div  class="pics_phone-preview" >' +
                        '<div class="preview-pics-content" >' +
                        '<div  style="max-width:312px;border:1px solid;background-color: white;">' +
                    	'<div style="width: 100%">' +
                        '<img src="/images/headimg.png"/></div>' +
                        '<div style="width: 90%;font-size: 12px;margin:0 auto">' +
                        '<strong>'+title+'</strong>' +
                    	'</div>'+
						'<br/>'+
						'<div style="text-align: center">';
						if(content.length<2 && content.length>0){
						    cover+='<div>'+
                                '<div style="width: 65%;float: left;padding-left: 3px">'
                            +'<img src="'+content[0].main_picture+'" style="max-width: 100%;" >'
                            +'</div>'
                            +' <div  style="width: 33%;float: left;padding-left: 3px">'
                            +'<img src="'+content[0].vice_picture+'" style="max-width: 100%;" >'
                            +' </div>'
                            +'</div>'
						}
						else{
                            cover+='<div>'+
                                '<div style="width: 30%;float: left;padding-left: 3px">'
                                +'<img src="'+content[0].main_picture+'" style="max-width: 100%;" >'
                                +'</div>'
                                +' <div  style="width: 33%;float: left;padding-left: 3px">'
                                +'<img src="'+content[0].vice_picture+'" style="max-width: 100%;" >'
                                +' </div>'
                                +' <div  style="width: 33%;float: left;padding-left: 3px">'
                                +'<img src="'+content[1].main_picture+'" style="max-width: 100%;" >'
                                +'</div>'
                                +'</div>'
						}

                    cover+='<div style="clear:both;"></div>'+
                        '<div style="width: 100%">'+
						'<img src="/images/footerimg.png"/>'+
						'</div>'+
						'</div>'+
                        '</div>'+

                        '<div class="phone-des-recommend" >'+
						'<p class="goods-title">'+
						'</p>'+
						'<p class="tt-des" style="height:65px;text-overflow: ellipsis;overflow: hidden;margin: auto">'+
						'</p>'+
						'</div>'+
						'<div style="clear:both;"></div>'+
						'</div>'+
						'</div>';

                    cover+='<div class="pics_phone-preview">'+
                        '<div class="preview-pics-content" >'+
                        '<div  style="max-width:312px;border:1px solid;background-color: white;">'+
                        '<div style="width: 100%">'+
                        '<img src="/images/headimg.png"/>'+
                        '</div>'+
                        '<div style="width: 90%;font-size: 12px;margin:0 auto">'+
                        '<strong>'+title+'</strong>'+
                        '</div>'+
                    	'<br/>'+
                    	'<div style="text-align: center">';
                    if(content.length<2 && content.length>0){
                        cover+='<div>'+
                            '<div  style="width: 65%;float: left;padding-left: 3px">'+
                            '<img src="'+content[0].main_picture+'" style="max-width: 100%;" >'+
                        	'</div>'+
                        	'<div style="width: 33%;float: left;padding-left: 3px">'+
                            '<img src="'+content[0].vice_picture+'" style="max-width: 100%;" >'+
                            '</div>'+
                        '</div>';
                    }
                    else{
                        cover+='<div>'+
                            '<div style="width: 65%;float: left;padding-left: 3px">'+
                            '<img src="'+content[0].main_picture+'" style="max-width: 100%;" >'+
                        	'</div>'+
							'<div style="width: 33%;float: left;padding-left: 3px">'+
							'<img src="'+content[0].vice_picture+'" style="max-width: 100%;">'+
                            '</div>'+
                        	'<div style="width: 33%;float: left;padding-left: 3px">'+
                        	'<img src="'+content[1].main_picture+'" style="max-width: 100%;" >'+
                        	'</div>'+
                            '</div>';
						}
                    cover+='</div>'+
                        '<div style="clear:both;"></div>'+
                        '<div style="width: 100%;">'+
                        '<img src="/images/footerimg.png"/>'+
                        '</div>'+
                        '</div>'+

                        '<div class="phone-des-recommend" >'+
                        '<p class="goods-title">'+
                        '</p>'+
                        '<p class="tt-des" style="height:65px;text-overflow: ellipsis;overflow: hidden;margin: auto">'+
                        '</p>'+
                        '</div>'+
                        '<div style="clear:both;"></div>'+
                        '</div>'+
                        '</div>';

                    $('.content-box-body').append(cover);
                    $('.content-box-body').append(preview);
                    var h=document.body.scrollHeight;
                    $('.content-box').css({'height':h+'px'})
                }
            }
		)
	})

function closeUrl(){
    window.opener=null;
    window.open('','_self');
    window.close();
}

</script>

