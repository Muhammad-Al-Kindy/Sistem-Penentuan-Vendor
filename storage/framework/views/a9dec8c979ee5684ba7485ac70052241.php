<nav class="bg-white border-b border-gray-200 p-4 flex items-center justify-between">
    <button id="sidebarToggle" class="text-2xl text-gray-700">
        <i class="ri-menu-line"></i>
    </button>
    <div class="flex items-center space-x-4">
        <span class="font-semibold">System CRUD</span>
        <!-- Logout dropdown -->
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="text-sm text-gray-600 hover:text-red-600 transition">
                <i class="ri-logout-box-r-line text-lg"></i> Logout
            </button>
        </form>
    </div>

</nav>
<?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/components/nav.blade.php ENDPATH**/ ?>