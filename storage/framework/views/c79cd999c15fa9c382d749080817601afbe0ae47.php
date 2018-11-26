<div class="box">

    <div class="box-header">

        <div class="btn-group">
            <a class="btn btn-primary btn-sm <?php echo e($id); ?>-tree-tools" data-action="expand" title="<?php echo e(trans('admin.expand')); ?>">
                <i class="fa fa-plus-square-o"></i><span class="hidden-xs">&nbsp;<?php echo e(trans('admin.expand')); ?></span>
            </a>
            <a class="btn btn-primary btn-sm <?php echo e($id); ?>-tree-tools" data-action="collapse" title="<?php echo e(trans('admin.collapse')); ?>">
                <i class="fa fa-minus-square-o"></i><span class="hidden-xs">&nbsp;<?php echo e(trans('admin.collapse')); ?></span>
            </a>
        </div>

        <?php if($useSave): ?>
        <div class="btn-group">
            <a class="btn btn-info btn-sm <?php echo e($id); ?>-save" title="<?php echo e(trans('admin.save')); ?>"><i class="fa fa-save"></i><span class="hidden-xs">&nbsp;<?php echo e(trans('admin.save')); ?></span></a>
        </div>
        <?php endif; ?>

        <?php if($useRefresh): ?>
        <div class="btn-group">
            <a class="btn btn-warning btn-sm <?php echo e($id); ?>-refresh" title="<?php echo e(trans('admin.refresh')); ?>"><i class="fa fa-refresh"></i><span class="hidden-xs">&nbsp;<?php echo e(trans('admin.refresh')); ?></span></a>
        </div>
        <?php endif; ?>

        <div class="btn-group">
            <?php echo $tools; ?>

        </div>

        <?php if($useCreate): ?>
        <div class="btn-group pull-right">
            <a class="btn btn-success btn-sm" href="<?php echo e($path); ?>/create"><i class="fa fa-save"></i><span class="hidden-xs">&nbsp;<?php echo e(trans('admin.new')); ?></span></a>
        </div>
        <?php endif; ?>

    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <div class="dd" id="<?php echo e($id); ?>">
            <ol class="dd-list">
                <?php echo $__env->renderEach($branchView, $items, 'branch'); ?>
            </ol>
        </div>
    </div>
    <!-- /.box-body -->
</div>
