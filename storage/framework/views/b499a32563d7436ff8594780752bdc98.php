<?php $__env->startSection('content'); ?>
<div class="x_panel">
  <div class="x_title"><h2>Nuevo Orgánico</h2></div>
  <div class="x_content">
    <?php if($errors->any()): ?>
      <div class="alert alert-danger">
        <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
      </div>
    <?php endif; ?>

    <form action="<?php echo e(route('organicos.store')); ?>" method="post" enctype="multipart/form-data">
      <?php echo $__env->make('organicos._form', ['organico' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proy2\ProyectoAgricolaLocal\resources\views/organicos/create.blade.php ENDPATH**/ ?>