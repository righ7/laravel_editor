<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="X-UA-Compatiblecontent="IE=edge,chrome=1">
    <meta charset="utf-8">
    
    <title><?php echo e(Admin::title()); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    

    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css")); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/font-awesome/css/font-awesome.min.css")); ?>">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/AdminLTE/dist/css/skins/" . config('admin.skin') .".min.css")); ?>">

    <?php echo Admin::css(); ?>

    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/laravel-admin/laravel-admin.css")); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/nprogress/nprogress.css")); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/sweetalert2/dist/sweetalert2.css")); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/nestable/nestable.css")); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/toastr/build/toastr.min.css")); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/bootstrap3-editable/css/bootstrap-editable.css")); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/google-fonts/fonts.css")); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css")); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/menu-top/menu-top.css")); ?>">

    

    <!-- REQUIRED JS SCRIPTS -->
    <script src="<?php echo e(admin_asset ("/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")); ?>"></script>

    <?php echo Admin::before_js(); ?>


    <script src="<?php echo e(admin_asset ("/vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js")); ?>"></script>
    <script src="<?php echo e(admin_asset ("/vendor/laravel-admin/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js")); ?>"></script>
    <script src="<?php echo e(admin_asset ("/vendor/laravel-admin/AdminLTE/dist/js/app.min.js")); ?>"></script>
    <script src="<?php echo e(admin_asset ("/vendor/laravel-admin/jquery-pjax/jquery.pjax.js")); ?>"></script>
    <script src="<?php echo e(admin_asset ("/vendor/laravel-admin/nprogress/nprogress.js")); ?>"></script>



    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <![endif]-->

</head>

<body class="hold-transition <?php echo e(config('admin.skin')); ?> <?php echo e(join(' ', config('admin.layout'))); ?>">
<div class="wrapper">

    <?php echo $__env->make('admin::partials.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('admin::partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="content-wrapper" id="pjax-container">
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo Admin::script(); ?>

    </div>

    

</div>

<!-- ./wrapper -->

<script>
    function LA() {}
    LA.token = "<?php echo e(csrf_token()); ?>";
</script>

<!-- REQUIRED JS SCRIPTS -->
<script src="<?php echo e(admin_asset ("/vendor/laravel-admin/nestable/jquery.nestable.js")); ?>"></script>
<script src="<?php echo e(admin_asset ("/vendor/laravel-admin/toastr/build/toastr.min.js")); ?>"></script>
<script src="<?php echo e(admin_asset ("/vendor/laravel-admin/bootstrap3-editable/js/bootstrap-editable.min.js")); ?>"></script>
<script src="<?php echo e(admin_asset ("/vendor/laravel-admin/sweetalert2/dist/sweetalert2.min.js")); ?>"></script>
<?php echo Admin::js(); ?>

<script src="<?php echo e(admin_asset ("/vendor/laravel-admin/laravel-admin/laravel-admin.js")); ?>"></script>
<script src="<?php echo e(admin_asset ("/vendor/laravel-admin/menu-top/menu-top.js")); ?>"></script>

<?php echo $__env->yieldContent('after-scripts'); ?>
</body>
</html>
