<?php $__env->startSection('title'); ?>
    All Dish
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php $__currentLoopData = $dishes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dish): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-sm-6 col-lg-4">
                <div class="card-box">
                    <div class="contact-card">
                        <a class="pull-left" href="#">
                            <img class="" src="<?php echo e($dish->thumbnail); ?>" alt="">
                        </a>
                        <div class="member-info">
                            <h4 class="m-t-0 m-b-5 header-title"><b><?php echo e($dish->dish); ?></b></h4>
                            <p class="text-muted"><?php echo e($dish->status == 1 ? 'Active' : 'In-Active'); ?></p>
                            <h4 class=""><i class="md md-business m-r-10"></i>Order :<?php echo e(count($dish->orderDish)); ?></h4>
                            <div class="contact-action">
                                <a href="<?php echo e(url('/edit-dish/'.$dish->id)); ?>" class="btn btn-success btn-sm"><i
                                            class="md md-mode-edit"></i></a>
                                <a href="<?php echo e(url('/view-dish/'.$dish->id)); ?>" class="btn btn-info btn-sm"><i
                                            class="md md-announcement"></i></a>
                                <a href="#" onclick="$(this).confirmDelete('/delete-dish/'+<?php echo e($dish->id); ?>)"
                                   class="btn btn-danger btn-sm"><i class="md md-close"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
    <script>
        $(document).ready(function () {

        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\resources\views/user/admin/dish/all-dish.blade.php ENDPATH**/ ?>