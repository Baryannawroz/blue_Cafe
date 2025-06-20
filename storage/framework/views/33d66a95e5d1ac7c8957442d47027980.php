<?php $__env->startSection('title'); ?>
New Order
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="vueApp">
    <!-- Your Vue app content will be rendered here -->
</div>

<script>
    window.componentName = 'pos'; // Set the name of the component here dynamically
        window.table_id = <?php echo e($table_id); ?>; // Default to table ID 2 if $table_id isn't provided
        window.initialSelectedTableId = $table_id; // Explicitly set to table ID 2
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\resources\views/user/waiter/order/add-order.blade.php ENDPATH**/ ?>