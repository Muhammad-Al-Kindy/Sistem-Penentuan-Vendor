<?php $__env->startSection('title', 'Halaman Chat'); ?>

<?php $__env->startSection('content'); ?>
    <div class="flex max-w-7xl mx-auto px-4 py-8 gap-6">
        <!-- Sidebar Vendor List -->
        <div class="w-1/4 border-r border-gray-200/60 pr-4">
            <h2 class="text-lg font-semibold text-blue-700 mb-4">Daftar Penerima</h2>

            <ul class="space-y-2" id="vendor-list">
                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="#"
                            class="vendor-item flex justify-between items-center p-3 rounded-md border border-gray-300/50 hover:bg-blue-50 transition bg-white cursor-pointer"
                            data-user-id="<?php echo e($vendor->user ? $vendor->user->idUser : ''); ?>"
                            data-vendor-id="<?php echo e($vendor->idVendor); ?>" data-vendor-name="<?php echo e($vendor->namaVendor); ?>">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-user-circle text-gray-500"></i>
                                <span><?php echo e($vendor->namaVendor); ?></span>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full bg-gray-300 text-gray-700">Belum</span>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <!-- Chat Area -->
        <div class="w-3/4">
            <div class="flex items-center mb-4 pb-2 border-b border-gray-300/50">
                <img src="https://ui-avatars.com/api/?name=Chat&background=0D8ABC&color=fff" alt="Avatar"
                    class="rounded-full w-10 h-10 mr-3">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        Chat dengan <span id="chat-with-name">[Pilih Vendor]</span>
                    </h3>
                    <p class="text-sm text-gray-500">Silakan kirim pesan untuk vendor</p>
                </div>
            </div>


            <!-- Report Dropdown -->
            <div id="report-container" class="mb-4 hidden">
                <label for="report-dropdown" class="text-sm font-medium text-gray-700 mb-1">Pilih Laporan:</label>
                <select id="report-dropdown" class="w-full border rounded p-2">
                    <option value="">-- Pilih Laporan --</option>

                    <?php $__currentLoopData = $nonConformanceReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $item = $report->goodsReceiptItem;
                        ?>

                        <?php if($item && $item->goodsReceipt && $item->goodsReceipt->vendor && $item->goodsReceipt->vendor->user): ?>
                            <?php
                                $vendor = $item->goodsReceipt->vendor;
                                $qtyPo = $item->qty_po ?? '-';
                                $qtySesuai = $item->qty_sesuai ?? '-';
                                $vendorName = $vendor->namaVendor ?? 'Tidak Diketahui';
                                $vendorUserId = $vendor->user->idUser ?? null;
                            ?>

                            <option value="<?php echo e($report->idNonConformance); ?>" data-vendor-id="<?php echo e($vendorUserId); ?>">
                                Laporan #<?php echo e($report->idNonConformance); ?> -
<?php echo e($report->keterangan && trim($report->keterangan) !== '' ? $report->keterangan : 'Tidak ada deskripsi'); ?>.
                                Dipesan: <?php echo e($qtyPo); ?>,
                                Sesuai: <?php echo e($qtySesuai); ?>

                            </option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                </select>

            </div>

            <div class="text-sm text-gray-500 mb-2" id="loading-message">Memuat pesan...</div>

            <div id="chat-container"
                class="border border-gray-300/50 rounded p-4 h-96 overflow-y-auto mb-4 space-y-2 bg-gray-50">
                <!-- Chat messages will appear here -->
            </div>

            <form id="chat-form" class="space-y-2" onsubmit="return false;" style="display: none;">
                <div class="flex space-x-2">
                    <input id="chat-input" type="text"
                        class="flex-1 border border-gray-300/50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        placeholder="Tulis pesan..." autocomplete="off">
                    <button id="chat-send" type="button"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Kirim
                    </button>
                </div>
            </form>

            <button type="button" onclick="window.history.back()"
                class="mt-3 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg border border-gray-300 shadow-sm transition">
                ← Kembali
            </button>
        </div>
    </div>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <script>
        window.authUserId = <?php echo e(auth()->user()->idUser); ?>;
        window.nonConformanceReports = <?php echo json_encode($nonConformanceReports, 15, 512) ?>;
    </script>

    <!-- Load chat.js -->
    <script type="module" src="<?php echo e(Vite::asset('resources/js/chat.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/admin/chat/chat.blade.php ENDPATH**/ ?>