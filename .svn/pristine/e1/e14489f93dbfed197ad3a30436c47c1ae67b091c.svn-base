<div class="box-header with-border <?php echo e($expand?'':'hide'); ?>" id="<?php echo e($filterID); ?>">
    <form action="<?php echo $action; ?>" class="form-horizontal" pjax-container method="get">

        <div class="row">
            <?php $__currentLoopData = $layout->columns(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-<?php echo e($column->width()); ?>">
                <div class="box-body">
                    <div class="fields-group">
                        <?php $__currentLoopData = $column->filters(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $filter->render(); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <div class="row">
                <div class="">
                    <div class="col-md-2"></div>
                    <div class="col-md-8" style="text-align: center">
                        <div class="btn-group pull-center">
                            <button class="btn btn-info submit btn-sm"><i
                                        class="fa fa-search"></i>&nbsp;&nbsp;<?php echo e(trans('搜索')); ?></button>
                        </div>
                        <div class="btn-group pull-center " style="margin-left: 10px;">
                            <a href="<?php echo $action; ?>" class="btn btn-default btn-sm"><i
                                        class="fa fa-undo"></i>&nbsp;&nbsp;<?php echo e(trans('admin.reset')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>