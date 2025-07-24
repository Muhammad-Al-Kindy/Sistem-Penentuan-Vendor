<?php $__env->startSection('title', 'Rekomendasi'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6">
            <a href="#" class="hover:underline">Home</a>
            <span class="mx-2">/</span>
            <span>Rekomendasi</span>
        </nav>

        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Rekomendasi Vendor</h1>

            <!-- Filter Material -->
            <form method="POST" action="<?php echo e(route('smart.process')); ?>">
                <?php echo csrf_field(); ?>
                <label for="material_id" class="mr-2 font-medium text-gray-700">Pilih Barang:</label>
                <select name="material_id" id="material_id" onchange="this.form.submit()" class="border px-3 py-1 rounded">
                    <option value="">-- Semua Barang --</option>
                    <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($material->idMaterial); ?>"
                            <?php echo e(isset($selectedMaterialId) && $selectedMaterialId == $material->idMaterial ? 'selected' : ''); ?>>
                            <?php echo e($material->namaMaterial); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <!-- Hidden inputs for alternatives, weights, subcriteria -->
                <input type="hidden" name="alternatives" value="[]">
                <input type="hidden" name="weights" value="[]">
                <input type="hidden" name="subcriteria" value="{}">
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-x-auto mt-6">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Nama Perusahaan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4"><?php echo e($vendors->firstItem() + $index); ?></td>
                            <td class="px-6 py-4"><?php echo e($vendor->namaVendor); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-gray-500">Tidak ada data rekomendasi untuk
                                barang ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-end">
            <?php echo e($vendors->withQueryString()->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/admin/rekomendasi/index.blade.php ENDPATH**/ ?>