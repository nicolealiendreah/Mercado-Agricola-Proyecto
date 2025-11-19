<?php $__env->startSection('content'); ?>
<div class="x_panel">
  <div class="x_title"><h2>Detalle de Maquinaria</h2></div>
  <div class="x_content">
    <dl class="row">
      <dt class="col-sm-2">Nombre</dt><dd class="col-sm-10"><?php echo e($maquinaria->nombre); ?></dd>
      <dt class="col-sm-2">Tipo</dt><dd class="col-sm-10"><?php echo e($maquinaria->tipo); ?></dd>
      <dt class="col-sm-2">Marca</dt><dd class="col-sm-10"><?php echo e($maquinaria->marca); ?></dd>
      <dt class="col-sm-2">Modelo</dt><dd class="col-sm-10"><?php echo e($maquinaria->modelo); ?></dd>
      <dt class="col-sm-2">Precio por día</dt><dd class="col-sm-10"><?php echo e(number_format($maquinaria->precio_dia,2)); ?></dd>
      <dt class="col-sm-2">Estado</dt><dd class="col-sm-10"><?php echo e($maquinaria->estado); ?></dd>
      <dt class="col-sm-2">Descripción</dt><dd class="col-sm-10"><?php echo e($maquinaria->descripcion); ?></dd>
    </dl>
    <a class="btn btn-secondary" href="<?php echo e(route('maquinarias.index')); ?>">Volver</a>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/maquinarias/show.blade.php ENDPATH**/ ?>