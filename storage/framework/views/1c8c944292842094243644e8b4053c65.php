<?php $__env->startSection('title', 'Gestión de Ganado'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Lista de Ganado</h1>
        <?php if(auth()->check() && (auth()->user()->isVendedor() || auth()->user()->isAdmin())): ?>
            <a href="<?php echo e(route('ganados.create')); ?>" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Nuevo Registro
            </a>
        <?php endif; ?>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-bordered table-striped mb-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo de Animal</th>
                        <th>Raza</th>
                        <th>Edad</th>
                        <th>Tipo de Peso</th>
                        <th>Sexo</th>
                        <th>Categoría</th>
                        <th>Ubicación</th>
                        <th>Fecha Publicación</th>
                        <th>Datos Sanitarios</th>
                        <th>Precio (Bs)</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                        <th style="width:150px;">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $ganados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ganado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($ganado->id); ?></td>
                            <td><?php echo e($ganado->nombre); ?></td>

                            <td><?php echo e($ganado->tipoAnimal->nombre ?? '—'); ?></td>
                            <td><?php echo e($ganado->raza->nombre ?? '—'); ?></td>

                            <td><?php echo e($ganado->edad ?? '-'); ?> meses</td>

                            <td><?php echo e($ganado->tipoPeso->nombre ?? '-'); ?></td>

                            <td><?php echo e($ganado->sexo ?? '-'); ?></td>

                            <td><?php echo e($ganado->categoria->nombre ?? '-'); ?></td>

                            <td><?php echo e($ganado->ubicacion ?? 'Sin ubicación'); ?></td>

                            <td>
                                <?php echo e($ganado->fecha_publicacion
                                    ? \Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y')
                                    : 'No publicada'); ?>

                            </td>

                            <td>
                               <?php echo e($ganado->datoSanitario->vacuna ?? 'Sin registro'); ?>


                            </td>

                            <td><?php echo e($ganado->precio ? number_format($ganado->precio, 2) : '-'); ?></td>

                            <td>
                                <span class="badge <?php echo e(($ganado->stock ?? 0) > 0 ? 'badge-success' : 'badge-danger'); ?>">
                                    <?php echo e($ganado->stock ?? 0); ?>

                                </span>
                            </td>

                            <td>
                                <?php if($ganado->imagen): ?>
                                    <img src="<?php echo e(asset('storage/'.$ganado->imagen)); ?>" 
                                         alt="<?php echo e($ganado->nombre); ?>" 
                                         class="img-thumbnail" 
                                         style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                         onclick="window.open('<?php echo e(asset('storage/'.$ganado->imagen)); ?>', '_blank')"
                                         title="Click para ver imagen completa">
                                <?php else: ?>
                                    <span class="text-muted">
                                        <i class="fas fa-image"></i> Sin imagen
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if(auth()->check() && (auth()->user()->isVendedor() || auth()->user()->isAdmin())): ?>
                                    
                                    <?php if(auth()->user()->isAdmin() || $ganado->user_id == auth()->id()): ?>
                                        <a href="<?php echo e(route('ganados.edit', $ganado->id)); ?>"
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="<?php echo e(route('ganados.destroy', $ganado->id)); ?>"
                                              method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>

                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Eliminar este registro?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('ganados.show', $ganado->id)); ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?php echo e(route('ganados.show', $ganado->id)); ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="16" class="text-center text-muted">
                                No hay registros de ganado.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>

        </div>

        <div class="card-footer">
            <?php echo e($ganados->links()); ?>

        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/ganados/index.blade.php ENDPATH**/ ?>