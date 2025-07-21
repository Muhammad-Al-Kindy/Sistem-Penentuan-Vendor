<?php $__env->startSection('title', 'Edit Purchase Order'); ?>

<?php $__env->startSection('content'); ?>
    <div id="app" class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Purchase Order</h1>

            <!-- Form -->
            <form action="<?php echo e(url('/purchase-order/update/' . $purchaseOrder->idPurchaseOrder)); ?>" method="POST"
                class="space-y-6" data-purchaseorderedit-form-admin>
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="hidden" name="id" value="<?php echo e($purchaseOrder->idPurchaseOrder); ?>">

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <!-- Nama Vendor -->
                    <div class="w-full">
                        <label for="vendorId" class="block mb-1 font-medium text-gray-700">Nama Vendor</label>
                        <select name="vendorId" id="vendorId" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled>Pilih Vendor</option>
                            <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($v->idVendor); ?>"
                                    <?php echo e($v->idVendor == old('vendorId', $purchaseOrder->vendorId) ? 'selected' : ''); ?>>
                                    <?php echo e($v->namaVendor); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <!-- No PO -->
                    <div class="w-full">
                        <label for="noPO" class="block mb-1 font-medium text-gray-700">No PO</label>
                        <input type="text" name="noPO" id="noPO"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="<?php echo e(old('noPO', $purchaseOrder->noPO)); ?>">
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <!-- Tanggal Order -->
                    <div class="w-full">
                        <label for="tanggalPO" class="block mb-1 font-medium text-gray-700">Tanggal PO</label>
                        <input type="date" name="tanggalPO" id="tanggalPO"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="<?php echo e(old('tanggalPO', $purchaseOrder->tanggalPO ? $purchaseOrder->tanggalPO->format('Y-m-d') : '')); ?>">
                    </div>
                    <div class="w-full">
                        <label for="noKontrak" class="block mb-1 font-medium text-gray-700">No Kontrak</label>
                        <input type="text" name="noKontrak" id="noKontrak"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="<?php echo e(old('noKontrak', $purchaseOrder->noKontrak)); ?>">
                    </div>

                </div>
                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="tanggalRevisi" class="block mb-1 font-medium text-gray-700">Tanggal Revisi</label>
                        <input type="date" name="tanggalRevisi" id="tanggalRevisi"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="<?php echo e(old('tanggalRevisi', $purchaseOrder->tanggalRevisi ? $purchaseOrder->tanggalRevisi->format('Y-m-d') : '')); ?>">
                    </div>
                    <div class="w-full">
                        <label for="noRevisi" class="block mb-1 font-medium text-gray-700">No Revisi</label>
                        <input type="text" name="noRevisi" id="noRevisi"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="<?php echo e(old('noRevisi', $purchaseOrder->noRevisi)); ?>">
                    </div>
                </div>
                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="incoterm" class="block mb-1 font-medium text-gray-700">Incoterm</label>
                        <input type="text" name="incoterm" id="incoterm"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="<?php echo e(old('incoterm', $purchaseOrder->incoterm)); ?>">
                    </div>

                </div>

                <!-- Purchase Order Items Component -->
                <div>
                    <?php echo $__env->make('components.purchase-order-items', [
                        'initialItems' => $purchaseOrder->items->toArray(),
                        'initialVendorId' => $purchaseOrder->vendorId,
                        'vendors' => $vendors->toArray(),
                        'materials' => $materials->toArray(),
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>


                <!-- Buttons -->
                <div class="flex justify-end gap-4 mt-6">
                    <a href="<?php echo e(route('purchase.index')); ?>"
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
    <script type="module" src="<?php echo e(asset('js/updatePurchaseOrder.js')); ?>"></script>
    


    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/admin/purchase_order/edit.blade.php ENDPATH**/ ?>