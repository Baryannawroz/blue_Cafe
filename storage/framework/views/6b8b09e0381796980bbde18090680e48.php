<style>
    :root {
        --border-color: rgb(100 116 139);
        --shadow-color: rgb(226 232 240);
        --width: 30px;
        /* -- N:B: min-width: 24px -- */
        --height: 4px;
        --active-color: green;
    }


    .time-line-section {
        display: flex;
        text-align: center;
        width: 100%;
        overflow-x: auto;
        padding-bottom: 48px;
    }

    .time-line-section .item {
        position: relative;
        width: 100%;
        min-width: 115px;
        margin-top: 8px;
    }

    .time-line-section .item:after,
    .time-line-section .item:before,
    .time-line-section .count:after {
        position: absolute;
        content: "";
        width: 100%;
    }

    .time-line-section .item:after {
        height: var(--height);
        top: calc((var(--width) / 2) - (var(--height) / 2));
        left: 50%;
        background: var(--border-color);
    }

    .time-line-section .item:before {
        height: var(--height);
        top: calc((var(--width) / 2) - (var(--height) / 2));
        left: 50%;
        box-shadow: 0 0 0 5px var(--shadow-color);
    }

    .time-line-section .item:first-child:after {
        /* left: calc(50% + 10px); */
    }

    .time-line-section .item:last-child:after {
        content: none;
    }

    .time-line-section .item:last-child:before {
        content: none;
    }

    .time-line-section .count {
        width: var(--width);
        height: var(--width);
        line-height: var(--width);
        background: var(--border-color);
        border-radius: 50%;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        display: inline-block;
        margin-bottom: 16px;
        position: relative;
    }

    .time-line-section .count span {
        position: relative;
        z-index: 99;
    }

    .time-line-section .item:last-child .count span {
        background: #fff;
        border-radius: 50%;
        width: 14px;
        height: 14px;
        display: inline-block;
        line-height: 14px;
    }

    .time-line-section .count:after {
        height: 100%;
        top: 0;
        left: 0;
        box-shadow: 0 0 0 5px var(--shadow-color);
        border-radius: 50%;
        z-index: -1;
    }

    .time-line-section .item.active:after {
        background: var(--active-color);
    }

    .time-line-section .item.active .count {
        background: var(--active-color);
    }
</style>


<div class="time-line-section">
    <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="item <?php echo e($key <= $active ? 'active' : ''); ?>">
            <div class="count"><span><?php echo e($key + 1); ?></span></div>
            <div><?php echo e($step['title']); ?></div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH D:\project\blueCafe\vendor\binarycastle\boilerplate\src/../resources/views/installer/components/installer-timeline.blade.php ENDPATH**/ ?>