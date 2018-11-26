<div class="btn-group" style="margin-right: 10px" data-toggle="buttons">
    <label class="btn btn-sm btn-dropbox <?php echo e($btn_class); ?> <?php echo e($expand ? 'active' : ''); ?>" title="<?php echo e(trans('admin.filter')); ?>">
        <input type="checkbox"><i class="fa fa-filter"></i><span class="hidden-xs">&nbsp;&nbsp;<?php echo e(trans('admin.filter')); ?></span>
    </label>

    <?php if($scopes->isNotEmpty()): ?>
    <button type="button" class="btn btn-sm btn-dropbox dropdown-toggle" data-toggle="dropdown">

        <span><?php echo e($current_label); ?></span>
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <?php $__currentLoopData = $scopes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scope): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $scope->render(); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <li role="separator" class="divider"></li>
        <li><a href="<?php echo e($url_no_scopes); ?>"><?php echo e(trans('admin.cancel')); ?></a></li>
    </ul>
    <?php endif; ?>
</div>