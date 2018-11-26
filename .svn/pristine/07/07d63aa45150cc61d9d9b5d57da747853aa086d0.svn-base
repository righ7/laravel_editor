<div class="content-box" id="app">
	<div class="">
		<div class="form-group titleBox">
			<div class="form-group titleDiv">
				<input type="text" class="form-control" id="titleInp"  class="titleInp" placeholder="请输入4～19个汉字的标题，结尾不能为句号或叹号">
				<span class="title_tip">0/19</span>
			</div>
			<button type="button" class="btn btn-primary addBabyAtlas">添加宝贝</button>
		</div>

		<div id="sortable" style="overflow: hidden"></div>

		<div class="saveBtnBox">
			{{ csrf_field()}}
			<button type="button" class="btn btn-primary publishBtn">发布</button>
			<button type="button" class="btn btn-default previewBtn">预览</button>
			<button type="button" class="btn btn-default draftBtn">存草稿</button>
		</div>
	</div>
</div>


<script data-exec-on-popstate>
    $(function () {
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();



    });


</script>

