

<?php $__env->startSection('title', 'Pedido #'.$pedido->id); ?>
<?php $__env->startSection('page_title', 'Pedido #'.$pedido->id); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div>
        <h3 class="card-title mb-0">
          Pedido #<?php echo e($pedido->id); ?>

        </h3>
        <small class="text-muted">
          Fecha: <?php echo e($pedido->created_at->format('d/m/Y H:i')); ?> |
          Cliente: <?php echo e($pedido->user->name); ?> (<?php echo e($pedido->user->email); ?>)
        </small>
      </div>

      <form action="<?php echo e(route('admin.pedidos.updateEstado', $pedido)); ?>" method="POST" class="form-inline">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <label class="mr-2 mb-0">Estado:</label>
        <select name="estado" class="form-control form-control-sm mr-2">
          <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($key); ?>" <?php echo e($pedido->estado == $key ? 'selected' : ''); ?>>
              <?php echo e($label); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="btn btn-sm btn-success" type="submit">
          <i class="fas fa-save mr-1"></i>Actualizar
        </button>
      </form>
    </div>

    <div class="card-body">
      <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle mr-1"></i><?php echo e(session('success')); ?>

          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      <?php endif; ?>

      <h5>Productos del pedido</h5>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Tipo</th>
              <th>Cantidad</th>
              <th>Precio unit.</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
          <?php $__currentLoopData = $pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td>
                <?php echo e($detalle->nombre_producto); ?>

                <?php if($detalle->notas): ?>
                  <br><small class="text-muted"><?php echo e($detalle->notas); ?></small>
                <?php endif; ?>
              </td>
              <td><?php echo e(ucfirst($detalle->product_type)); ?></td>
              <td><?php echo e($detalle->cantidad); ?></td>
              <td>Bs <?php echo e(number_format($detalle->precio_unitario, 2)); ?></td>
              <td>Bs <?php echo e(number_format($detalle->subtotal, 2)); ?></td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>

      <div class="text-right mt-3">
        <h4>Total: Bs <?php echo e(number_format($pedido->total, 2)); ?></h4>
      </div>
    </div>

    <div class="card-footer">
      <a href="<?php echo e(route('admin.pedidos.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Volver a la lista
      </a>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/admin/pedidos/show.blade.php ENDPATH**/ ?>