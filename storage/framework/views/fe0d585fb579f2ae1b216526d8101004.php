

<?php $__env->startSection('title', 'Detalle del Pedido'); ?>
<?php $__env->startSection('page_title', 'Detalle del Pedido'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div>
        <h3 class="card-title">
          Pedido #<?php echo e($pedido->id); ?>

        </h3>
        <p class="mb-0 text-muted">Fecha: <?php echo e($pedido->created_at->format('d/m/Y H:i')); ?></p>
      </div>
      <span class="badge badge-info text-uppercase"><?php echo e($pedido->estado); ?></span>
    </div>
    <div class="card-body">
      <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
      <?php endif; ?>

      <h5>Productos</h5>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Tipo</th>
            <th>Cantidad</th>
            <th>Precio Unit.</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($detalle->nombre_producto); ?></td>
              <td><?php echo e(ucfirst($detalle->product_type)); ?></td>
              <td><?php echo e($detalle->cantidad); ?></td>
              <td>Bs <?php echo e(number_format($detalle->precio_unitario, 2)); ?></td>
              <td>Bs <?php echo e(number_format($detalle->subtotal, 2)); ?></td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>

      <div class="text-right mt-3">
        <h4>Total: Bs <?php echo e(number_format($pedido->total, 2)); ?></h4>
      </div>

      <a href="<?php echo e(route('pedidos.index')); ?>" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left mr-1"></i> Volver a mis pedidos
      </a>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/pedidos/show.blade.php ENDPATH**/ ?>