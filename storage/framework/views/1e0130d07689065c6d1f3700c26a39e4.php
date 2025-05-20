<?php $__env->startSection('title'); ?>
    Requirements
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $server_requirement_satisfy = true;
    ?>

    <div class="d-flex justify-content-center mb-5">
        <div class="col-4">
            <h1>Server Requirements</h1>
            <p>These modules are essential for the proper functioning of our application. If any of them are missing or
                disabled, the installation may not proceed smoothly.</p>

            <?php $__errorArgs = ['server_requirement_satisfy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="p-4">
                <div class="alert alert-danger" role="alert">
                    <?php echo e($message); ?>

                </div>
            </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        </div>

        <div class="col-8">
            <ul class="list-group mb-2">
                <?php $__currentLoopData = $requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requirement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item">
                        <?php if(extension_loaded($requirement)): ?>
                            <i class="text-success bi bi-circle-fill"></i>
                        <?php else: ?>
                            <?php
                                $server_requirement_satisfy = false;
                            ?>
                            <i class="bi bi-circle text-danger"></i>
                        <?php endif; ?>
                        <?php echo e($requirement); ?>

                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>





    <form class="d-flex justify-content-between mb-2" method="post" action="<?php echo e(route('installer.save.requirements')); ?>">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="server_requirement_satisfy" value="<?php echo e($server_requirement_satisfy); ?>">
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

    </form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('boilerplate::installer.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\vendor\binarycastle\boilerplate\src/../resources/views/installer/requirements.blade.php ENDPATH**/ ?>