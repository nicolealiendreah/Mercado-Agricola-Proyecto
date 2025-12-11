

<?php $__env->startSection('title', 'Reporte de Productos con Bajo Movimiento'); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-header">
        <div class="container-fluid">
            <h4 class="mb-0">
                <i class="fas fa-box-open"></i> Reporte de Productos con Bajo Movimiento
            </h4>
            <p class="text-muted">
                Identificación de productos con pocas o ninguna venta en el periodo seleccionado.
            </p>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter"></i> Filtros de Búsqueda</h3>
                </div>
                <div class="card-body">
                    <form method="get">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Desde</label>
                                <input type="date" name="desde" value="<?php echo e($desde); ?>" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Hasta</label>
                                <input type="date" name="hasta" value="<?php echo e($hasta); ?>" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Categoría</label>
                                <select name="categoria" class="form-control">
                                    <option value="todas" <?php echo e($categoria == 'todas' ? 'selected' : ''); ?>>Todas</option>
                                    <option value="Animales" <?php echo e($categoria == 'Animales' ? 'selected' : ''); ?>>Animales
                                    </option>
                                    <option value="Maquinaria" <?php echo e($categoria == 'Maquinaria' ? 'selected' : ''); ?>>Maquinaria
                                    </option>
                                    <option value="Orgánicos" <?php echo e($categoria == 'Orgánicos' ? 'selected' : ''); ?>>Orgánicos
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Máx. ventas para considerar lento</label>
                                <input type="number" min="0" name="min_ventas" value="<?php echo e($minVentas); ?>"
                                    class="form-control">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-search"></i> Aplicar Filtros
                        </button>
                        <a href="<?php echo e(route('admin.productos_lentos')); ?>" class="btn btn-secondary">
                            <i class="fas fa-eraser"></i> Limpiar
                        </a>

                        <div class="float-right">
                            <a href="<?php echo e(route('admin.productos_lentos.export', ['tipo' => 'pdf'] + request()->all())); ?>"
                                class="btn btn-danger">
                                <i class="far fa-file-pdf"></i> Exportar PDF
                            </a>
                            <a href="<?php echo e(route('admin.productos_lentos.export', ['tipo' => 'excel'] + request()->all())); ?>"
                                class="btn btn-success">
                                <i class="far fa-file-excel"></i> Exportar Excel
                            </a>

                        </div>
                    </form>
                </div>
            </div>

            
            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo e($totalProductos); ?></h3>
                            <p>Productos con bajo movimiento</p>
                        </div>
                        <div class="icon"><i class="fas fa-boxes"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo e($sinVentas); ?></h3>
                            <p>Sin ninguna venta</p>
                        </div>
                        <div class="icon"><i class="fas fa-times-circle"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo e($conPocasVentas); ?></h3>
                            <p>Con pocas ventas (1 a <?php echo e($minVentas); ?>)</p>
                        </div>
                        <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                </div>
            </div>

            
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Detalle de productos con bajo movimiento
                    </h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Categoría</th>
                                <th>Producto</th>
                                <th>Vendedor</th>
                                <th>Precio</th>
                                <th>Total vendido</th>
                                <th>Ingresos</th>
                                <th>Última venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($p->categoria); ?></td>
                                    <td><?php echo e($p->producto); ?></td>
                                    <td><?php echo e($p->vendedor); ?></td>
                                    <td>Bs. <?php echo e(number_format($p->precio, 2)); ?></td>
                                    <td><?php echo e($p->total_vendido); ?></td>
                                    <td>Bs. <?php echo e(number_format($p->ingresos, 2)); ?></td>
                                    <td><?php echo e($p->ultima_venta ? \Carbon\Carbon::parse($p->ultima_venta)->format('d/m/Y') : 'Sin ventas'); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        No se encontraron productos con bajo movimiento para los filtros seleccionados.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/admin/reportes/productos_lentos.blade.php ENDPATH**/ ?>