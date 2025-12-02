<?php $__env->startSection('title', 'Solicitudes de Vendedor'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .requests-card {
        border-radius: 15px;
        overflow: hidden;
        border: 0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }

    .requests-header {
        background: var(--agro);
        color: #fff;
        padding: 1.5rem 1.75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .requests-header h2 {
        font-size: 1.4rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .requests-header h2 i {
        font-size: 1.5rem;
    }

    .requests-body {
        background: #fff;
        padding: 1.5rem 1.75rem 1.25rem;
    }

    .requests-filters .input-group,
    .requests-filters select {
        border-radius: 999px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    .requests-filters input {
        border: 0;
        box-shadow: none !important;
    }

    .requests-filters .btn-filter {
        border: 0;
        background: var(--agro);
        color: #fff;
    }

    .requests-filters .btn-filter:hover {
        background: var(--agro-700);
    }

    .table-requests thead th {
        border-top: 0;
        font-size: .85rem;
        text-transform: uppercase;
        letter-spacing: .03em;
        color: #6c757d;
        background-color: #f8f9fa;
        white-space: nowrap;
    }

    .table-requests tbody tr {
        transition: background-color .2s ease, transform .1s ease;
    }

    .table-requests tbody tr:hover {
        background-color: #fdfdfd;
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(0,0,0,0.04);
    }

    .table-requests td {
        vertical-align: middle;
        font-size: .9rem;
    }

    .btn-action {
        border-radius: 999px;
        padding: .25rem .6rem;
        font-size: .8rem;
    }

    .requests-footer {
        background: #fff;
        border-top: 1px solid #e9ecef;
        padding: .75rem 1.75rem;
    }

    @media (max-width: 992px) {
        .requests-header {
            flex-direction: column;
            align-items: flex-start;
            gap: .75rem;
        }
    }
</style>

<div class="container-fluid">
    <div class="requests-card card">

        
        <div class="requests-header">
            <h2>
                <i class="fas fa-clipboard-list"></i>
                Solicitudes de Vendedor
            </h2>
        </div>

        
        <div class="requests-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            
            <div class="row align-items-center mb-3 requests-filters">
                <div class="col-lg-6 mb-2 mb-lg-0">
                    
                    <form method="GET" action="<?php echo e(route('admin.solicitudes-vendedor.index')); ?>">
                        <div class="input-group input-group-sm">
                            <input
                                type="text"
                                name="q"
                                class="form-control"
                                placeholder="Buscar por usuario, email, motivo..."
                                value="<?php echo e(request('q')); ?>"
                            >
                            <div class="input-group-append">
                                <button class="btn btn-filter" type="submit">
                                    <i class="fas fa-search mr-1"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-3 mb-2 mb-lg-0">
                    
                    <form method="GET" action="<?php echo e(route('admin.solicitudes-vendedor.index')); ?>">
                        <div class="input-group input-group-sm">
                            
                            <input type="hidden" name="q" value="<?php echo e(request('q')); ?>">
                            <select name="estado" class="form-control" onchange="this.form.submit()">
                                <option value="">Todos los estados</option>
                                <option value="pendiente" <?php echo e(request('estado') == 'pendiente' ? 'selected' : ''); ?>>Pendientes</option>
                                <option value="aprobada" <?php echo e(request('estado') == 'aprobada' ? 'selected' : ''); ?>>Aprobadas</option>
                                <option value="rechazada" <?php echo e(request('estado') == 'rechazada' ? 'selected' : ''); ?>>Rechazadas</option>
                            </select>
                        </div>
                    </form>
                </div>

                <div class="col-lg-3 text-lg-right text-muted small">
                    Panel de gestión de solicitudes de vendedor
                </div>
            </div>

            
            <div class="table-responsive">
                <table class="table table-hover table-requests mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                            <th>Fecha solicitud</th>
                            <th>Fecha revisión</th>
                            <th>Documento</th>
                            <th class="text-right" style="width: 220px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $solicitudes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $solicitud): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($solicitud->id); ?></td>
                                <td>
                                    <strong><?php echo e($solicitud->user->name); ?></strong><br>
                                    <small class="text-muted">
                                        Rol: <?php echo e($solicitud->user->role_name ?? 'cliente'); ?>

                                    </small>
                                </td>
                                <td><?php echo e($solicitud->user->email); ?></td>
                                <td><?php echo e($solicitud->telefono); ?></td>
                                <td><small><?php echo e(Str::limit($solicitud->direccion, 40)); ?></small></td>
                                <td><small><?php echo e(Str::limit($solicitud->motivo, 60)); ?></small></td>
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
                                <td><small><?php echo e($solicitud->created_at->format('d/m/Y H:i')); ?></small></td>
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
                                           class="btn btn-info btn-action">
                                            <i class="fas fa-file-download"></i> Ver
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Sin documento</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <?php if($solicitud->estado == 'pendiente'): ?>
                                        <form action="<?php echo e(route('admin.solicitudes-vendedor.aprobar', $solicitud->id)); ?>"
                                              method="POST" class="d-inline-block">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit"
                                                    class="btn btn-success btn-action mb-1"
                                                    onclick="return confirm('¿Aprobar esta solicitud? El usuario <?php echo e($solicitud->user->name ?? 'N/A'); ?> obtendrá rol de vendedor.')">
                                                <i class="fas fa-check"></i> Aprobar
                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('admin.solicitudes-vendedor.rechazar', $solicitud->id)); ?>"
                                              method="POST" class="d-inline-block">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit"
                                                    class="btn btn-danger btn-action mb-1"
                                                    onclick="return confirm('¿Rechazar la solicitud de <?php echo e($solicitud->user->name ?? 'N/A'); ?>?')">
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
                                    <p class="mb-0">No hay solicitudes registradas.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="requests-footer d-flex justify-content-between align-items-center">
            <span class="text-muted small">
                Mostrando <?php echo e($solicitudes->count()); ?> de <?php echo e($solicitudes->total()); ?> solicitudes
            </span>
            <div class="mb-0">
                <?php echo e($solicitudes->links()); ?>

            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/solicitudes_vendedor/index.blade.php ENDPATH**/ ?>