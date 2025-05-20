<?php $__env->startSection('title'); ?>
    Queue Setup
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-center mb-5">
        <form action="<?php echo e(route('installer.save.queue')); ?>" method="post" class="d-flex flex-wrap">
            <?php echo csrf_field(); ?>

            <div class="col-4">
                <h1>Queue Setup</h1>

                <div>
                    <p>It's important to setup how you handle the queue as queues are used to handle
                        background tasks such as mail sending. We support multiple queue drivers:</p>

                    <div id="syncDetails">
                        <p><b>Sync:</b> A synchronous driver which means no task will be handled in the background. Instead, the task will
                            execute in the same request.</p>
                    </div>

                    <div id="databaseDetails" style="display: none">
                        <p><b>Database:</b> It will store tasks in the database and execute them one by one. To execute tasks that are
                            stored in the DB, you need to keep running this command on your server:
                            <br> <code>php artisan queue:work</code> <br>

                            You can checkout this doc to know how to setup supervisor to keep running this command in the background:
                            <a href="https://laravel.com/docs/11.x/queues#supervisor-configuration" target="_blank">Laravel Doc</a>
                        </p>
                    </div>

                    <div id="redisDetails" style="display: none">
                        <p><b>Redis:</b> Uses Redis to store queue jobs. This requires Redis to be installed and configured on your server.
                            This is a good option for high-throughput queue processing.
                            <br> <code>php artisan queue:work redis</code> <br>
                        </p>
                    </div>

                    <div id="sqsDetails" style="display: none">
                        <p><b>SQS:</b> Uses Amazon SQS (Simple Queue Service) to manage your queue jobs. This requires AWS credentials
                            and proper configuration.
                            <br> <code>php artisan queue:work sqs</code> <br>
                        </p>
                    </div>

                    <div id="beanstalkdDetails" style="display: none">
                        <p><b>Beanstalkd:</b> A simple, fast work queue that requires the Beanstalkd service to be installed on your server.
                            <br> <code>php artisan queue:work beanstalkd</code> <br>
                        </p>
                    </div>
                </div>

                <div class="alert alert-primary" role="alert">
                    Please note that you can change these settings at any time by modifying your <code>.env</code> file
                    or updating <code>config/queue.php</code>.
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
                    <label class="form-label">Queue Driver</label>
                    <select class="form-select <?php $__errorArgs = ['connection'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="connection" id="queueDriver">
                        <option value="sync" <?php echo e(old('connection', 'sync') == 'sync' ? 'selected': ''); ?>>Sync</option>
                        <option value="database" <?php echo e(old('connection') == 'database' ? 'selected': ''); ?>>Database</option>
                        <option value="redis" <?php echo e(old('connection') == 'redis' ? 'selected': ''); ?>>Redis</option>
                        <option value="sqs" <?php echo e(old('connection') == 'sqs' ? 'selected': ''); ?>>Amazon SQS</option>
                        <option value="beanstalkd" <?php echo e(old('connection') == 'beanstalkd' ? 'selected': ''); ?>>Beanstalkd</option>
                    </select>
                    <?php $__errorArgs = ['connection'];
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

                <!-- Redis Configuration -->
                <div id="redisConfig" style="display: none">
                    <div class="mb-3">
                        <label>Redis Queue</label>
                        <input type="text" name="redis_queue" value="<?php echo e(old('redis_queue', 'default')); ?>"
                               placeholder="Queue Name"
                               class="form-control <?php $__errorArgs = ['redis_queue'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['redis_queue'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-text">The default queue that jobs will be sent to.</div>
                    </div>
                </div>

                <!-- SQS Configuration -->
                <div id="sqsConfig" style="display: none">
                    <div class="mb-3">
                        <label>AWS Access Key ID</label>
                        <input type="text" name="aws_access_key_id" value="<?php echo e(old('aws_access_key_id', env('AWS_ACCESS_KEY_ID', ''))); ?>"
                               placeholder="AWS Access Key ID"
                               class="form-control <?php $__errorArgs = ['aws_access_key_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['aws_access_key_id'];
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
                        <label>AWS Secret Access Key</label>
                        <input type="password" name="aws_secret_access_key" value="<?php echo e(old('aws_secret_access_key', env('AWS_SECRET_ACCESS_KEY', ''))); ?>"
                               placeholder="AWS Secret Access Key"
                               class="form-control <?php $__errorArgs = ['aws_secret_access_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['aws_secret_access_key'];
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
                        <label>AWS Region</label>
                        <input type="text" name="aws_default_region" value="<?php echo e(old('aws_default_region', env('AWS_DEFAULT_REGION', 'us-east-1'))); ?>"
                               placeholder="AWS Region"
                               class="form-control <?php $__errorArgs = ['aws_default_region'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['aws_default_region'];
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
                        <label>SQS Queue</label>
                        <input type="text" name="sqs_queue" value="<?php echo e(old('sqs_queue', 'default')); ?>"
                               placeholder="SQS Queue Name"
                               class="form-control <?php $__errorArgs = ['sqs_queue'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['sqs_queue'];
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

                <!-- Beanstalkd Configuration -->
                <div id="beanstalkdConfig" style="display: none">
                    <div class="mb-3">
                        <label>Beanstalkd Host</label>
                        <input type="text" name="beanstalkd_host" value="<?php echo e(old('beanstalkd_host', 'localhost')); ?>"
                               placeholder="Beanstalkd Host"
                               class="form-control <?php $__errorArgs = ['beanstalkd_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['beanstalkd_host'];
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
                        <label>Queue</label>
                        <input type="text" name="beanstalkd_queue" value="<?php echo e(old('beanstalkd_queue', 'default')); ?>"
                               placeholder="Queue Name"
                               class="form-control <?php $__errorArgs = ['beanstalkd_queue'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['beanstalkd_queue'];
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

                <!-- Failed Jobs Configuration -->
                <div class="mb-3 border-top pt-3 mt-4">
                    <h5>Failed Jobs</h5>
                    <label class="form-label">Failed Jobs Driver</label>
                    <select class="form-select <?php $__errorArgs = ['failed_driver'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="failed_driver">
                        <option value="database-uuids" <?php echo e(old('failed_driver', 'database-uuids') == 'database-uuids' ? 'selected': ''); ?>>Database UUIDs</option>
                        <option value="database" <?php echo e(old('failed_driver') == 'database' ? 'selected': ''); ?>>Database</option>
                        <option value="null" <?php echo e(old('failed_driver') == 'null' ? 'selected': ''); ?>>Null (No logging)</option>
                    </select>
                    <?php $__errorArgs = ['failed_driver'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-text">This determines how failed jobs are stored for later inspection.</div>
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
        const queueDriver = document.querySelector('#queueDriver');

        // Configuration sections
        const redisConfig = document.querySelector('#redisConfig');
        const sqsConfig = document.querySelector('#sqsConfig');
        const beanstalkdConfig = document.querySelector('#beanstalkdConfig');

        // Detail sections
        const syncDetails = document.querySelector('#syncDetails');
        const databaseDetails = document.querySelector('#databaseDetails');
        const redisDetails = document.querySelector('#redisDetails');
        const sqsDetails = document.querySelector('#sqsDetails');
        const beanstalkdDetails = document.querySelector('#beanstalkdDetails');

        function setQueueDriver() {
            const choice = queueDriver.value;

            // Hide all config sections first
            redisConfig.style.display = 'none';
            sqsConfig.style.display = 'none';
            beanstalkdConfig.style.display = 'none';

            // Hide all detail sections first
            syncDetails.style.display = 'none';
            databaseDetails.style.display = 'none';
            redisDetails.style.display = 'none';
            sqsDetails.style.display = 'none';
            beanstalkdDetails.style.display = 'none';

            // Show the appropriate sections based on choice
            if (choice === 'sync') {
                syncDetails.style.display = 'block';
            } else if (choice === 'database') {
                databaseDetails.style.display = 'block';
            } else if (choice === 'redis') {
                redisConfig.style.display = 'block';
                redisDetails.style.display = 'block';
            } else if (choice === 'sqs') {
                sqsConfig.style.display = 'block';
                sqsDetails.style.display = 'block';
            } else if (choice === 'beanstalkd') {
                beanstalkdConfig.style.display = 'block';
                beanstalkdDetails.style.display = 'block';
            }
        }

        queueDriver.addEventListener('change', setQueueDriver);
        window.addEventListener('load', setQueueDriver);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('boilerplate::installer.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\vendor\binarycastle\boilerplate\src/../resources/views/installer/queue.blade.php ENDPATH**/ ?>