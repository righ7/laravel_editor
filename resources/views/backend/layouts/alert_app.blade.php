<!doctype html>
<html class="no-js" lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title', "")</title>

	<!-- Meta -->
	<meta name="description" content="@yield('meta_description', 'Default Description')">
	<meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
@yield('meta')

<!-- Styles -->
@yield('before-styles')

<!-- Check if the language is set to RTL, so apply the RTL layouts -->
	<!-- Otherwise apply the normal LTR layouts -->


	<link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">

	<!-- Theme style -->
	<link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/dist/css/skins/" . config('admin.skin') .".min.css") }}">

	{!! Admin::css() !!}
	<link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/laravel-admin/laravel-admin.css") }}">
	<link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/nprogress/nprogress.css") }}">
	<link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/sweetalert2/dist/sweetalert2.css") }}">
	<link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/nestable/nestable.css") }}">
	<link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/toastr/build/toastr.min.css") }}">
	<link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/bootstrap3-editable/css/bootstrap-editable.css") }}">
	<link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/google-fonts/fonts.css") }}">
	<link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css") }}">
	<link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/menu-top/menu-top.css") }}">
	@yield('after-styles')

	<script src="{{ admin_asset ("/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
	<script src="{{ admin_asset ("/vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js") }}"></script>
	<script src="{{ admin_asset ("/vendor/laravel-admin/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>
	<script src="{{ admin_asset ("/vendor/laravel-admin/AdminLTE/dist/js/app.min.js") }}"></script>
	<script src="{{ admin_asset ("/vendor/laravel-admin/jquery-pjax/jquery.pjax.js") }}"></script>
	<script src="{{ admin_asset ("/vendor/laravel-admin/nprogress/nprogress.js") }}"></script>


	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<!-- Scripts -->
	<script>
		window.Laravel = <?php echo json_encode([
				'csrfToken' => csrf_token(),
		]); ?>
	</script>
</head>
<body>
	<!-- Main content -->
	<section class="content">
		@yield('content')
	</section><!-- /.content -->
	@yield('before-scripts')

	@yield('after-scripts')
</body>
</html>