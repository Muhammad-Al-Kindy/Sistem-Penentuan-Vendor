<nav aria-label="breadcrumb" class="text-sm text-gray-500 mb-4">
    <ol class="list-reset flex">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($index + 1 === count($items)): ?>
                <li class="text-gray-800 font-semibold" aria-current="page"><?php echo e($item['label']); ?></li>
            <?php else: ?>
                <li>
                    <a href="<?php echo e($item['url']); ?>" class="hover:underline"><?php echo e($item['label']); ?></a>
                    <span class="mx-2">/</span>
                </li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
</nav>
<?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/components/breadcrumb.blade.php ENDPATH**/ ?>