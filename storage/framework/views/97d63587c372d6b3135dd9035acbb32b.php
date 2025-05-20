<?php $__env->startSection('title'); ?>
    Finish
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row justify-content-center">
        <div class="col-md-7">
            <h1> 🎉 Installation Complete! Thank You! 🚀</h1> <br>
            <b>BinaryCastle</b> appreciates your trust in our products. Need assistance? We're here for you! <br> <br>

            ✨ <b>BinaryCastle</b> - Your Partner in Innovation <br> <br>

            Your success is our mission! If you loved our setup, consider leaving us a 5-star rating. <br> <br>

            ⭐⭐⭐⭐⭐ Rate Us Now! <br> <br>

            Your feedback matters. Thanks for choosing <b>BinaryCastle</b>! <br> <br>

            Happy exploring!

            <form class="py-5" action="<?php echo e(config('boilerplate.installation_finish_url')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <button class="btn btn-lg btn-primary">Start Using App</button>
            </form>
        </div>
    </div>





<?php $__env->stopSection(); ?>

<?php echo $__env->make('boilerplate::installer.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\vendor\binarycastle\boilerplate\src/../resources/views/installer/finish.blade.php ENDPATH**/ ?>