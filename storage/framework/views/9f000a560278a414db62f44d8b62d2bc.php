<?php $__env->startSection('title'); ?>
    Dish Report
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="<?php echo e(url('/dashboard/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')); ?>">
    <div class="card-box">
        <form class="form-horizontal" role="form" method="post" action="<?php echo e(url('/dish-stat-post')); ?>" id="formMe" data-parsley-validate novalidate>
            <?php echo e(csrf_field()); ?>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Dish</label>
                <div class="col-sm-7">
                    <select name="kitchen" id="" class="form-control">
                        <option value="0">All</option>
                        <?php $__currentLoopData = $dishes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dish): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dish->id); ?>"><?php echo e($dish->dish); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="hori-pass1" class="col-sm-2 control-label">Date Range</label>
                <div class="col-sm-7">
                    <div class="input-daterange input-group" id="date-range">
                        <input type="text" class="form-control" name="start" />
                        <span class="input-group-addon bg-custom b-0 text-white">to</span>
                        <input type="text" class="form-control" name="end" />
                    </div>
                </div>
            </div>
            <div class="form-group  m-b-0">
                <button class="col-md-offset-2 btn btn-primary waves-effect waves-light" type="submit">
                    Submit
                </button>
                <button type="reset" class="btn btn-default waves-effect waves-light m-l-5">
                    Cancel
                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
    <script src="<?php echo e(url('/dashboard/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')); ?>"></script>
    <script>
        $(document).ready(function () {
            jQuery('#date-range').datepicker({
                toggleActive: true,
                format : "yyyy-mm-dd"
            });
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\resources\views/user/admin/dish/stat/dish-stat.blade.php ENDPATH**/ ?>