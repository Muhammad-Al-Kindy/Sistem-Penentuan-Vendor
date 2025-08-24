<?php if($paginator->hasPages()): ?>
    <nav class="inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
        
        <?php if($paginator->onFirstPage()): ?>
            <span aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>"
                class="px-3 py-1 bg-gray-200 rounded-l cursor-default select-none">«</span>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev"
                class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-l" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">«</a>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php if(is_string($element)): ?>
                <span aria-disabled="true"
                    class="px-3 py-1 bg-gray-200 cursor-default select-none"><?php echo e($element); ?></span>
            <?php endif; ?>

            
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <span aria-current="page"
                            class="px-3 py-1 bg-blue-500 text-white cursor-default select-none"><?php echo e($page); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>"
                            class="px-3 py-1 bg-gray-200 hover:bg-gray-300"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next"
                class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-r" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">»</a>
        <?php else: ?>
            <span aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>"
                class="px-3 py-1 bg-gray-200 rounded-r cursor-default select-none">»</span>
        <?php endif; ?>
    </nav>
<?php endif; ?>
<?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/components/pagination.blade.php ENDPATH**/ ?>