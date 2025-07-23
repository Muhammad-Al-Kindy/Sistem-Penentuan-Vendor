<nav class="bg-white border-b border-gray-200 p-4 flex items-center justify-between">
    <button id="sidebarToggle" class="text-2xl text-gray-700">
        <i class="ri-menu-line"></i>
    </button>
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
            class="flex items-center space-x-2 focus:outline-none text-gray-700 hover:text-blue-600">
            <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode(auth()->user()->name)); ?>&background=random"
                class="w-8 h-8 rounded-full" alt="Avatar">
            <span class="font-medium"><?php echo e(auth()->user()->name); ?></span>
            <i class="ri-arrow-down-s-line"></i>
        </button>

        <div x-show="open" @click.away="open = false" x-transition
            class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg border border-gray-200 z-50">
            
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                    <i class="ri-logout-box-r-line mr-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

</nav>
<?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/components/nav.blade.php ENDPATH**/ ?>