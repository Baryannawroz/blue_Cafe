<?php $__env->startSection('title'); ?>
     Dish Price - <?php echo e($dish->dish); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="<?php echo e(url('/all-dish')); ?>" class="btn btn-default waves-effect">All Dish <span class="m-l-5"></span></a>
            </div>

            <h4 class="page-title">Edit Dish </h4>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('/')); ?>">Home</a>
                </li>
                <li class="active">
                    Dish
                </li>
                <li class="active">
                    Edit Dish
                </li>
            </ol>
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li class="">
            <a href="<?php echo e(url('/edit-dish/'.$dish->id)); ?>"  aria-expanded="true">
                <span class="visible-xs"><i class="fa fa-cutlery"></i></span>
                <span class="hidden-xs"><?php echo e($dish->dish); ?></span>
            </a>
        </li>
        <li class="active">
            <a href="<?php echo e(url('/dish-price/'.$dish->id)); ?>" data-toggle="tab" aria-expanded="false">
                <span class="visible-xs"><i class="">IQD</i></span>
                <span class="hidden-xs">Dish Price</span>
            </a>
        </li>
        <li class="">
            <a href="<?php echo e(url('/dish-image/'.$dish->id)); ?>"  aria-expanded="false">
                <span class="visible-xs"><i class="fa fa-photo"></i></span>
                <span class="hidden-xs">Dish Images</span>
            </a>
        </li>
        <li class="">
            <a href="<?php echo e(url('/dish-recipe/'.$dish->id)); ?>" aria-expanded="false">
                <span class="visible-xs"><i class="fa fa-photo"></i></span>
                <span class="hidden-xs">Recipe</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="home">
            <form class="form-inline" id="dishPriceForm" method="post" action="<?php echo e(url('/save-dish-price')); ?>" data-parsley-validate novalidate>
                <?php echo e(csrf_field()); ?>

                <input type="hidden" value="<?php echo e($dish->id); ?>" id="dishId" name="dish_id">
                <div class="form-group m-r-10">
                    <label>Dish Type </label>
                    <input type="text" name="dish_type" required class="form-control"  placeholder="1/3 , 4/5">
                </div>
                <div class="form-group m-r-10">
                    <label>Price </label>
                    <div class="input-group m-t-8">
                        <span class="input-group-addon"><?php echo e(config('restaurant.currency.symbol')); ?></span>
                        <input type="number" required  name="price" class="form-control" placeholder="..">
                    </div>

                </div>
                <button type="submit"  class="btn btn-default waves-effect waves-light btn-md">
                    Save
                </button>

            </form>
            <hr>
            <ul class="list-unstyled transaction-list">
                <?php $__empty_1 = true; $__currentLoopData = $dish->dishPrices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dish_price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <li>
                    <i class="ti-download text-success"></i>
                    <span class="text">Dish One - <?php echo e($dish_price->dish_type); ?></span>
                    <span class="text-success tran-price"><?php echo e(config('restaurant.currency.symbol')); ?> <?php echo e(number_format($dish_price->price,2)); ?> <?php echo e(config('restaurant.currency.currency')); ?></span>
                    <span class="pull-right">|
                        <a href="<?php echo e(url('/edit-dish-price/'.$dish_price->id)); ?>" class="btn btn-link"><i class="fa fa-pencil"></i></a>
                        <a href="#" onclick="$(this).confirmDelete('/delete-dish-type/'+<?php echo e($dish_price->id); ?>)" class="btn btn-link text-danger"><i class="fa fa-trash-o"></i></a>
                    </span>
                    <span class="pull-right text-muted"><?php echo e($dish_price->created_at->format('d-M-Y')); ?> </span>
                    <span class="clearfix"></span>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                   <p>Noting Found</p>
                <?php endif; ?>
            </ul>


        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\resources\views/user/admin/dish/dish-price/add-dish-price.blade.php ENDPATH**/ ?>