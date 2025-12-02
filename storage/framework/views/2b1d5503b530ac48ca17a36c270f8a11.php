<?php $__env->startSection('title','Maquinarias'); ?>
<?php $__env->startSection('page_title','Maquinarias'); ?>

<?php $__env->startSection('content'); ?>


<div class="mb-3">
    <div class="bg-agro rounded-lg p-3 d-flex align-items-center text-white">
        <div>
            <h3 class="mb-0">Listado de Maquinarias</h3>
            <small><?php echo e($maquinarias->total()); ?> maquinaria(s) registrada(s)</small>
        </div>

        <div class="ml-auto d-flex">
            <form method="get" class="form-inline mr-2">
                <div class="input-group input-group-sm">
                    <input type="text" name="q" value="<?php echo e($q ?? ''); ?>" class="form-control" placeholder="Buscar...">
                    <div class="input-group-append">
                        <button class="btn btn-light">Buscar</button>
                    </div>
                </div>
            </form>

            <?php if(auth()->check() && (auth()->user()->isVendedor() || auth()->user()->isAdmin())): ?>
                <a href="<?php echo e(route('maquinarias.create')); ?>" class="btn btn-outline-light btn-sm mr-2">
                    <i class="fas fa-plus-circle"></i> Nuevo Registro
                </a>
            <?php endif; ?>

        </div>
    </div>
</div>


<?php if(session('ok')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> <?php echo e(session('ok')); ?>

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


<div class="row">
    <?php $__empty_1 = true; $__currentLoopData = $maquinarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100 shadow-sm project-card">

                <div class="bg-light d-flex align-items-center justify-content-center"
                     style="height: 230px;">
                    <?php if($m->imagenes && $m->imagenes->count() > 0): ?>
                        <div class="bg-light d-flex align-items-center justify-content-center"
     style="height: 230px;">
    <img
        src="<?php echo e($m->imagenes->count() ? asset('storage/'.$m->imagenes->first()->ruta) : asset('img/maquinaria-placeholder.jpg')); ?>"
        style="max-height: 100%; max-width: 100%; object-fit: contain;"
        alt="<?php echo e($m->nombre); ?>"
    >
</div>

                    <?php else: ?>
                        <div class="text-center text-muted">
                            <i class="fas fa-tractor fa-3x mb-2"></i>
                            <div>Sin imagen</div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card-body d-flex flex-column">
                    <h5 class="mb-1">
                        <a href="<?php echo e(route('maquinarias.show', $m)); ?>" class="text-dark">
                            <?php echo e($m->nombre); ?>

                        </a>
                    </h5>

                    <div class="mb-2">
                        <?php if($m->tipoMaquinaria): ?>
                            <span class="badge badge-warning mr-1">
                                <i class="fas fa-cog"></i>
                                <?php echo e($m->tipoMaquinaria->nombre); ?>

                            </span>
                        <?php endif; ?>
                        <?php if($m->marcaMaquinaria): ?>
                            <span class="badge badge-info">
                                <i class="fas fa-tag"></i>
                                <?php echo e($m->marcaMaquinaria->nombre); ?>

                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="mb-2">
                        <?php if($m->estadoMaquinaria): ?>
                            <?php $estado = strtolower($m->estadoMaquinaria->nombre); ?>
                            <span class="badge <?php echo e($estado === 'disponible' ? 'badge-success' : 'badge-secondary'); ?>">
                                <?php echo e($m->estadoMaquinaria->nombre); ?>

                            </span>
                        <?php else: ?>
                            <span class="badge badge-secondary">Sin estado</span>
                        <?php endif; ?>
                    </div>

                    <div class="small text-muted mb-2">
                        <i class="far fa-calendar-alt"></i>
                        <?php echo e(optional($m->created_at)->format('d/m/Y')); ?>

                        <?php if($m->ubicacion): ?>
                            &nbsp; • &nbsp;
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <?php echo e(\Illuminate\Support\Str::limit($m->ubicacion, 40)); ?>

                        <?php endif; ?>
                    </div>

                    <?php if($m->descripcion): ?>
                        <p class="text-muted small mb-2">
                            <?php echo e(\Illuminate\Support\Str::limit($m->descripcion, 100)); ?>

                        </p>
                    <?php endif; ?>

                    <?php if($m->precio_dia): ?>
                        <div class="mt-auto">
                            <div class="font-weight-bold mb-1">
                                Bs <?php echo e(number_format($m->precio_dia, 2)); ?>

                                <span class="text-muted">/ día</span>
                            </div>

                            <div class="progress" style="height: 18px;">
                                <div class="progress-bar bg-success"
                                     role="progressbar"
                                     style="width: 100%;">
                                    Precio por día
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card-footer bg-white">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('maquinarias.show', $m)); ?>"
                           class="btn btn-outline-success btn-block mb-1">
                            <i class="fas fa-eye"></i> Ver
                        </a>

                        <?php if(auth()->check() && (auth()->user()->isVendedor() || auth()->user()->isAdmin())): ?>
                            <?php if(auth()->user()->isAdmin() || $m->user_id == auth()->id()): ?>
                                <a href="<?php echo e(route('maquinarias.edit', $m)); ?>"
                                   class="btn btn-outline-primary btn-block mb-1">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <form action="<?php echo e(route('maquinarias.destroy', $m)); ?>"
                                      method="post"
                                      onsubmit="return confirm('¿Eliminar esta maquinaria?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-outline-danger btn-block">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
            <div class="text-center text-muted py-5">
                No hay maquinarias registradas.
            </div>
        </div>
    <?php endif; ?>
</div>


<div class="mt-3">
    <?php echo e($maquinarias->appends(['q' => $q ?? null])->links()); ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/maquinarias/index.blade.php ENDPATH**/ ?>