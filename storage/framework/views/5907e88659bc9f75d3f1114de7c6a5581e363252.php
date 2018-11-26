<div class="btn-group" data-toggle="buttons">
    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <label class="btn btn-default btn-sm <?php echo e(\Request::get('article_status', '2') == $option ? 'active' : ''); ?>">
            <input type="radio" class="user-article_status" value="<?php echo e($option); ?>"><?php echo e($label); ?>

        </label>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div style="display: inline; float: right;" class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown">
        我要发文
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
        <li role="presentation">
            <?php if($type == 1): ?>
                <a role="menuitem" tabindex="-1" href="<?php echo e(route('article.add_pics')); ?>">发布图集</a>
            <?php else: ?>
                <a role="menuitem" tabindex="-1" href="#">发布图集</a>
            <?php endif; ?>
        </li>
        <li role="presentation">
            <?php if($type == 1): ?>
                <a role="menuitem" tabindex="-1" href="<?php echo e(route('article.create_ablum')); ?>">发布专辑</a>
            <?php else: ?>
                <a role="menuitem" tabindex="-1" href="<?php echo e(route('toutiao.create_ablum')); ?>">发布专辑</a>
            <?php endif; ?>
        </li>
    </ul>
</div>