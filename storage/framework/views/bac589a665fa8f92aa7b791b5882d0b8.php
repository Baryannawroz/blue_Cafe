<?php $__env->startSection('title'); ?>
    All Units
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="<?php echo e(url('/add-unit')); ?>" class="btn btn-default waves-effect">Add Unit <span class="m-l-5"><i class="fa fa-plus"></i></span></a>
            </div>

            <h4 class="page-title">Unites</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('/')); ?>">Home</a>
                </li>
                <li class="active">
                    Settings
                </li>
                <li class="active">
                    Unit Settings
                </li>
            </ol>
        </div>
    </div>

    <div class="card-box">
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
            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($count++); ?> .</td>
                    <td>
                        <?php echo e($unit->unit); ?>

                    </td>
                    <td>
                        <?php if($unit->status == 1): ?>
                            Active
                            <?php else: ?>
                            InActive
                        <?php endif; ?>
                    </td>

                    <td>
                        <div class="btn-group-justified">
                            <a href="<?php echo e(url('/edit-unit/'.$unit->id)); ?>" class="btn btn-success waves-effect waves-light">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <a href="#" onclick="$(this).confirmDelete('/delete-unit/'+<?php echo e($unit->id); ?>)" class="btn btn-danger waves-effect waves-light">
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\resources\views/user/admin/unit-settings/all-unit.blade.php ENDPATH**/ ?>