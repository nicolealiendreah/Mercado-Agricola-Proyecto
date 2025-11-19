<?php $__env->startSection('title', 'Detalle de Ganado'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Detalle del Ganado</h1>
        <a href="<?php echo e(route('ganados.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <?php if($ganado->imagen): ?>
                        <img src="<?php echo e(asset('storage/'.$ganado->imagen)); ?>" 
                             alt="Imagen de <?php echo e($ganado->nombre); ?>" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 300px; max-width: 100%; cursor: pointer; object-fit: cover;"
                             onclick="window.open('<?php echo e(asset('storage/'.$ganado->imagen)); ?>', '_blank')"
                             title="Click para ver imagen completa">
                        <p class="text-muted mt-2">
                            <i class="fas fa-image"></i> Click en la imagen para ampliar
                        </p>
                    <?php else: ?>
                        <div class="text-muted p-5 border rounded">
                            <i class="fas fa-image fa-3x mb-2"></i>
                            <p>Sin imagen disponible</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td><?php echo e($ganado->id); ?></td>
                        </tr>
                        <tr>
                            <th>Nombre</th>
                            <td><?php echo e($ganado->nombre); ?></td>
                        </tr>
                        <tr>
                            <th>Tipo de Animal</th>
                            <td><?php echo e($ganado->tipoAnimal->nombre ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <th>Raza</th>
                            <td><?php echo e($ganado->raza->nombre ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <th>Edad (meses)</th>
                            <td><?php echo e($ganado->edad ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <th>Tipo de Peso</th>
                            <td><?php echo e($ganado->tipoPeso->nombre ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <th>Sexo</th>
                            <td><?php echo e($ganado->sexo ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <th>Categoría</th>
                            <td>
                                <span class="badge badge-success"><?php echo e($ganado->categoria->nombre ?? '-'); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Ubicación</th>
                            <td><?php echo e($ganado->ubicacion ?? 'Sin ubicación'); ?></td>
                        </tr>
                        <?php if($ganado->latitud && $ganado->longitud): ?>
                        <tr>
                            <th>Coordenadas</th>
                            <td>
                                <small class="text-muted">
                                    Lat: <?php echo e($ganado->latitud); ?>, Lng: <?php echo e($ganado->longitud); ?>

                                </small>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Descripción</th>
                            <td><?php echo e($ganado->descripcion ?? '—'); ?></td>
                        </tr>
                        <tr>
                            <th>Precio (Bs)</th>
                            <td>
                                <?php if($ganado->precio): ?>
                                    <span class="h5 text-success font-weight-bold">Bs <?php echo e(number_format($ganado->precio, 2)); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">Precio a consultar</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Stock (Cantidad)</th>
                            <td>
                                <span class="badge <?php echo e(($ganado->stock ?? 0) > 0 ? 'badge-success' : 'badge-danger'); ?> badge-lg">
                                    <?php echo e($ganado->stock ?? 0); ?>

                                </span>
                            </td>
                        </tr>
                        <?php if($ganado->datoSanitario): ?>
                        <tr>
                            <th>Datos Sanitarios</th>
                            <td>
                                <small class="text-muted">
                                    <?php if($ganado->datoSanitario->vacuna): ?>
                                        <i class="fas fa-syringe"></i> Vacuna: <?php echo e($ganado->datoSanitario->vacuna); ?>

                                    <?php endif; ?>
                                </small>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if($ganado->fecha_publicacion): ?>
                        <tr>
                            <th>Fecha de Publicación</th>
                            <td><?php echo e(\Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y')); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Fecha de Registro</th>
                            <td><?php echo e($ganado->created_at->format('d/m/Y H:i')); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/ganados/show.blade.php ENDPATH**/ ?>