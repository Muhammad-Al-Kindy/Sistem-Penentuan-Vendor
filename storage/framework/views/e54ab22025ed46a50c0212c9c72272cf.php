<?php $__env->startSection('title', 'Chat dengan Admin'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Chat dengan Admin</h1>

        <div class="mb-4">
            <p class="text-gray-600">
                Anda sedang membuka chat terkait laporan <strong>ID: <?php echo e($reportId ?? 'N/A'); ?></strong>
            </p>

        </div>

        <div class="bg-white rounded-lg shadow p-6 flex flex-col">


            <div id="chat-container" class="border rounded-lg p-4 h-64 overflow-y-auto bg-gray-50 mb-4">
                
            </div>

            <form id="chat-form" onsubmit="return false;">
                <div class="flex gap-2">
                    <input type="text" id="message-input"
                        class="flex-1 border border-gray-300 rounded px-4 py-2 focus:ring focus:border-blue-400"
                        placeholder="Tulis pesan...">
                    <button type="button" id="send-button"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Kirim
                    </button>

                </div>
            </form>
        </div>
    </div>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/chatVendor.js'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        window.authUserId = <?php echo e(auth()->user()->idUser); ?>;
        window.chatPartnerId = <?php echo e($admin->idUser); ?>;
        window.nonConformanceId = <?php echo json_encode($nonConformanceId, 15, 512) ?>;
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.appvendor', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/vendor/chat_new.blade.php ENDPATH**/ ?>