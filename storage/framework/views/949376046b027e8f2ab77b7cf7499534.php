<?php $__env->startSection('title'); ?>
    Permissions
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $server_requirement_satisfy = true;
    ?>

    <div class="d-flex justify-content-center mb-5">
        <div class="col-4">
            <h1>Directory Permission</h1>
            <p>Ensure that the following directories on your server have the correct permissions for our application.</p>
            <p>Correct directory permissions are crucial for the application to function properly. Improper permissions may lead to issues with file storage, uploads, and caching.</p>
        </div>

        <div class="col-8 px-5">
            <?php $__errorArgs = ['server_error'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Whops!</h4>
                <p><?php echo e($message); ?></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <ul class="list-group mb-3">
                <?php $__currentLoopData = $directoryPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!$permission['isWritable'] || !$permission['hasPermission']): ?>
                        <?php
                            $server_requirement_satisfy = false;
                        ?>
                    <?php endif; ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <div><?php echo e($permission['directory']); ?></div>
                        <div>
                            <i class="<?php echo e($permission['isWritable'] && $permission['hasPermission'] ? 'text-success' : 'text-danger'); ?> bi bi-circle-fill"></i> <?php echo e($permission['permission']); ?>

                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <p>For cloud setup please make sure the directory have the proper ownership</p>
        </div>
    </div>

    <form class="d-flex justify-content-between mb-2" method="post" action="<?php echo e(route('installer.save.permissions')); ?>">
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

<?php echo $__env->make('boilerplate::installer.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\vendor\binarycastle\boilerplate\src/../resources/views/installer/permissions.blade.php ENDPATH**/ ?>