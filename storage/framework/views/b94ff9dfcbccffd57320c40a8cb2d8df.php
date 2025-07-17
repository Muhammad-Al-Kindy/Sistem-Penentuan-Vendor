<?php $__env->startSection('title', 'Edit Purchase Order'); ?>

<?php $__env->startSection('content'); ?>
    <div id="app" class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Purchase Order</h1>

            <!-- Form -->
            <form action="<?php echo e(route('vendor.purchase_order.store', ['id' => $purchaseOrder->idPurchaseOrder])); ?>"
                method="POST" class="space-y-6" enctype="multipart/form-data" data-purchaseorderedit-form>
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="hidden" name="purchase_order_id" value="<?php echo e($purchaseOrder->idPurchaseOrder); ?>">
                <input type="hidden" name="vendor_id" value="<?php echo e($purchaseOrder->vendorId); ?>">
                <input type="hidden" name="tanggal_update" value="<?php echo e(now()->format('Y-m-d')); ?>">

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <!-- No PO -->
                    <div class="w-full">
                        <label for="noPO" class="block mb-1 font-medium text-gray-700">No PO</label>
                        <!-- Input hidden untuk submit -->
                        <input type="hidden" name="noPO" value="<?php echo e($purchaseOrder->noPO); ?>">
                        <!-- Tampilan readonly -->
                        <div class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-700">
                            <?php echo e($purchaseOrder->noPO); ?>

                        </div>
                    </div>

                    <!-- Tanggal PO -->
                    <div class="w-full">
                        <label for="tanggalPO" class="block mb-1 font-medium text-gray-700">Tanggal PO</label>
                        <!-- Input hidden untuk submit -->
                        <input type="hidden" name="tanggalPO"
                            value="<?php echo e($purchaseOrder->tanggalPO ? $purchaseOrder->tanggalPO->format('Y-m-d') : ''); ?>">
                        <!-- Tampilan readonly -->
                        <div class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-700">
                            <?php echo e($purchaseOrder->tanggalPO ? $purchaseOrder->tanggalPO->format('Y-m-d') : ''); ?>

                        </div>
                    </div>
                </div>
                <div class="flex flex-row sm:gap-3 md:gap-10">
                    <!-- Dropdown Jenis Update -->
                    <div class="w-full">
                        <label for="jenis_update" class="block mb-1 font-medium text-gray-700">Jenis Update</label>
                        <select name="jenis_update" id="jenis_update"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            <option value="Created"
                                <?php echo e(old('jenis_update', $vendorUpdate->jenis_update ?? '') == 'Created' ? 'selected' : ''); ?>>
                                Created</option>
                            <option value="Progress"
                                <?php echo e(old('jenis_update', $vendorUpdate->jenis_update ?? '') == 'Progress' ? 'selected' : ''); ?>>
                                Progress</option>
                            <option value="Done"
                                <?php echo e(old('jenis_update', $vendorUpdate->jenis_update ?? '') == 'Done' ? 'selected' : ''); ?>>
                                Done</option>
                        </select>
                    </div>

                    <!-- Upload Dokumen -->
                    <div class="w-full">
                        <label for="dokumen" class="block mb-1 font-medium text-gray-700">Upload Dokumen</label>
                        <input type="file" name="dokumen" id="dokumen"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                        <?php if(!empty($vendorUpdate->dokumen)): ?>
                            <input type="hidden" name="existing_dokumen" value="<?php echo e($vendorUpdate->dokumen); ?>">
                            <p class="mt-1 text-sm text-gray-500">Dokumen saat ini: <a
                                    href="<?php echo e(asset('storage/' . $vendorUpdate->dokumen)); ?>" target="_blank"
                                    class="dokumen-download-link text-blue-600 underline">Lihat Dokumen</a></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Purchase Order Items Component -->
                <div>
                    <?php echo $__env->make('components.purchase-order-items-vendor', [
                        'initialItems' => $purchaseOrder->items->toArray(),
                        'initialVendorId' => $purchaseOrder->vendorId,
                        'vendors' => $vendors->toArray(),
                        'materials' => $materials->toArray(),
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-4 mt-6">
                    <a href="javascript:void(0);" onclick="window.history.back()"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg shadow">
                        ← Kembali
                    </a>

                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        window.initialItems = <?php echo json_encode($purchaseOrder->items->toArray(), 15, 512) ?>;
        window.initialVendorId = <?php echo json_encode($purchaseOrder->vendorId, 15, 512) ?>;
        window.vendors = <?php echo json_encode($vendors->toArray(), 15, 512) ?>;
        window.materials = <?php echo json_encode($materials->toArray(), 15, 512) ?>;
    </script>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/purchaseOrderEdit.js', 'resources/js/dokumenDownloadClose.js']); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appvendor', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/vendor/purchase_order_edit.blade.php ENDPATH**/ ?>