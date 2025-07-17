<?php $__env->startSection('title', 'Edit Vendor'); ?>

<?php $__env->startSection('content'); ?>
    <div id="app" data-subkriteria-url="<?php echo e(route('vendor.index')); ?>" class="max-w-7xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <?php
            $breadcrumbItems = [
                ['label' => 'Home', 'url' => ''],
                ['label' => 'Vendor', 'url' => route('vendor.index')],
                ['label' => 'Edit Vendor', 'url' => ''],
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

        <!-- Card -->
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Vendor</h2>

            <form action="<?php echo e(route('vendor.update', $vendor)); ?>" method="POST" class="space-y-6" data-update-vendor-form
                data-redirect-url="<?php echo e(route('vendor.index')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="hidden" name="id" value="<?php echo e($vendor->idVendor); ?>">

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">

                        <label for="namaVendor" class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                        <input type="text" name="namaVendor" id="namaVendor"
                            value="<?php echo e(old('namaVendor', $vendor->namaVendor)); ?>"
                            class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                    <div class="w-full">
                        <label for="NPWP" class="block text-sm font-medium text-gray-700 mb-1">NPWP Perusahaan</label>
                        <input type="text" name="NPWP" id="NPWP" value="<?php echo e(old('NPWP', $vendor->NPWP)); ?>"
                            class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="SPPKP" class="block text-sm font-medium text-gray-700 mb-1">SPPKP Perusahaan</label>
                        <input type="text" name="SPPKP" id="SPPKP" value="<?php echo e(old('SPPKP', $vendor->SPPKP)); ?>"
                            class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="w-full">
                        <label for="nomorIndukPerusahaan" class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk
                            Berusaha Perusahaan</label>
                        <input type="text" name="nomorIndukPerusahaan" id="nomorIndukPerusahaan"
                            value="<?php echo e(old('nomorIndukPerusahaan', $vendor->nomorIndukPerusahaan)); ?>"
                            class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="jenisPerusahaan" class="block text-sm font-medium text-gray-700 mb-1">Jenis
                            Perusahaan</label>
                        <input type="text" name="jenisPerusahaan" id="jenisPerusahaan"
                            value="<?php echo e(old('jenisPerusahaan', $vendor->jenisPerusahaan)); ?>"
                            class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="w-full">
                        <label for="alamatVendor" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                            Perusahaan</label>
                        <input type="text" name="alamatVendor" id="alamatVendor"
                            value="<?php echo e(old('alamatVendor', $vendor->alamatVendor)); ?>"
                            class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Contact Information Section -->
                <?php
                    $contact = $vendor->contacts->first();
                ?>
                <hr class="my-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Informasi Kontak Vendor</h2>
                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="contactPerson" class="block mb-1 font-medium text-gray-700">Contact Person</label>
                        <input type="text" name="contactPerson" id="contactPerson"
                            value="<?php echo e(old('contactPerson', $contact->contactPerson ?? '')); ?>"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="w-full">
                        <label for="telepon" class="block mb-1 font-medium text-gray-700">Telepon</label>
                        <input type="text" name="telepon" id="telepon"
                            value="<?php echo e(old('telepon', $contact->telepon ?? '')); ?>"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="fax" class="block mb-1 font-medium text-gray-700">Fax</label>
                        <input type="text" name="fax" id="fax" value="<?php echo e(old('fax', $contact->fax ?? '')); ?>"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="w-full">
                        <label for="email" class="block mb-1 font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                            value="<?php echo e(old('email', $contact->email ?? '')); ?>"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex flex-row sm:gap-3 md:gap-10 ">
                    <div class="w-full">
                        <label for="jabatan" class="block mb-1 font-medium text-gray-700">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan"
                            value="<?php echo e(old('jabatan', $contact->jabatan ?? '')); ?>"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-4">
                    <a href="<?php echo e(route('vendor.index')); ?>"
                       class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 shadow">
                        ← Kembali
                    </a>
                
                    <button type="submit"
                        class="bg-black text-white px-6 py-2 rounded-md font-semibold hover:bg-gray-900 transition">
                        Update Vendor
                    </button>
                </div>
                
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/vendor/edit.blade.php ENDPATH**/ ?>