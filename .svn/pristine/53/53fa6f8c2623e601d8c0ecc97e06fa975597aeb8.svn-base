<style>
	.product_first{
		width: 100%;
	}

	.product_element{
		width: 100%;
	}
	.li_element{
		cursor: pointer;
		width: 180px;
		height: 150px;
		margin: 10px;
		float: left;

	}

	.li_img{
		height: 120px;
		margin: 0;
	}
	.product_car{
		width: 350px;
	}
	.IntSingle{
		width: 300px;
	}
	.IntContent{
		text-align: center;
	}
	.pull-center{
		text-align: center;
	}
	#return{
		margin-right: 10px;
	}
	#confirm{
		margin-left: 10px;
	}
</style>

<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">创建</h3>
	</div>

	{{--<form action="/admin/article_template/store" method="post" class='form-horizontal' role = 'form' enctype="multipart/form-data">--}}
	<div class="box-body">
			<div class="form-group">
				<label class="col-lg-2 control-label">模板名称</label>
				<div class="col-lg-10">
					<input type="text" id="template_name" name="template_name" value="{{$data['template_name'] ?? ""}}" class="form-control"/>
					<input type="hidden" id="template_id" name="template_id" value="{{$data['id'] ?? ""}}" class="form-control"/>
				</div><!--col-lg-10-->
			</div><!--form control-->
	</div>
		<div class="box-body">
			<div class="form-group">
				<label class="col-lg-2 control-label">平台</label>
				<div class="col-lg-10">
					<select name="platform" id="platform" class="form-control">
						<option value="0">全部</option>
						<option value="1">头条</option>
						<option value="2">特卖</option>
					</select>
					<input type="hidden" id="platform_old" value="{{$data['platform'] ?? ""}}" class="form-control"/>
				</div><!--col-lg-10-->
			</div><!--form control-->
		</div>
	<div class="box-body">
			<div class="form-group">
				<label class="col-lg-2 control-label">自定义模板选择</label>
				<div class="col-lg-10">
					<div class="box-body">
						<div class="product_first">
							<ul class="product_element">
								<li class="li_element" id="p1_t1">
									<img src="/images/p1-t1.png" class="li_img p_t article_content"/><br>
									<label>（产品1-图1）</label>
								</li>
								<li class="li_element" id="p1_t2">
									<img src="/images/p1-t2.png" class="li_img p_t article_content"/><br>
									<label>（产品1-图2）</label>
								</li>
								<li class="li_element" id="p1_m1">
									<label class="li_img article_content">产品1的第一段描述</label>
									<label>（产品1-描述1）</label>
								</li>
								<li class="li_element" id="p1_m2">
									<label class="li_img article_content">产品1的第二段描述</label>
									<label>（产品1-描述2）</label>
								</li>
								<li class="li_element product_car" id="p1_car">
									<img src="/images/p1.png" class="li_img p_p article_content"/><br>
									<label>（产品1）</label>
								</li>
							</ul>
						</div>

						<div class="product_second">
							<ul class="product_element">
								<li class="li_element" id="p2_t1">
									<img src="/images/p2-t1.png" class="li_img p_t article_content"/><br>
									<label>（产品2-图1）</label>
								</li>
								<li class="li_element" id="p2_t2">
									<img src="/images/p2-t2.png" class="li_img p_t article_content"/><br>
									<label>（产品2-图2）</label>
								</li>
								<li class="li_element" id="p2_m1">
									<label class="li_img article_content">产品2的第一段描述</label>
									<label>（产品2-描述1）</label>
								</li>
								<li class="li_element" id="p2_m2">
									<label class="li_img article_content">产品2的第二段描述</label>
									<label>（产品2-描述2）</label>
								</li>
								<li class="li_element product_car" id="p2_car">
									<img src="/images/p2.png" class="li_img p_p article_content"/><br>
									<label>（产品2）</label>
								</li>
							</ul>
						</div>
					</div>
				</div><!--col-lg-10-->
			</div><!--form control-->
	</div>
	<div class="box-body">
		<div class="form-group">
			<label class="col-lg-2 control-label">自定义模板</label>
			<div class="col-lg-10">
				<div id="sortable" class="ui-sortable">
					@if(!empty($data['template']))
						@foreach($data['template'] as $k=>$v)
							<div class="IntSingle" id="{{$v}}">
								<p class="IntHead">
									@if($v == 'p1_t1')
										产品1（图1）
									@elseif($v == 'p1_t2')
										产品1（图2）
									@elseif($v == 'p1_m1')
										产品1（描述1）
									@elseif($v == 'p1_m2')
										产品1（描述2）
									@elseif($v == 'p1_car')
										产品1
									@elseif($v == 'p2_t1')
										产品2（图1）
									@elseif($v == 'p2_t2')
										产品2（图2）
									@elseif($v == 'p2_m1')
										产品2（描述1）
									@elseif($v == 'p2_m2')
										产品2（描述2）
									@else
										产品2
									@endif

									<span class="delBtn">X</span>
								</p>
								<div class="IntContent">
									@if($v == 'p1_t1')
										<img src="/images/p1-t1.png" style="height: 120px"/>
									@elseif($v == 'p1_t2')
										<img src="/images/p1-t2.png" style="height: 120px"/>
									@elseif($v == 'p1_m1')
										<p>产品1的第一段描述</p>
									@elseif($v == 'p1_m2')
										<p>产品1的第二段描述</p>
									@elseif($v == 'p1_car')
										<img src="/images/p1.png" style="height: 120px"/>
									@elseif($v == 'p2_t1')
										<img src="/images/p2-t1.png" style="height: 120px"/>
									@elseif($v == 'p2_t2')
										<img src="/images/p2-t2.png" style="height: 120px"/>
									@elseif($v == 'p2_m1')
										<p>产品2的第一段描述</p>
									@elseif($v == 'p2_m2')
										<p>产品2的第二段描述</p>
									@else
										<img src="/images/p2.png" style="height: 120px"/>
									@endif
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
	<div class="box-body">
		<div class="box-body">
			<div class="pull-center">
				<input type="button" class="btn btn-warning" id="return" value="返回"/>
				<input type="button" class="btn btn-success" id="confirm" value="确定"/>
			</div><!--pull-right-->

			<div class="clearfix"></div>
		</div><!-- /.box-body -->
	</div>
	{{--</form>--}}
</div>
<script>
	$(function () {
		$('#sortable').sortable({
			cursor:"move",
			items:'.IntSingle',
			optcity:0.6
		});

		var platform_old = $('#platform_old').val();
		$('#platform').val(platform_old);
	});
	$(document).on('click','.li_element',function () {
		var id = $(this).attr('id');
		var content = "";
		var content_title = "";

		switch (id){
			case "p1_t1":
				content_title = "产品1（图1）";
				break;
			case "p1_t2":
				content_title = "产品1（图2）";
				break;
			case "p1_m1":
				content_title = "产品1（描述1）";
				break;
			case "p1_m2":
				content_title = "产品1（描述2）";
				break;
			case "p1_car":
				content_title = "产品1";
				break;
			case "p2_t1":
				content_title = "产品2（图1）";
				break;
			case "p2_t2":
				content_title = "产品2（图2）";
				break;
			case "p2_m1":
				content_title = "产品2（描述1）";
				break;
			case "p2_m2":
				content_title = "产品2（描述2）";
				break;
			case "p2_car":
				content_title = "产品2";
				break;
		}

		if(id == 'p1_m1' || id == 'p1_m2' || id=='p2_m1' || id=='p2_m2' ){
			var larbel_content = $(this).find('.article_content').text();

			content = '<p>'+larbel_content+'</p>';
		}
		else{
			var img_content = $(this).find('.article_content').attr('src');
			content = '<img src="'+img_content+'" style="height: 120px"/>';
		}

		var html = '<div class="IntSingle" id="'+id+'"><p class="IntHead">'+content_title+'<span class="delBtn">X</span></p><div class="IntContent">'+content+'</div></div>';
		$('#sortable').append(html);
	});

	$('#confirm').click(function () {
		var template_name = $('#template_name').val();

		if(template_name == "" || template_name ==  undefined){
			layer.alert('模板名称不能为空');
			return;
		}
		var template_list = [];
		$('.IntSingle').each(function (i) {
			var template_one = $(this).attr('id');
			template_list[i] = template_one;
		});
		var template = "";
		if(template_list.length>0){
			template = template_list.join(',');

			$.post(
					'/admin/article_template/store',
					{
						_token:LA.token,
						template_id:$('#template_id').val(),
						template_name:template_name,
						platform:$('#platform').val(),
						template:template
					},
					function(data){
						layer.alert(data.msg,function () {
							window.location ='/admin/article_template';
						});
					},
					"json"//这里设置了请求的返回格式为"json"
			);
		}
		else{
			layer.alert('请自定义模板内容！');
		}

	});

	$('#return').click(function () {
        window.location ='/admin/article_template';
    });
</script>

