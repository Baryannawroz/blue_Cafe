<?php $__env->startSection('title'); ?>
    Broadcastr Setup
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-center mb-5">

        <form action="<?php echo e(route('installer.save.pusher')); ?>" method="post" class="d-flex flex-wrap">
            <?php echo csrf_field(); ?>

            <div class="col-4">
                <h1>Broadcastr Setup</h1>

                <p id="pusherDetails">
                    Pusher allows you to add realtime, scalable features to your applications.
                    Setting up Pusher will enable broadcasting events over websockets in your Laravel application.
                </p>
                <p id="redisDetails" style="display: none">
                    Using Redis for broadcasting leverages your Redis server to publish events that can be received
                    by websocket connections. This requires a Redis server to be configured and running.
                </p>
                <p id="logDetails" style="display: none">
                    Log broadcasting will write all broadcast events to your application logs instead of sending
                    them to a real broadcasting service. You will find these at <code>storage/logs/laravel.log</code>.
                </p>
                <p id="nullDetails" style="display: none">
                    Null broadcasting disables broadcasting completely. No events will be broadcast when this driver is selected.
                </p>

                <div class="alert alert-primary" role="alert">
                    Please note that you can change these settings at any time by modifying your <code>.env</code> file
                    or updating <code>config/broadcasting.php</code>.
                </div>
            </div>

            <div class="px-5 col-8">

                <?php $__errorArgs = ['server_error'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Whoops!</h4>
                    <p><?php echo e($message); ?></p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <div class="mb-3">
                    <label class="form-label">Default Broadcaster</label>
                    <select class="form-select <?php $__errorArgs = ['broadcast_driver'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="broadcast_driver"
                            id="broadcasterType">
                        <option value="pusher" <?php echo e(old('broadcast_driver', 'pusher') == 'pusher' ? 'selected': ''); ?>>Pusher</option>
                        <option value="redis" <?php echo e(old('broadcast_driver') == 'redis' ? 'selected': ''); ?>>Redis</option>
                        <option value="log" <?php echo e(old('broadcast_driver') == 'log' ? 'selected': ''); ?>>Log</option>
                        <option value="null" <?php echo e(old('broadcast_driver') == 'null' ? 'selected': ''); ?>>Null</option>
                    </select>
                    <?php $__errorArgs = ['broadcast_driver'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div id="pusherSettings">
                    <div class="mb-3">
                        <label>Pusher App ID</label>
                        <input type="text" name="pusher_app_id" value="<?php echo e(old('pusher_app_id', $broadcastConfig['connections']['pusher']['app_id'] ?? '')); ?>"
                               placeholder="Pusher App ID"
                               class="form-control <?php $__errorArgs = ['pusher_app_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['pusher_app_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label>Pusher Key</label>
                        <input type="text" name="pusher_key" value="<?php echo e(old('pusher_key', $broadcastConfig['connections']['pusher']['key'] ?? '')); ?>"
                               placeholder="Pusher Key"
                               class="form-control <?php $__errorArgs = ['pusher_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['pusher_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label>Pusher Secret</label>
                        <input type="text" name="pusher_secret" value="<?php echo e(old('pusher_secret', $broadcastConfig['connections']['pusher']['secret'] ?? '')); ?>"
                               placeholder="Pusher Secret"
                               class="form-control <?php $__errorArgs = ['pusher_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['pusher_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label>Pusher Cluster</label>
                        <input type="text" name="pusher_cluster" value="<?php echo e(old('pusher_cluster', $broadcastConfig['connections']['pusher']['options']['cluster'] ?? 'ap2')); ?>"
                               placeholder="Pusher Cluster (e.g., ap2, eu, us, ap1)"
                               class="form-control <?php $__errorArgs = ['pusher_cluster'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['pusher_cluster'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="pusher_encrypted" name="pusher_encrypted"
                               value="1" <?php echo e(old('pusher_encrypted', $broadcastConfig['connections']['pusher']['options']['encrypted'] ?? true) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="pusher_encrypted">Encrypted</label>
                        <?php $__errorArgs = ['pusher_encrypted'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div id="redisSettings" style="display: none">
                    <div class="mb-3">
                        <label>Redis Connection</label>
                        <input type="text" name="redis_connection" value="<?php echo e(old('redis_connection', $broadcastConfig['connections']['redis']['connection'] ?? 'default')); ?>"
                               placeholder="Redis Connection Name"
                               class="form-control <?php $__errorArgs = ['redis_connection'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['redis_connection'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-text">
                            Uses the connection defined in your <code>config/database.php</code> file.
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between w-100">
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
        </form>
    </div>

    <script>
        const broadcasterType = document.querySelector('#broadcasterType');
        const pusherSettings = document.querySelector('#pusherSettings');
        const redisSettings = document.querySelector('#redisSettings');

        const pusherDetails = document.querySelector('#pusherDetails');
        const redisDetails = document.querySelector('#redisDetails');
        const logDetails = document.querySelector('#logDetails');
        const nullDetails = document.querySelector('#nullDetails');

        function setBroadcasterType() {
            const choice = broadcasterType.value;

            // Hide all details sections first
            pusherDetails.style.display = 'none';
            redisDetails.style.display = 'none';
            logDetails.style.display = 'none';
            nullDetails.style.display = 'none';

            // Hide all settings sections
            pusherSettings.style.display = 'none';
            redisSettings.style.display = 'none';

            // Show the appropriate sections based on choice
            if (choice === 'pusher') {
                pusherSettings.style.display = 'block';
                pusherDetails.style.display = 'block';
            } else if (choice === 'redis') {
                redisSettings.style.display = 'block';
                redisDetails.style.display = 'block';
            } else if (choice === 'log') {
                logDetails.style.display = 'block';
            } else if (choice === 'null') {
                nullDetails.style.display = 'block';
            }
        }

        broadcasterType.addEventListener('change', setBroadcasterType);
        window.addEventListener('load', setBroadcasterType);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('boilerplate::installer.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\vendor\binarycastle\boilerplate\src/../resources/views/installer/pusher.blade.php ENDPATH**/ ?>