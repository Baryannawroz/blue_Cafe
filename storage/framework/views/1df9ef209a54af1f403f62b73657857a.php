<?php $__env->startSection('title'); ?>
    End User License Agreement (EULA)
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <?php
        $timezones = DateTimeZone::listIdentifiers();
        $selectedTimeZone = config('app.timezone');
    ?>

    <form method="post" action="<?php echo e(route('installer.save.intro')); ?>">
        <div class="mb-3">
            <label for="">Timezone</label>
            <select class="form-select timezoneSelect" name="timezone">
                <option value="">Null</option>
                <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php if($timezone == $selectedTimeZone): ?> selected
                            <?php endif; ?> value="<?php echo e($timezone); ?>"><?php echo e($timezone); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="mb-2 border p-2 rounded-2" style="max-height: 50vh; overflow-y: scroll;">
            <?php echo $__env->make('boilerplate::installer.legal.licence-agreement', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <div class="d-flex justify-content-between">
            <?php echo csrf_field(); ?>
            <div class="form-check">
                <input class="form-check-input" required name="agreement" type="checkbox" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    I Agree & Accept
                </label>
                <?php $__errorArgs = ['agreement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>


            <div>
                <?php if (isset($component)) { $__componentOriginalbf86ce3f4580228327b1ba5c7ac8518e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbf86ce3f4580228327b1ba5c7ac8518e = $attributes; } ?>
<?php $component = BinaryCastle\Boilerplate\View\Components\InstallerNavigationButtons::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('installer-navigation-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BinaryCastle\Boilerplate\View\Components\InstallerNavigationButtons::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbf86ce3f4580228327b1ba5c7ac8518e)): ?>
<?php $attributes = $__attributesOriginalbf86ce3f4580228327b1ba5c7ac8518e; ?>
<?php unset($__attributesOriginalbf86ce3f4580228327b1ba5c7ac8518e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbf86ce3f4580228327b1ba5c7ac8518e)): ?>
<?php $component = $__componentOriginalbf86ce3f4580228327b1ba5c7ac8518e; ?>
<?php unset($__componentOriginalbf86ce3f4580228327b1ba5c7ac8518e); ?>
<?php endif; ?>
            </div>
        </div>


    </form>

    <script>
        $(document).ready(function() {
            $('.timezoneSelect').select2();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('boilerplate::installer.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\vendor\binarycastle\boilerplate\src/../resources/views/installer/intro.blade.php ENDPATH**/ ?>