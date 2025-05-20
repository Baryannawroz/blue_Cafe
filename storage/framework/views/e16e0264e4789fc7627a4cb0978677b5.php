<?php if($next): ?>
    <input type="hidden" name="next_route" value="<?php echo e(route("installer.{$next['url']}")); ?>">
<?php else: ?>
    <input type="hidden" name="next_route" value="<?php echo e(url($finish_url)); ?>">
<?php endif; ?>

<div class="w-100 d-flex justify-content-between">
    <div>
        <?php if($previous): ?>
            <a href="<?php echo e($previous['url'] == '' ? '/installer' : route("installer.{$previous['url']}")); ?>"
               class="btn btn-secondary"><i class="bi bi-arrow-left-square-fill"></i> Prev</a>
        <?php endif; ?>
    </div>
    <div>
        <?php if($can_skip): ?>
            <?php if($next): ?>
                <a class="btn btn-link" href="<?php echo e(route("installer.{$next['url']}")); ?>">Skip</a>
            <?php else: ?>
                <a class="btn btn-link" href="<?php echo e(url($finish_url)); ?>">Skip</a>
            <?php endif; ?>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary"><?php echo e($next ? 'Next' : 'Finish'); ?> <i
                class="bi bi-arrow-right-square-fill"></i></button>
    </div>
</div>
<?php /**PATH D:\project\blueCafe\vendor\binarycastle\boilerplate\src/../resources/views/installer/components/installer-navigation-buttons.blade.php ENDPATH**/ ?>