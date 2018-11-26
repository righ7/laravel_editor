<?php if(Admin::user()->visible($item['roles'])): ?>

    <?php if($item['id'] != 1): ?>
        <?php if(!isset($item['children'])): ?>
            <li>
                <?php if(url()->isValidUrl($item['uri'])): ?>
                    <a href="<?php echo e($item['uri']); ?>" target="_blank">
                <?php else: ?>
                     <a href="<?php echo e(admin_base_path($item['uri'])); ?>">
                <?php endif; ?>
                    
                    <span><?php echo e($item['title']); ?></span>
                </a>
            </li>
        <?php else: ?>
            <li class="treeview">
                <a href="#">
                    
                    <span><?php echo e($item['title']); ?></span>
                    
                </a>
                <ul class="treeview-menu-top">
                    <?php $__currentLoopData = $item['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('admin::partials.menu_top', $item, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </li>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>