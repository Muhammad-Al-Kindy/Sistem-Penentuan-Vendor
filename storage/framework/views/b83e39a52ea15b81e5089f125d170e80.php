<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $__env->yieldContent('title', 'Guest Page'); ?></title>

  <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col justify-center items-center">

  <?php echo $__env->yieldContent('content'); ?>

</body>
</html>
<?php /**PATH D:\Aplikasi\Laragon\laragon\www\skripsi_kindyv2\Sistem_Pemilihan_Vendor\resources\views/layouts/guest.blade.php ENDPATH**/ ?>