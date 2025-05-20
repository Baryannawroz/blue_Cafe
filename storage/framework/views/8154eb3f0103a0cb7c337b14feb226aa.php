<?php $__env->startSection('title'); ?>
    Email Setup
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-center mb-5">

        <form action="<?php echo e(route('installer.save.mail')); ?>" method="post" class="d-flex flex-wrap">
            <?php echo csrf_field(); ?>

            <div class="col-4">
                <h1>Email Setup</h1>

                <p id="logMailerDetails">
                    Having a log mail will not sent out any email to anymore, instate it will store
                    the log inside the system logs, which you will find at <code>storage/logs/laravel.log</code>.
                </p>
                <p id="smtpMailerDetails" style="display: none">
                    Having SMTP mail setup system can send out email to the user. During the setup, system will try to
                    send out an email to ensure that your given SMTP configuration is correct.
                </p>

                <div class="alert alert-primary" role="alert">
                    Please note that you can change it at any time by going to <code>config/mail.php</code> file.
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
                    <label class="form-label">Mailer</label>
                    <select class="form-select <?php $__errorArgs = ['transport'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="transport"
                            id="mailerType">
                        <option value="log" <?php echo e(old('transport') == 'log' ? 'selected': ''); ?>>Log</option>
                        <option value="smtp" <?php echo e(old('transport') == 'smtp' ? 'selected': ''); ?>>Simple Mail Transfer
                            Protocol (SMTP)
                        </option>
                    </select>
                    <?php $__errorArgs = ['transport'];
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

                <div id="smtpMailer" style="display: none">
                    <div class=" mb-3">
                        <label>Host</label>
                        <input type="text" name="host" value="<?php echo e(old('host') ?: $mailConfig['host']); ?>"
                               placeholder="Host"
                               class="form-control <?php $__errorArgs = ['host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['host'];
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

                    <div class=" mb-3">
                        <label>Port</label>
                        <input type="text" name="port" value="<?php echo e(old('port') ?: $mailConfig['port']); ?>"
                               placeholder="Port"
                               class="form-control <?php $__errorArgs = ['port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['port'];
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

                    <div class=" mb-3">
                        <label>Username</label>
                        <input type="text" name="username" value="<?php echo e(old('username') ?: $mailConfig['username']); ?>"
                               placeholder="Username"
                               class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['username'];
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
                        <label>Password</label>
                        <input type="text" name="password" value="<?php echo e(old('password') ?: $mailConfig['password']); ?>"
                               placeholder="Password"
                               class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['password'];
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
                        <label class="form-label">Encryption</label>
                        <select class="form-select <?php $__errorArgs = ['mailer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="encryption">
                            <option
                                value="ssl" <?php echo e((old('encryption') ?: $mailConfig['encryption'] ) == 'ssl' ? 'selected': ''); ?>>
                                SSL
                            </option>
                            <option
                                value="tls" <?php echo e((old('encryption') ?: $mailConfig['encryption'] ) == 'tls' ? 'selected': ''); ?>>
                                TLS
                            </option>
                            <option
                                value="null" <?php echo e((old('encryption') ?: $mailConfig['encryption'] ) == null ? 'selected': ''); ?>>
                                None
                            </option>
                        </select>
                        <?php $__errorArgs = ['encryption'];
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
                        <label>Mail From</label>
                        <input type="email" name="mail_from_address"
                               value="<?php echo e(old('mail_from_address') ?: $mailFromConfig['address']); ?>"
                               placeholder="Email from address"
                               class="form-control <?php $__errorArgs = ['mail_from_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['mail_from_address'];
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
                        <label>Mail From Name</label>
                        <input type="text" name="mail_from_name"
                               value="<?php echo e(old('mail_from_name') ?: $mailFromConfig['name']); ?>"
                               placeholder="Mail from name"
                               class="form-control <?php $__errorArgs = ['mail_from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['mail_from_name'];
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
        const mailerType = document.querySelector('#mailerType');
        const smtpMailer = document.querySelector('#smtpMailer');
        const logMailerDetails = document.querySelector('#logMailerDetails');
        const smtpMailerDetails = document.querySelector('#smtpMailerDetails');

        function setMailerType(mailer) {
            const choice = mailerType.value
            if (choice === 'smtp') {
                smtpMailer.style.display = 'block'
                smtpMailerDetails.style.display = 'block'
                logMailerDetails.style.display = 'none'

            } else {
                smtpMailer.style.display = 'none'
                smtpMailerDetails.style.display = 'none'
                logMailerDetails.style.display = 'block'
            }
        }

        mailerType.addEventListener('change', setMailerType);
        window.addEventListener('load', setMailerType)
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('boilerplate::installer.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\blueCafe\vendor\binarycastle\boilerplate\src/../resources/views/installer/mail.blade.php ENDPATH**/ ?>