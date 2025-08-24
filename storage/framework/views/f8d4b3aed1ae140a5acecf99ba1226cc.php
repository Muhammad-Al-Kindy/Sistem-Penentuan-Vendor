<?php $__env->startSection('title', 'Progress Purchase Order'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-5xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Progress Purchase Order</h1>

        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="text-lg font-semibold mb-2">Detail PO</h2>
            <p><strong>No PO:</strong> <?php echo e($order->noPO); ?></p>
            <p><strong>Tanggal PO:</strong> <?php echo e($order->tanggalPO->format('Y-m-d')); ?></p>
            <p><strong>Vendor:</strong> <?php echo e($order->vendor->namaVendor ?? '-'); ?></p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Riwayat Update</h2>
            <table class="min-w-full table-auto text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left">Tanggal</th>
                        <th class="border px-4 py-2 text-left">Jenis Update</th>
                        <th class="border px-4 py-2 text-left">Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $order->vendorUpdates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $update): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="border px-4 py-2">
                                <?php echo e(\Carbon\Carbon::parse($update->tanggal_update)->format('d M Y')); ?></td>
                            <td class="border px-4 py-2"><?php echo e($update->jenis_update); ?></td>
                            <td class="border px-4 py-2">
                                <?php if($update->dokumen): ?>
                                    <a href="<?php echo e(asset('storage/vendor_updates/' . $update->dokumen)); ?>" target="_blank"
                                        class="text-blue-600 underline">Lihat Dokumen</a>
                                <?php else: ?>
                                    <span class="text-gray-500">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="text-center py-2 text-gray-500">Belum ada riwayat update.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php if(!isset($latestUpdate) || $latestUpdate->jenis_update !== 'Dibatalkan'): ?>
                <form action="<?php echo e(route('purchase.cancel', $order->idPurchaseOrder)); ?>" method="POST"
                    onsubmit="return confirm('Yakin ingin membatalkan purchase order ini?')" class="mt-6 space-y-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Alasan
                            Pembatalan:</label>
                        <select id="keterangan" name="keterangan" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-red-400">
                            <option value="">-- Pilih Alasan --</option>
                            <option value="reka">Karena pertimbangan REKA</option>
                            <option value="buruk">Karena Respon Vendor yang buruk</option>
                            <option value="gagal">Karena Vendor Gagal memenuhi kewajibannya</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Batalkan Purchase Order
                    </button>
                </form>
            <?php endif; ?>



        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/admin/purchase_order/progress.blade.php ENDPATH**/ ?>