<?php $__env->startSection('title', 'Create Purchase Order'); ?>

<?php $__env->startSection('content'); ?>
    <div id="app" class="max-w-7xl mx-auto px-4 py-8" data-subkriteria-url="<?php echo e(route('purchase.index')); ?>">
        <!-- Breadcrumb -->
        <?php
            $breadcrumbItems = [
                ['label' => 'Home', 'url' => route('purchase.index')],
                ['label' => 'Purchase Order', 'url' => route('purchase.index')],
                ['label' => 'Add Purchase Order', 'url' => ''],
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
        <!-- Title -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Add Purchase Order</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Form -->
            <?php if($errors->any()): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="<?php echo e(route('purchase.submit')); ?>" method="POST" class="space-y-6" data-store-form>
                <?php echo csrf_field(); ?>
                <!-- Nama Vendor -->
                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="vendorId" class="block mb-1 font-medium text-gray-700">Nama Vendor</label>
                        <select name="vendorId" id="vendorId" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Pilih Vendor</option>
                            <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($vendor->idVendor); ?>"><?php echo e($vendor->namaVendor); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <!-- No PO -->
                    <div class="w-full">
                        <label for="noPO" class="block mb-1 font-medium text-gray-700">No PO</label>
                        <input type="text" name="noPO" id="noPO"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Nomor Purchase Order" required>
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <!-- Tanggal PO -->
                    <div class="w-full">
                        <label for="tanggalPO" class="block mb-1 font-medium text-gray-700">Tanggal PO</label>
                        <input type="date" name="tanggalPO" id="tanggalPO"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                    <!-- No Kontrak -->
                    <div class="w-full">
                        <label for="noKontrak" class="block mb-1 font-medium text-gray-700">No Kontrak <span
                                class="opacity-50">(Optional)</span></label>
                        <input type="text" name="noKontrak" id="noKontrak"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Nomor Kontrak">
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <!-- Tanggal Revisi -->
                    <div class="w-full">
                        <label for="tanggalRevisi" class="block mb-1 font-medium text-gray-700">Tanggal Revisi
                            <span class="opacity-50">(Optional)</span></label>
                        <input type="date" name="tanggalRevisi" id="tanggalRevisi"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <!-- Incoterm -->
                    <div class="w-full">
                        <label for="incoterm" class="block mb-1 font-medium text-gray-700">Incoterm <span
                                class="opacity-50">(Optional)</span></label>
                        <input type="text" name="incoterm" id="incoterm"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Incoterm">
                    </div>
                </div>

                <!-- Purchase Order Items -->
                <?php echo $__env->make('components.purchase-order-items', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



                <!-- Submit -->
                <!-- Submit dan Kembali -->
                <div class="flex justify-end gap-4 pt-4">
                    <a href="<?php echo e(route('purchase.index')); ?>"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 shadow">
                        ← Kembali
                    </a>
                    <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-900 transition">
                        Buat Purchase Order
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        window.initialItems = <?php echo json_encode(old('items', []), 512) ?>; // Jika gagal submit, tetap isi ulang
        window.initialVendorId = <?php echo json_encode(old('vendorId'), 15, 512) ?>; // Ambil dari old input
        window.vendors = <?php echo json_encode($vendors, 15, 512) ?>;
        window.materials = <?php echo json_encode($materials, 15, 512) ?>; // all materials initially
    </script>


    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/admin/purchase_order/add.blade.php ENDPATH**/ ?>