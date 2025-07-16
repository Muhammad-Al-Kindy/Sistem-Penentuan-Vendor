<?php $__env->startSection('title', 'Kriteria'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <?php
            $breadcrumbItems = [
                ['label' => 'Home', 'url' => route('kriteria.index')],
                ['label' => 'Kriteria', 'url' => ''],
            ];
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
            <h1 class="text-3xl font-bold text-gray-800">Kriteria</h1>
        </div>

        <div class="mb-4">
            <!-- Search Form -->
            <form method="GET" action="<?php echo e(route('kriteria.index')); ?>" class="mb-4">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search kriteria..."
                    class="w-1/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400">
                <button type="submit"
                    class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-flex items-center">
                    <i class="ri-search-line mr-1"></i> Cari
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Kriteria</th>
                        <th class="px-6 py-3 text-left">Tipe</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 ">
                    <?php $__empty_1 = true; $__currentLoopData = $kriterias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $kriteria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-blue-100 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($kriterias->firstItem() + $index); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($kriteria->namaKriteria); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($kriteria->tipe); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="<?php echo e(route('subkriteria.index', ['kriteriaId' => $kriteria->idKriteria])); ?>"
                                    class="inline-flex items-center bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded text-sm font-semibold">
                                    <i class="ri-edit-box-line mr-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data kriteria.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <?php echo e($kriterias->links('pagination::tailwind')); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/admin/kriteria/index.blade.php ENDPATH**/ ?>