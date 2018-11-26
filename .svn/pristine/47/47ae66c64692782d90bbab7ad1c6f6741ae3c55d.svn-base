<div class="content-box">
	<div class="content-box-left">
		<div class="form-group titleBox">
			<input type="hidden" id="article_id" value="{{$data['article_id'] or ''}}"/>
			<input type="text" class="form-control" id="titleInp" value="{{$data['title'] or ''}}" class="titleInp" placeholder="请输入4～19个汉字的标题，结尾不能为句号或叹号">
			<span class="title_tip">0/19</span>
		</div>



		<div class="firstImg">
			@if(!empty($data['face_image']))
				<img class="imgSingle" src="{{$data['face_image']}}" />
				<button type="button" class="btn btn-primary btn-sm changeImgBtn">
					<span class="glyphicon glyphicon-pencil"></span>
				</button>
				<button type="button" class="btn btn-primary btn-sm cutImgBtn">
					<span class="glyphicon glyphicon-scissors"></span>
				</button>
			@else
				<button type="button" class="btn btn-primary AddFirstImg">添加首图</button>
			@endif
		</div>

		<div class="leadsBox">
			<textarea class="form-control leads" rows="3" placeholder="请输入10～100个汉字的导语">{{$data['desc'] or ''}}</textarea>
			<span class="leads_tip">0/100</span>
		</div>

		<div class="addBtnBox">
			<input type="number" class="productNum" placeholder="请输入产品数" min="2">
			<button type="button" class="btn btn-primary modelBtn">生成模板</button>
			<button type="button" class="btn btn-primary lineBtn">分割线选择</button>
			<span class="lineBox"><img src="http://p3a.pstatp.com/large/1f7700011f8c20db3b29"></span>

		</div>
		<div id="sortable">
			@if(!empty($data['content']))
				@foreach($data['content'] as $k=>$v)
					@if($v['detail_type'] == 1)
						<div class="IntSingle">
							<p class="IntHead">段落导语<span class="delBtn">X</span></p>
							<div class="IntSingleBox">
								<div class="textareaBox">
									<textarea class="form-control textareaDes" rows="4" placeholder="请输入10～100个汉字的导语">{{$v['describe'] or ''}}</textarea>
									<span class="des_tip">0/100</span>
								</div>
								<button type="button" class="btn btn-primary getDesBtn">获取描述</button>
							</div>
						</div>
					@elseif($v['detail_type'] == 2)
						<div class="IntSingle">
							<p class="IntHead">段落图片<span class="delBtn">X</span></p>
							<div class="IntContent">
								<img class="imgSingle" src="{{$v['image'] or ''}}"/>
								<button type="button" class="btn btn-primary btn-sm changeImgBtn">
									<span class="glyphicon glyphicon-pencil"></span>
								</button>
								<button type="button" class="btn btn-primary btn-sm cutImgBtn">
									<span class="glyphicon glyphicon-scissors"></span>
								</button>
							</div>
						</div>
					@elseif($v['detail_type'] == 4)
						<div class="IntSingle">
							<p class="IntHead">产品卡<span class="delBtn">X</span></p>
							<div class="IntContent">
								<div class="ul_img_box" style="display: none"></div>
								<div class="div_left"><img src="{{$v['image'] or ''}}" class="goods_img"/><span class="change_img">更换图片</span></div>
								<div class="div_center">
									<div>
										<a href="{{$v['goods_url'] or ''}}" target="_blank">{{$v['title'] or ''}}</a>
									</div>
									<div><span>￥</span><span class="price">{{$v['price'] or ''}}</span></div>
									<div><span class="shop_name">{{$v['shop_name'] or ''}}</span></div>
									</div>
								<button type="button" class="btn btn-default changeProductBtn">更换产品</button>
							</div>
						</div>
					@elseif($v['detail_type'] == 5)
						<div class="IntSingle" style="height: 94px">
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
			<button type="button" class="btn btn-primary publishBtn">发布</button>
			<button type="button" class="btn btn-default timingPublishBtn" data-timing="0">定时发布</button>
			<button type="button" class="btn btn-default previewBtn">预览</button>
			<button type="button" class="btn btn-default draftBtn">存草稿</button>
		</div>
		<div class="refresh-preview">
			<div class="preview-article-content">
				<div class="tt-title"></div>
				<div class="tt-first-img"></div>
				<div class="tt-leads"></div>
				<div class="tt-content"></div>
			</div>
			<div class="refreshBtn">
				<button type="button" class="btn btn-primary btn-xs">
					<span class="glyphicon glyphicon-refresh">刷新</span>
				</button>
			</div>
			<div class="bg-white"></div>
		</div>
	</div>
</div>


<script data-exec-on-popstate>
    $(function () {
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();

		$.get(
		    '/admin/base/get_categories',
			function (res) {
                localStorage.setItem('get_categories',res);
            }
		);

        // var article_id=$('#article_id').val();
		// var editData=localStorage.getItem('editToutiaoAlbum'+article_id);
		// if(editData){
        //     layer.confirm('是否读取上次修改内容',function (index) {
        //         $('.content-box-left').html(editData);
        //         $( "#sortable" ).sortable();
        //         $( "#sortable" ).disableSelection();
        //         var title=$('#titleInp').attr('data-title');
        //         if(title!=''){
        //             $('#titleInp').val(title);
		// 		}
        //         var leads=$('.leads').attr('data-leads');
        //         if(leads!=''){
        //             $('.leads').val(leads);
        //         }
        //         var desLen=$('.textareaBox').length;
        //         if(desLen>0){
        //             for (var i=0;i<desLen;i++) {
        //                 var text=$('.textareaDes').eq(i).attr('data-text');
        //                 $('.textareaDes').eq(i).val(text);
		// 			}
		//
		// 		}
        //         layer.close(index);
        //     },function (index) {
        //         layer.close(index);
        //     });
		// }
    });



</script>

