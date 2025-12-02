

<?php $__env->startSection('title', 'Mis Pedidos'); ?>
<?php $__env->startSection('page_title', 'Mis Pedidos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="card shadow-sm">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-receipt mr-2"></i>Mis Pedidos</h3>
    </div>
    <div class="card-body">
      <?php if($pedidos->count()): ?>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Fecha</th>
              <th>Total</th>
              <th>Estado</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($pedido->id); ?></td>
              <td><?php echo e($pedido->created_at->format('d/m/Y H:i')); ?></td>
              <td>Bs <?php echo e(number_format($pedido->total, 2)); ?></td>
              <td><span class="badge badge-info text-uppercase"><?php echo e($pedido->estado); ?></span></td>
              <td>
                <a href="<?php echo e(route('pedidos.show', $pedido)); ?>" class="btn btn-sm btn-primary">
                  <i class="fas fa-eye mr-1"></i>Ver
                </a>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>

        <?php echo e($pedidos->links()); ?>

      <?php else: ?>
        <p class="text-muted mb-0">Aún no tienes pedidos.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/pedidos/index.blade.php ENDPATH**/ ?>