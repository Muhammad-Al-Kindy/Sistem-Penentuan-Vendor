<?php $__env->startSection('title', 'Manajemen Pengguna'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <?php if(session('success')): ?>
            <div class="mb-4 p-4 text-green-800 bg-green-200 rounded">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6">
            <a href="#" class="hover:underline">Home</a>
            <span class="mx-2">/</span>
            <span>Manajemen Pengguna</span>
        </nav>

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Pengguna</h1>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Role</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4"><?php echo e($users->firstItem() + $index); ?></td>
                            <td class="px-6 py-4"><?php echo e($user->name); ?></td>
                            <td class="px-6 py-4"><?php echo e($user->email); ?></td>
                            <td class="px-6 py-4 <?php echo e($user->role == 'Admin' ? 'text-blue-600' : 'text-green-600'); ?>">
                                <?php echo e($user->role); ?></td>
                            <td class="px-6 py-4">
                                <a href="<?php echo e(route('users.edit', $user->idUser)); ?>"
                                    class="text-sm text-blue-500 hover:underline"> <i class="ri-edit-box-line text-lg"></i>
                                </a>
                                <form action="<?php echo e(route('users.destroy', $user->idUser)); ?>" method="POST" class="inline"
                                    data-delete-form>
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-sm text-red-500 hover:underline ml-2" "
                                        >Hapus</button>
                                </form>
                            </td>
                        </tr>
     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-end">
            <?php echo e($users->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/users/index.blade.php ENDPATH**/ ?>