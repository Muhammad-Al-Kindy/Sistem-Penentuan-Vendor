<?php $__env->startSection('title', 'Vendor'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <?php
            $breadcrumbItems = [['label' => 'Home', 'url' => ''], ['label' => 'Vendor', 'url' => '']];
        ?>
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['items' => $breadcrumbItems]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($breadcrumbItems)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $attributes = $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $component = $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>


        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Vendor</h1>
        </div>
        <div class="flex items-center justify-between ">
            <!-- Search Form -->
            <div class="flex flex-col">
                <form method="GET" action="<?php echo e(route('vendor.index')); ?>" class="mb-4">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search vendor..."
                        class="w-full md:w-96 sm:w-52 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-400">
                    <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        <i class="ri-search-line mr-1"></i> Cari
                    </button>
                </form>
            </div>
            <div class="col-md-6">
                <a href="<?php echo e(route('vendor.create')); ?>"
                    class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow">
                    <i class="ri-add-line mr-1"></i> Tambah Vendor
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Nama Perusahaan</th>
                        <th class="px-6 py-3 text-left">NPWP Perusahaan</th>
                        <th class="px-6 py-3 text-left">Jenis Perusahaan</th>
                        <th class="px-6 py-3 text-left">Alamat Perusahaan</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($vendors->firstItem() + $index); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($vendor->namaVendor); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($vendor->NPWP); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($vendor->jenisPerusahaan); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($vendor->alamatVendor); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center gap-2">
                                    <?php if(isset($vendor->idVendor) && $vendor->idVendor): ?>
                                        <a href="<?php echo e(route('vendor.edit', $vendor->idVendor)); ?>"
                                            class="text-yellow-600 hover:text-yellow-800">
                                            <i class="ri-edit-box-line text-lg"></i>
                                        </a>
                                        <form action="<?php echo e(route('vendor.destroy', $vendor->idVendor)); ?>" method="POST"
                                            data-delete-form>
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="ri-delete-bin-line text-lg"></i>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-gray-400">Invalid Vendor ID</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data vendor.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-end">
            <?php echo e($vendors->links('components.pagination')); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/vendor/index.blade.php ENDPATH**/ ?>