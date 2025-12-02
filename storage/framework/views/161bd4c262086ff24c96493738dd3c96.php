

<?php $__env->startSection('title','Pedidos'); ?>
<?php $__env->startSection('page_title','Pedidos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">
        <i class="fas fa-receipt mr-2"></i>Pedidos
      </h3>

      <form class="form-inline" method="GET">
        <input type="text" name="q" class="form-control form-control-sm mr-2"
               placeholder="Buscar cliente" value="<?php echo e(request('q')); ?>">

        <select name="estado" class="form-control form-control-sm mr-2">
          <option value="">Todos los estados</option>
          <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($key); ?>" <?php echo e(request('estado') == $key ? 'selected' : ''); ?>>
              <?php echo e($label); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <input type="date" name="fecha_desde" class="form-control form-control-sm mr-2"
               value="<?php echo e(request('fecha_desde')); ?>">
        <input type="date" name="fecha_hasta" class="form-control form-control-sm mr-2"
               value="<?php echo e(request('fecha_hasta')); ?>">

        <button class="btn btn-success btn-sm" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Fecha</th>
              <th>Cliente</th>
              <th>Total</th>
              <th>Estado</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td><?php echo e($pedido->id); ?></td>
              <td><?php echo e($pedido->created_at->format('d/m/Y H:i')); ?></td>
              <td><?php echo e($pedido->user->name); ?><br><small class="text-muted"><?php echo e($pedido->user->email); ?></small></td>
              <td>Bs <?php echo e(number_format($pedido->total, 2)); ?></td>
              <td>
                <span class="badge badge-pill 
                  <?php if($pedido->estado == 'pendiente'): ?> badge-warning
                  <?php elseif($pedido->estado == 'en_proceso'): ?> badge-info
                  <?php elseif($pedido->estado == 'entregado'): ?> badge-success
                  <?php else: ?> badge-danger
                  <?php endif; ?>">
                  <?php echo e(ucfirst(str_replace('_',' ',$pedido->estado))); ?>

                </span>
              </td>
              <td class="text-right">
                <a href="<?php echo e(route('admin.pedidos.show', $pedido)); ?>" class="btn btn-sm btn-primary">
                  <i class="fas fa-eye"></i> Ver
                </a>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="6" class="text-center text-muted p-4">
                No hay pedidos registrados.
              </td>
            </tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <?php if($pedidos->hasPages()): ?>
      <div class="card-footer">
        <?php echo e($pedidos->links()); ?>

      </div>
    <?php endif; ?>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/admin/pedidos/index.blade.php ENDPATH**/ ?>