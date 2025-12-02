<?php $__env->startSection('title','Datos Sanitarios'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">
                <i class="fas fa-syringe text-success"></i> Datos Sanitarios
            </h1>
            <p class="text-muted mb-0">Gestión de registros sanitarios de los animales</p>
        </div>
        <a href="<?php echo e(route('admin.datos-sanitarios.create')); ?>" class="btn btn-success btn-lg">
            <i class="fas fa-plus-circle"></i> Nuevo Registro
        </a>
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

    <?php if($items->count() > 0): ?>
        <!-- Estadísticas Rápidas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-0">Total Registros</h6>
                                <h3 class="mb-0"><?php echo e($items->count()); ?></h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-clipboard-list fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-0">Con Certificado</h6>
                                <h3 class="mb-0"><?php echo e($items->where('certificado_imagen', '!=', null)->count()); ?></h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-certificate fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-0">Fiebre Aftosa</h6>
                                <h3 class="mb-0"><?php echo e($items->where('vacunado_fiebre_aftosa', true)->count()); ?></h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-shield-alt fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-0">Antirrábica</h6>
                                <h3 class="mb-0"><?php echo e($items->where('vacunado_antirabica', true)->count()); ?></h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-shield-alt fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Registros -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-list"></i> Lista de Registros Sanitarios
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px;">ID</th>
                                <th>Animal</th>
                                <th>Dueño</th>
                                <th>Vacunaciones</th>
                                <th>Documentos</th>
                                <th>Guía Movimiento</th>
                                <th style="width: 120px;">Fecha</th>
                                <th style="width: 140px;" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <span class="badge badge-secondary badge-lg">#<?php echo e($item->id); ?></span>
                                </td>
                                <td>
                                    <?php if($item->ganado): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-cow text-primary mr-2"></i>
                                            <div>
                                                <strong class="d-block"><?php echo e($item->ganado->nombre); ?></strong>
                                                <?php if($item->ganado->tipoAnimal): ?>
                                                    <small class="text-muted">
                                                        <i class="fas fa-paw"></i> <?php echo e($item->ganado->tipoAnimal->nombre); ?>

                                                    </small>
                                                <?php endif; ?>
                                                <?php if(!$item->ganado->fecha_publicacion): ?>
                                                    <br><span class="badge badge-warning badge-sm mt-1">
                                                        <i class="fas fa-eye-slash"></i> Sin publicar
                                                    </span>
                                                <?php else: ?>
                                                    <br><span class="badge badge-success badge-sm mt-1">
                                                        <i class="fas fa-eye"></i> Publicado
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted"><i class="fas fa-info-circle"></i> Sin datos</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($item->nombre_dueño): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user text-info mr-2"></i>
                                            <div>
                                                <strong class="d-block"><?php echo e($item->nombre_dueño); ?></strong>
                                                <?php if($item->carnet_dueño_foto): ?>
                                                    <a href="<?php echo e(asset('storage/'.$item->carnet_dueño_foto)); ?>" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-info mt-1">
                                                        <i class="fas fa-id-card"></i> Ver Carnet
                                                    </a>
                                                <?php else: ?>
                                                    <small class="text-muted">Sin carnet</small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted"><i class="fas fa-info-circle"></i> Sin datos</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <?php if($item->vacunado_fiebre_aftosa): ?>
                                            <span class="badge badge-success mb-1">
                                                <i class="fas fa-check"></i> Fiebre Aftosa
                                            </span>
                                        <?php endif; ?>
                                        <?php if($item->vacunado_antirabica): ?>
                                            <span class="badge badge-success mb-1">
                                                <i class="fas fa-check"></i> Antirrábica
                                            </span>
                                        <?php endif; ?>
                                        <?php if($item->vacuna): ?>
                                            <small class="text-muted mt-1">
                                                <i class="fas fa-vial"></i> <?php echo e(Str::limit($item->vacuna, 30)); ?>

                                            </small>
                                        <?php endif; ?>
                                        <?php if(!$item->vacunado_fiebre_aftosa && !$item->vacunado_antirabica && !$item->vacuna): ?>
                                            <span class="text-muted"><i class="fas fa-info-circle"></i> Sin datos</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <?php if($item->certificado_imagen): ?>
                                            <a href="<?php echo e(asset('storage/'.$item->certificado_imagen)); ?>" 
                                               target="_blank" 
                                               class="btn btn-sm btn-info mb-1">
                                                <i class="fas fa-certificate"></i> Certificado
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted"><i class="fas fa-info-circle"></i> Sin datos</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if($item->marca_ganado || $item->senal_numero || $item->marca_ganado_foto): ?>
                                        <div class="small">
                                            <?php if($item->marca_ganado): ?>
                                                <div class="mb-1">
                                                    <i class="fas fa-tag text-primary"></i> 
                                                    <strong>Marca:</strong> <?php echo e($item->marca_ganado); ?>

                                                </div>
                                            <?php endif; ?>
                                            <?php if($item->senal_numero): ?>
                                                <div class="mb-1">
                                                    <i class="fas fa-hashtag text-primary"></i> 
                                                    <strong>Señal:</strong> <?php echo e($item->senal_numero); ?>

                                                </div>
                                            <?php endif; ?>
                                            <?php if($item->marca_ganado_foto): ?>
                                                <div class="mb-1">
                                                    <a href="<?php echo e(asset('storage/'.$item->marca_ganado_foto)); ?>" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-image"></i> Ver Foto Marca
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted"><i class="fas fa-info-circle"></i> Sin datos</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($item->fecha_aplicacion): ?>
                                        <div class="small">
                                            <i class="fas fa-calendar text-success"></i>
                                            <strong><?php echo e(\Carbon\Carbon::parse($item->fecha_aplicacion)->format('d/m/Y')); ?></strong>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted"><i class="fas fa-info-circle"></i> Sin datos</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.datos-sanitarios.edit', $item->id)); ?>"
                                           class="btn btn-sm btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.datos-sanitarios.destroy', $item->id)); ?>"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este registro sanitario?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger"
                                                    title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Estado Vacío -->
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-syringe fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No hay registros sanitarios</h4>
                <p class="text-muted mb-4">Comience creando su primer registro sanitario</p>
                <a href="<?php echo e(route('admin.datos-sanitarios.create')); ?>" class="btn btn-success btn-lg">
                    <i class="fas fa-plus-circle"></i> Crear Primer Registro
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.badge-lg {
    font-size: 1rem;
    padding: 0.5rem 0.75rem;
}
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
.thead-light th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/datos_sanitarios/index.blade.php ENDPATH**/ ?>