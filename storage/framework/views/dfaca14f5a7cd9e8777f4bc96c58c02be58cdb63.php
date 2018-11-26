<style>
    .items{
        width: 33%;
        height: 70%;
        float: left;
        display: inline-block;
        margin-top: 30px;
        padding: 10px;
    }
    .data_product-img{
        padding: 30px;
        text-align: center;
    }
    .products-list{
        height: 550px;
        overflow:hidden;
    }
    .data_product-info{
        margin-top: 30px;
    }
    .link:hover
    {
        background-color:white;
    }
</style>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <a id="error_href" href="http://note.youdao.com/noteshare?id=729f278a41466d2b040571c5f5d9c7dd" target="_blank" style="color: red;">如遇到页面错乱，请点此查看解决方案!</a>
        </div><!--box-tools pull-right-->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <ul class="products-list product-list-in-box">

            <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="items">
                <div class="data_product-img">
                    <a href="<?php echo e($data['link']); ?>" class="link">
                        <img src="<?php echo e($data['img_data']); ?>"/>
                    </a>

                    <div class="data_product-info">
                        <a href="<?php echo e($data['link']); ?>" class="product-title" style="font-size: 18px">
                            <?php echo e($data['name']); ?>

                        </a>
                    </div>
                </div>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- /.item -->
        </ul>
    </div>
</div>