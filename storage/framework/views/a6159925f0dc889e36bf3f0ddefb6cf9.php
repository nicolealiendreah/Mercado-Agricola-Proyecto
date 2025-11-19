

<?php $__env->startSection('title', 'Solicitudes de Vendedor'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">
            <i class="fas fa-clipboard-list"></i> Solicitudes de Vendedor
        </h1>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
            <div class="card-tools">
                <form method="GET" action="<?php echo e(route('admin.solicitudes-vendedor.index')); ?>" class="d-inline">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <select name="estado" class="form-control" onchange="this.form.submit()">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" <?php echo e(request('estado') == 'pendiente' ? 'selected' : ''); ?>>Pendientes</option>
                            <option value="aprobada" <?php echo e(request('estado') == 'aprobada' ? 'selected' : ''); ?>>Aprobadas</option>
                            <option value="rechazada" <?php echo e(request('estado') == 'rechazada' ? 'selected' : ''); ?>>Rechazadas</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered table-striped table-hover mb-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Fecha Solicitud</th>
                        <th>Fecha Revisión</th>
                        <th>Documento</th>
                        <th style="width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $solicitudes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $solicitud): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($solicitud->id); ?></td>
                            <td>
                                <strong><?php echo e($solicitud->user->name); ?></strong>
                                <br>
                                <small class="text-muted">Rol: <?php echo e($solicitud->user->role_name ?? 'cliente'); ?></small>
                            </td>
                            <td><?php echo e($solicitud->user->email); ?></td>
                            <td><?php echo e($solicitud->telefono); ?></td>
                            <td>
                                <small><?php echo e(Str::limit($solicitud->direccion, 30)); ?></small>
                            </td>
                            <td>
                                <small><?php echo e(Str::limit($solicitud->motivo, 50)); ?></small>
                            </td>
                            <td>
                                <?php if($solicitud->estado == 'pendiente'): ?>
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i> Pendiente
                                    </span>
                                <?php elseif($solicitud->estado == 'aprobada'): ?>
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> Aprobada
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i> Rechazada
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small><?php echo e($solicitud->created_at->format('d/m/Y H:i')); ?></small>
                            </td>
                            <td>
                                <?php if($solicitud->fecha_revision_admin): ?>
                                    <small><?php echo e($solicitud->fecha_revision_admin->format('d/m/Y H:i')); ?></small>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($solicitud->archivo_documento): ?>
                                    <a href="<?php echo e(asset('storage/'.$solicitud->archivo_documento)); ?>" 
                                       target="_blank" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-file-download"></i> Ver
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Sin documento</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($solicitud->estado == 'pendiente'): ?>
                                    <form action="<?php echo e(route('admin.solicitudes-vendedor.aprobar', $solicitud->id)); ?>" 
                                          method="POST" class="d-inline-block">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="btn btn-sm btn-success mb-1"
                                                onclick="return confirm('¿Aprobar esta solicitud? El usuario <?php echo e($solicitud->user->name ?? 'N/A'); ?> obtendrá rol de vendedor.')">
                                            <i class="fas fa-check"></i> Aprobar
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('admin.solicitudes-vendedor.rechazar', $solicitud->id)); ?>" 
                                          method="POST" class="d-inline-block">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger mb-1"
                                                onclick="return confirm('¿Estás seguro de rechazar la solicitud de <?php echo e($solicitud->user->name ?? 'N/A'); ?>?')">
                                            <i class="fas fa-times"></i> Rechazar
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Procesada</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                <p>No hay solicitudes registradas.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <?php echo e($solicitudes->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/solicitudes_vendedor/index.blade.php ENDPATH**/ ?>