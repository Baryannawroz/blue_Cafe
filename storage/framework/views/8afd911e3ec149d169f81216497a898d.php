<?php $__env->startSection('title'); ?>
    Profile
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card-box">
        <center>
            <div class="row">
                <img src="<?php echo e(auth()->user()->image ? auth()->user()->image : 'img_assets/default-thumbnail.jpg'); ?>"
                     class="img-responsive img-circle" width="250px" alt="">
                <h3><?php echo e(auth()->user()->name); ?></h3>
                <p>Role : <b> <?php if(auth()->user()->role ==1): ?> Admin <?php elseif(auth()->user()->role ==2): ?> Resturant
                    Manager <?php elseif(auth()->user()->role ==3): ?> Kitchen <?php else: ?> Waiter <?php endif; ?></b>
                    <br>
                    Registered Science : <?php echo e(auth()->user()->created_at->format('d-M-Y')); ?>

                    <br>
                    <?php if(auth()->user()->role != 1): ?>
                        Phone : <?php echo e(auth()->user()->employee->phone); ?> <br>
                        Address : <?php echo e(auth()->user()->employee->address); ?>

                    <?php endif; ?>
                </p>
            </div>
        </center>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\resources\views/user/profile/profile.blade.php ENDPATH**/ ?>