@extends ('backend.layouts.alert_app')

@section('after-styles')
	<link rel="stylesheet" href="{{ admin_asset("/css/admin/goods_data.css") }}">
	<link rel="stylesheet" href="{{ admin_asset("/css/Jcrop/jquery.Jcrop.min.css") }}">
@stop

@section('content')
	<div class="">
		<ul id="myTab" class="nav nav-tabs">
			<li class="active">
				<a href="#goods_url_data" data-toggle="tab">获取商品信息</a>
			</li>
			<li><a href="#goods_data_list" data-toggle="tab">商品列表</a></li>
		</ul>
		<div class="box-body">
			<div id="myTabContent" class="tab-content">
				<div class="tab-pane fade in active" id="goods_url_data">
					<div class="box-body">
						<div class="form-group">

							<label class="col-sm-1 control-label">商品链接</label>

							<div class="col-sm-6">

								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-internet-explorer fa-fw"></i></span>
									<input type="url" id="tb_goods_link" name="goods_link" value="" class="form-control goods_link" placeholder="请输入淘宝/天猫Url">
								</div>

							</div>
							<div class="col-sm-2">
								{{ csrf_field()  }}
								<button type="button" class="btn btn-primary" id="get_goods_data">获取商品信息</button>
							</div>
						</div>

					</div>
					<div class="request-tip">正在获取商品信息......请勿重复点击</div>
					<div class="panel panel-default" id="img_panel">
						<div class="panel-heading">
							请点击下方图片设置商品卡主图,双击图片查看图片大图
						</div>
						<div class="panel-body" id="img_box" style="padding: 0">

						</div>
					</div>

					<div class="panel panel-default" id="goods_data" >
						<div class="panel-body" id="goods_data_box" style="padding: 0">

						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="goods_data_list">
					<p>功能开发中……</p>
				</div>
			</div>
		</div>

	</div>
	{{--    {{ Form::close() }}--}}
@stop

@section('after-scripts')
	<script src="{{ admin_asset ('/js/layer/layer.js') }}"></script>
	<script src="{{ admin_asset ('/js/admin/get_goods_data.js') }}"></script>
	<script src="{{ admin_asset ('/js/Jcrop/jquery.Jcrop.min.js') }}"></script>

@stop
