<div class="input-group input-group-sm">
    <?php if($group): ?>
    <div class="input-group-btn">
        <input type="hidden" name="<?php echo e($id); ?>_group" class="<?php echo e($group_name); ?>-operation" value="0"/>
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="min-width: 32px;">
            <span class="<?php echo e($group_name); ?>-label"><?php echo e($default['label']); ?></span>
            &nbsp;&nbsp;
            <span class="fa fa-caret-down"></span>
        </button>
        <ul class="dropdown-menu <?php echo e($group_name); ?>">
            <?php $__currentLoopData = $group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="#" data-index="<?php echo e($index); ?>"> <?php echo e($item['label']); ?> </a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>
        <div class="input-group-addon">
            <i class="fa fa-<?php echo e($icon); ?>"></i>
        </div>

    <input type="<?php echo e($type); ?>" class="form-control <?php echo e($id); ?>" placeholder="<?php echo e($placeholder); ?>" name="<?php echo e($name); ?>" value="<?php echo e(request($name, $value)); ?>">
</div>