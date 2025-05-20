<?php $__env->startSection('title'); ?>
    All Dish Types
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card-box">
        <div class="pull-right"><a href="<?php echo e(url('/add-dish-type')); ?>" class="btn btn-success">Add Dish Type</a></div>
        <h3 class="m-t-0 "><b>Dish Types</b></h3>
        <p>sdjlk adfasdf</p>
        <table id="datatable-responsive"
               class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Unit</th>
                <th>Info</th>
                <th width="80px">Action</th>
            </tr>
            </thead>
            <?php $count = 1; ?>
            <tbody>
            <?php $__currentLoopData = $dish_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dish): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($count++); ?> .</td>
                    <td>
                        <?php echo e($dish->name); ?>

                    </td>
                    <td>
                        <?php if($dish->status == 1): ?>
                            Active
                        <?php else: ?>
                            InActive
                        <?php endif; ?>
                    </td>

                    <td>
                        <div class="btn-group-justified">
                            <a href="<?php echo e(url('/edit-dish-type/'.$dish->id)); ?>"
                               class="btn btn-success waves-effect waves-light">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <a href="#" class="btn btn-danger waves-effect waves-light">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
    <script>
        $(document).ready(function () {
            $("#datatable-responsive").DataTable();
        })
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\resources\views/user/admin/dish-category/all-dish-type.blade.php ENDPATH**/ ?>