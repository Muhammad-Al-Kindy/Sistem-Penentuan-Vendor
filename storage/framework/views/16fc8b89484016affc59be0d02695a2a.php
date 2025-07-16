<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
    <div class="flex w-full h-screen">
        <!-- Left Image Panel -->
        <div class="w-1/2 h-full hidden md:block">
            <img src="<?php echo e(asset('assets/train_structrue.png')); ?>" alt="Structure" class="h-full w-full object-cover">
        </div>

        <!-- Right Login Panel -->
        <div class="w-full md:w-1/2 flex items-center justify-center">
            <div class="w-full px-8">
                <h2 class="text-3xl font-semibold text-center mb-8">Login</h2>

                <?php if($errors->any()): ?>
                    <div class="mb-4 text-red-600 text-center">
                        <ul class="list-disc list-inside">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('login.post')); ?>" class="space-y-6">
                    <?php echo csrf_field(); ?>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>"
                            class="w-full px-4 py-2 rounded-full bg-gray-200 text-black focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required autofocus>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 rounded-full bg-gray-200 text-black focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Submit -->
                    <div>
                        <button type="submit"
                            class="w-full bg-gray-800 text-white rounded-full py-2 hover:bg-black transition">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/auth/login.blade.php ENDPATH**/ ?>