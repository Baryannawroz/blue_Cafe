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
        <hr>
        <center>
            <h4><?php echo e($selected_dish->dish); ?> | Total Order : <?php echo e(count($selected_dish->orderDish)); ?> </h4>
            <p>From <b><?php echo e($start); ?></b> to <b> <?php echo e($end); ?></b></p>
        </center>
        <table id="datatable-responsive"
               class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>Order No</th>
                <th>Quantity</th>
                <th>Net Price</th>
                <th>Gross Price</th>
                <th>Date(d-m-y)</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $selected_dish->orderDish; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order_dish): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td> <?php echo e(str_pad($order_dish->order_id,4,0,STR_PAD_LEFT)); ?></td>
                    <td><?php echo e($order_dish->quantity); ?></td>
                    <td><?php echo e($order_dish->net_price); ?></td>
                    <td><?php echo e($order_dish->gross_price); ?></td>
                    <td><?php echo e($order_dish->created_at->format('d-M-Y')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
    <script src="<?php echo e(url('/dashboard/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')); ?>"></script>

    
    <script src="<?php echo e(url('/dashboard/plugins/datatables/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/plugins/datatables/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/plugins/datatables/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/plugins/datatables/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/plugins/datatables/pdfmake.min.js')); ?>"></script>
    <script>
        $(document).ready(function () {
            jQuery('#date-range').datepicker({
                toggleActive: true,
                format : "yyyy-mm-dd"
            });

            $("#datatable-responsive").DataTable({
                order: [0, 'desc'],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf','print'
                ],
            });
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\resources\views/user/admin/dish/stat/dish-stat-selected.blade.php ENDPATH**/ ?>