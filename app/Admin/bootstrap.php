<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Encore\Admin\Form::forget(['map', 'editor']);

Admin::before_js('/lib/vue.min.js');
Admin::before_js('/lib/iview/iview.min.js');
Admin::before_js('/lib/axios.min.js');
Admin::before_js('/js/jquery-ui.js');
Admin::js('/js/show_error_url.js');
Admin::js('/js/indexCrop.js');
Admin::js('/js/admin/addGoods.js');
Admin::js('/js/admin/get_goods_data.js');
Admin::js('/js/Jcrop/jquery.Jcrop.min.js');
Admin::js('/js/layer/layer.js');
Admin::js('/js/jquery.pagination.min.js');


Admin::css('/lib/iview/styles/iview.css');
Admin::css('/css/jquery.pagination.css');
Admin::css('/css/layui.css');
Admin::css('/css/indexCrop.css');
Admin::css('/css/Jcrop/jquery.Jcrop.min.css');
Admin::css('/css/admin/goods_data.css');
Admin::css('/js/layer/theme/default/layer.css');