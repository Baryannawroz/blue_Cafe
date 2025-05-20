<?php $__env->startSection('title'); ?>
    Dish Price - <?php echo e($dish->dish); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="<?php echo e(url('/dashboard/plugins/magnific-popup/css/magnific-popup.css')); ?>">
    
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
            <a href="<?php echo e(url('/edit-dish/'.$dish->id)); ?>"  aria-expanded="false">
                <span class="visible-xs"><i class="fa fa-cutlery"></i></span>
                <span class="hidden-xs"><?php echo e($dish->dish); ?></span>
            </a>
        </li>
        <li class="">
            <a href="<?php echo e(url('/dish-price/'.$dish->id)); ?>"  aria-expanded="false">
                <span class="visible-xs"><i class="fa fa-usd"></i></span>
                <span class="hidden-xs">Dish Price</span>
            </a>
        </li>
        <li class="active">
            <a href="<?php echo e(url('/dish-image/'.$dish->id)); ?>" data-toggle="tab"  aria-expanded="true">
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
            <form class="form-inline" enctype="multipart/form-data" method="post" action="<?php echo e(url('/save-dish-image')); ?>" data-parsley-validate novalidate>
                <?php echo e(csrf_field()); ?>

                <input type="hidden" value="<?php echo e($dish->id); ?>" id="dishId" name="dish_id">
                <div class="form-group m-r-10">
                    <div id="image-preview">
                        <label for="image-upload" id="image-label">Choose Photo</label>
                        <input type="file" required name="image" id="image-upload"/>
                    </div>
                </div>
                <div class="form-group m-r-10">
                    <label>Title </label>
                    <div class="input-group">
                        <input type="text" required  name="title" class="form-control" placeholder="Image Title">
                    </div>

                </div>
                <button type="submit"  class="btn btn-default waves-effect waves-light btn-md">
                    Save
                </button>

            </form>
            <hr>
            <div class="row port">
                <div class="portfolioContainer">
                    <?php $__currentLoopData = $dish->dishImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-sm-6 col-lg-3 col-md-4 webdesign illustrator">
                            <div class="gal-detail thumb">
                                <a href="<?php echo e(url($image->image)); ?>" class="image-popup" title="<?php echo e($image->title); ?>">
                                    <img src="<?php echo e(url($image->image)); ?>" class="thumb-img" alt="work-thumbnail">
                                </a>
                                <h4><?php echo e($image->title); ?> <a href="#" onclick="$(this).confirmDelete('/delete-dish-image/<?php echo e($image->id); ?>')" class="pull-right text-danger"><i class="fa fa-trash-o"></i> </a> </h4>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>



        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
    <script type="text/javascript" src="<?php echo e(url('/dashboard/plugins/isotope/js/isotope.pkgd.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(url('/dashboard/plugins/magnific-popup/js/jquery.magnific-popup.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $('.image-popup').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1]
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\resources\views/user/admin/dish/dish-image/add-dish-image.blade.php ENDPATH**/ ?>