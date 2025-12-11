<?php $__env->startSection('title', 'Reporte de Rendimiento de Vendedores'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 text-dark">
                    <i class="fas fa-users text-primary"></i> Reporte de Rendimiento de Vendedores
                </h1>
                <p class="text-muted mb-0">
                    Análisis del desempeño de vendedores: productos publicados, ventas y tasa de conversión.
                </p>
            </div>
            <div>
                <a href="<?php echo e(route('admin.reportes.vendedores.export.pdf', request()->all())); ?>"
                    class="btn btn-outline-success btn-sm">
                    Exportar PDF
                </a>


                <a href="<?php echo e(route('admin.reportes.vendedores.excel', request()->all())); ?>" class="btn btn-info btn-sm">
                    <i class="fas fa-file-excel mr-1"></i> Exportar Excel
                </a>
            </div>
        </div>

        
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-filter mr-2"></i>Filtros de Búsqueda</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.reportes.vendedores')); ?>">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="font-weight-bold">Desde</label>
                            <input type="date" name="desde" value="<?php echo e($desde->format('Y-m-d')); ?>" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="font-weight-bold">Hasta</label>
                            <input type="date" name="hasta" value="<?php echo e($hasta->format('Y-m-d')); ?>" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="font-weight-bold">Vendedor</label>
                            <select name="vendedor_id" class="form-control">
                                <option value="">Todos</option>
                                <?php $__currentLoopData = $vendedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($vendedor->id); ?>"
                                        <?php echo e($vendedor_id == $vendedor->id ? 'selected' : ''); ?>>
                                        <?php echo e($vendedor->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search mr-1"></i> Aplicar Filtros
                            </button>
                            <a href="<?php echo e(route('admin.reportes.vendedores')); ?>" class="btn btn-secondary">
                                <i class="fas fa-undo mr-1"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-left-primary">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">
                            <i class="fas fa-users text-primary mr-1"></i> Total Vendedores
                        </h6>
                        <h2 class="mb-0"><?php echo e(count($rendimientoVendedores)); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-left-info">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">
                            <i class="fas fa-box text-info mr-1"></i> Total Productos
                        </h6>
                        <h2 class="mb-0"><?php echo e(array_sum(array_column($rendimientoVendedores, 'total_productos'))); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-left-warning">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">
                            <i class="fas fa-chart-line text-warning mr-1"></i> Ventas Totales
                        </h6>
                        <h2 class="mb-0">Bs.
                            <?php echo e(number_format(array_sum(array_column($rendimientoVendedores, 'total_ventas')), 2)); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-trophy mr-2"></i>Rendimiento de Vendedores</h5>
                    </div>
                    <div class="card-body">
                        <?php if(count($rendimientoVendedores) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Vendedor</th>
                                            <th>Email</th>
                                            <th class="text-right">Total Productos</th>
                                            <th class="text-right">Animales</th>
                                            <th class="text-right">Maquinaria</th>
                                            <th class="text-right">Orgánicos</th>
                                            <th class="text-right">Ventas Totales</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $rendimientoVendedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $vendedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><strong><?php echo e($index + 1); ?></strong></td>
                                                <td><?php echo e($vendedor['nombre']); ?></td>
                                                <td><small class="text-muted"><?php echo e($vendedor['email']); ?></small></td>
                                                <td class="text-right"><?php echo e($vendedor['total_productos']); ?></td>
                                                <td class="text-right"><?php echo e($vendedor['total_ganados']); ?></td>
                                                <td class="text-right"><?php echo e($vendedor['total_maquinarias']); ?></td>
                                                <td class="text-right"><?php echo e($vendedor['total_organicos']); ?></td>
                                                <td class="text-right">
                                                    <strong>Bs. <?php echo e(number_format($vendedor['total_ventas'], 2)); ?></strong>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i>No hay datos de vendedores para el período
                                seleccionado.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/admin/reportes/vendedores.blade.php ENDPATH**/ ?>