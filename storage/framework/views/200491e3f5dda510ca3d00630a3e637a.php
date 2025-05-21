<?php $__env->startSection('title'); ?>
    All Order
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="<?php echo e(url('/new-order')); ?>" class="btn btn-default waves-effect">New Order <span class="m-l-5"><i
                            class="fa fa-plus"></i></span></a>
            </div>

            <h4 class="page-title">All Order</h4>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo e(url('/')); ?>">Home</a>
                </li>
                <li class="active">
                    Order
                </li>
                <li class="active">
                    All Order
                </li>
            </ol>
        </div>
    </div>
    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card-box">
            <h4><?php echo e($order[0]->created_at->format('M-Y')); ?></h4>
            <table class="datatable-responsive table table-striped table-bordered dt-responsive nowrap">
                <thead>
                <tr>
                    <th>Order No</th>
                    <th>Served By</th>
                    <th>Order Value</th>
                    <th>Kitchen</th>
                    <th>Waiter</th>
                    <th>Status</th>
                    <th width="120px">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $orderSum = $o->orderPrice->sum('gross_price');
                        ?>
                    <tr>
                        <td><?php echo e(str_pad($o->id,4,0,STR_PAD_LEFT)); ?></td>
                        <td><?php echo e($o->servedBy->name); ?></td>
                        <td><?php echo e(config('restaurant.currency.symbol')); ?> <?php echo e(number_format($orderSum,2)); ?> <?php echo e(config('restaurant.currency.currency')); ?></td>
                        <td><?php echo e($o->kitchen ? $o->kitchen->name : "Pending"); ?></td>
                        <td><?php echo e($o->servedBy->name); ?></td>
                        <td>
                            <?php if($o->status == 0): ?>
                                <p class="text-warning">Pending...</p>
                            <?php elseif($o->status == 1): ?>
                                Cooking...
                            <?php elseif($o->status == 2): ?>
                                <b class="text-custom"><i>Cooked !</i></b>
                            <?php elseif($o->status == 3): ?>
                                <b class="text-danger">Served !</b>
                            <?php else: ?>
                                Unknown Status
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($o->user_id ==0): ?>
                                <div class="btn-group">
                                    <a href="<?php echo e(url('/edit-order/'.$o->id)); ?>"
                                       class="btn btn-success waves-effect waves-light">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button type="button" onclick="printInvoice(<?php echo e($o->id); ?>)"
                                            href="<?php echo e(url('/print-order/'.$o->id)); ?>"
                                            class="btn btn-purple waves-effect waves-light">
                                        <i class="fa fa-print"></i>
                                    </button>
                                    <?php if($o->status == 0): ?>
                                        <a href="#" onclick="$(this).confirmDelete('/delete-order/<?php echo e($o->id); ?>')"
                                           class="btn btn-danger waves-effect waves-light">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <a href="<?php echo e(url('/print-order/'.$o->id)); ?>"
                                   class="btn btn-purple waves-effect waves-light">
                                    <i class="fa fa-print"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>

    <script src="<?php echo e(url('/dashboard/plugins/datatables/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/plugins/datatables/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/plugins/datatables/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/plugins/datatables/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/plugins/datatables/pdfmake.min.js')); ?>"></script>

    <script>
        $(document).ready(function () {
            $(".datatable-responsive").DataTable({
                order: [0, 'desc'],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ],
            });
        })

        function printInvoice(orderId) {
            if (!orderId) {
                alert("Cannot print receipt: Order ID is missing");
                return;
            }
            // Fetch the receipt HTML
            fetch(`/print-order/${orderId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'text/html'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(html => {
                    // Open a new window for printing
                    const printWindow = window.open('', '', 'width=800,height=600,toolbar=0,menubar=0,location=0');

                    // Insert the styles right after the <head> tag in the response
                    // Write the modified HTML to the new window
                    printWindow.document.write(html);
                    printWindow.document.close();

                    // Trigger print when content is loaded
                    printWindow.onload = function() {
                        printWindow.focus();
                        setTimeout(() => {
                            printWindow.print();

                            // Close the window after printing
                            printWindow.onafterprint = function() {
                                printWindow.close();
                            };

                            // Fallback close for browsers that don't support onafterprint
                            setTimeout(() => {
                                printWindow.close();
                            }, 1000);
                        }, 500);
                    };
                })
                .catch(error => {
                    console.error('Error printing receipt:', error);
                    alert("Error printing receipt. Please try again.");
                });
        }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\resources\views/user/admin/order/all-order.blade.php ENDPATH**/ ?>