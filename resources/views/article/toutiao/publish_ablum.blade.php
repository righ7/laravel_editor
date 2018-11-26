<div class="content-box">
	<div class="content-box-left" >
		<div class="form-group titleBox">
			<input type="text" class="form-control" id="titleInp"  class="titleInp" placeholder="请输入4～19个汉字的标题，结尾不能为句号或叹号">
			<span class="title_tip">0/19</span>
		</div>

		<div class="firstImg">
			<button type="button" class="btn btn-primary AddFirstImg">添加首图</button>
		</div>

		<div class="leadsBox">
			<textarea class="form-control leads" rows="3" placeholder="请输入10～100个汉字的导语"></textarea>
			<span class="leads_tip">0/100</span>
		</div>

		<div class="addBtnBox">
			{{--<button type="button" class="btn btn-primary addIntBtn">添加段落导语</button>--}}
			{{--<button type="button" class="btn btn-primary addImgBtn">添加图片</button>--}}
			{{--<button type="button" class="btn btn-primary addBabyBtn">添加宝贝</button>--}}
			{{--<label class="checkbox-inline isLocationLabe">--}}
				{{--<input type="checkbox" id="isLocation" value=""> 是否定位模块--}}
			{{--</label>--}}
			{{--<span class="productNumSpan">产品数</span>--}}
			<input type="number" class="productNum" placeholder="请输入产品数" min="2">
			<button type="button" class="btn btn-primary modelBtn">生成模板</button>
			<button type="button" class="btn btn-primary lineBtn">分割线选择</button>
			<span class="lineBox"><img src="http://p3a.pstatp.com/large/1f7700011f8c20db3b29"></span>
			{{--<Date-picker type="datetime" placeholder="Select date" style="width: 200px"></Date-picker>--}}
		</div>
		<div id="sortable"></div>


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

		var timingData=localStorage.getItem('timingToutiaoAlbum');
		if(timingData){
            layer.confirm('是否加载缓存的文章数据',function (index) {
                $('.content-box-left').html(timingData);
                $( "#sortable" ).sortable();
                $( "#sortable" ).disableSelection();
                var title=$('#titleInp').attr('data-title');
                if(title!=''){
                    $('#titleInp').val(title);
				}
                var leads=$('.leads').attr('data-leads');
                if(leads!=''){
                    $('.leads').val(leads);
                }
                var desLen=$('.textareaBox').length;
                if(desLen>0){
                    for (var i=0;i<desLen;i++) {
                        var text=$('.textareaDes').eq(i).attr('data-text');
                        $('.textareaDes').eq(i).val(text);
					}

				}
                layer.close(index);
            },function (index) {
                localStorage.removeItem('timingToutiaoAlbum');
                layer.close(index);
            });
		}
    });


</script>

