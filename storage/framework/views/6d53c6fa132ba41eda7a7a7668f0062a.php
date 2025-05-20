<?php $__env->startSection('title'); ?>
    All Employee
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="<?php echo e(url('/add-employee')); ?>" class="btn btn-default waves-effect">Add Employee <span class="m-l-5"></span></a>
            </div>

            <h4 class="page-title">All Employee </h4>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('/')); ?>">Home</a>
                </li>
                <li class="active">
                    Employee
                </li>
                <li class="active">
                    All Employee
                </li>
            </ol>
        </div>
    </div>
    <div class="card-box table-responsive">
        <table id="datatable-responsive"
               class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Info</th>
                <th>Role</th>
                <th width="20px">Action</th>
            </tr>
            </thead>
            <?php $count = 1; ?>
            <tbody>
            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($count++); ?> .</td>
                    <td>
                        <img src="<?php echo e($employee->user->image != '' | null ? $employee->user->image : url('/img_assets/avater.png')); ?>" alt="" class="img-responsive" width="100px">
                    </td>
                    <td>
                        <dl class="dl-horizontal m-b-0">
                            <dt>
                                Email :
                            </dt>
                            <dd>
                                <?php echo e($employee->email); ?>

                            </dd>
                            <dt>
                                Phone :
                            </dt>
                            <dd>
                                <?php echo e($employee->phone); ?>

                            </dd>
                            <dt>
                                Address :
                            </dt>
                            <dd>
                                <?php echo e($employee->address); ?>

                            </dd>
                            <dt>
                                Created at :
                            </dt>
                            <dd>
                                <?php echo e($employee->created_at->diffForHumans()); ?>

                            </dd>



                        </dl>

                    </td>
                    <td>
                        <dl class="m-b-0">
                            <dt>
                                Role
                            </dt>
                            <dd>
                                <?php if($employee->user->role == 2): ?>
                                    <span class="label label-primary">Manager</span>
                                <?php elseif($employee->user->role == 3): ?>
                                    <span class="label label-purple">Kitchen</span>
                                <?php elseif($employee->user->role == 4): ?>
                                    <span class="label label-pink">Waiter</span>
                                <?php endif; ?>
                            </dd>
                            <dt>
                                Status
                            </dt>
                            <dd>
                                <?php if($employee->user->active == 1): ?>
                                    <span class="label label-primary">Active</span>
                                <?php else: ?>
                                    <span class="label label-danger">InActive</span>
                                <?php endif; ?>
                            </dd>

                        </dl>

                    </td>
                    <td>
                        <div class="btn-group-vertical">
                            <a href="<?php echo e(url('/edit-employee/'.$employee->id)); ?>" class="btn btn-success waves-effect waves-light">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <a href="#" onclick="$(this).confirmDelete('/delete-employee/<?php echo e($employee->id); ?>')" class="btn btn-danger waves-effect waves-light">
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\resources\views/user/admin/employee/all-employees.blade.php ENDPATH**/ ?>