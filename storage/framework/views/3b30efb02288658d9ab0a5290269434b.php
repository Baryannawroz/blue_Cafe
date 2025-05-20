<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Installer - <?php echo $__env->yieldContent('title'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/boilerplate/css/bootstrap.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="container">
<div style="padding-top: 10vh">
    <?php if (isset($component)) { $__componentOriginal36db55375db160b5606b9e08c75d82cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal36db55375db160b5606b9e08c75d82cf = $attributes; } ?>
<?php $component = BinaryCastle\Boilerplate\View\Components\InstallerTimeline::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('installer-timeline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BinaryCastle\Boilerplate\View\Components\InstallerTimeline::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal36db55375db160b5606b9e08c75d82cf)): ?>
<?php $attributes = $__attributesOriginal36db55375db160b5606b9e08c75d82cf; ?>
<?php unset($__attributesOriginal36db55375db160b5606b9e08c75d82cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal36db55375db160b5606b9e08c75d82cf)): ?>
<?php $component = $__componentOriginal36db55375db160b5606b9e08c75d82cf; ?>
<?php unset($__componentOriginal36db55375db160b5606b9e08c75d82cf); ?>
<?php endif; ?>
</div>

<?php echo $__env->yieldContent('content'); ?>

<script src="<?php echo e(asset('vendor/boilerplate/js/bootstrap.bundle.js')); ?>"></script>
</body>
</html>
<?php /**PATH D:\project\blueCafe\vendor\binarycastle\boilerplate\src/../resources/views/installer/base.blade.php ENDPATH**/ ?>