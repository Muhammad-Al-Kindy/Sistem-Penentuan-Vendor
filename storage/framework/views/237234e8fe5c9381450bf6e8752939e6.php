<?php $__env->startSection('title', 'Reports Vendor'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Reports Vendor</h1>

        <div class="mb-4">
            <input type="text" id="searchInput" placeholder="Cari laporan..."
                class="border border-gray-300 rounded px-4 py-2 w-1/3">
            <button id="searchButton"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded ml-2">Cari</button>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full table-auto text-sm border border-gray-200 shadow-sm rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Items</th>
                        <th class="px-6 py-3 text-left">Tanggal Ditemukan</th>
                        <th class="px-6 py-3 text-left">Keterangan</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody id="bg-white divide-y reportsTableBody">
                    <?php $__empty_1 = true; $__currentLoopData = $nonConformances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-6 py-4">
                                <?php echo e($index + 1 + ($nonConformances->currentPage() - 1) * $nonConformances->perPage()); ?></td>
                            <td class="px-6 py-4"><?php echo e($report->goodsReceiptItem->deskripsi ?? 'N/A'); ?></td>
                            <td class="px-6 py-4">
                                <?php echo e(\Carbon\Carbon::parse($report->tanggal_ditemukan)->format('Y-m-d')); ?></td>
                            <td class="px-6 py-4"><?php echo e($report->keterangan); ?></td>
                            <td class="px-6 py-4">
                                <a href="<?php echo e(route('chat.index.vendor', ['reportId' => $report->idNonConformance])); ?>"
                                    class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200"
                                    title="Lihat Chat">
                                    <i class="ri-message-2-line text-lg"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="border px-4 py-2 text-center text-gray-500">No reports found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <?php echo e($nonConformances->links()); ?>

        </div>
    </div>

    <script>
        document.getElementById('searchButton').addEventListener('click', function() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#reportsTableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.appvendor', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/vendor/reports.blade.php ENDPATH**/ ?>