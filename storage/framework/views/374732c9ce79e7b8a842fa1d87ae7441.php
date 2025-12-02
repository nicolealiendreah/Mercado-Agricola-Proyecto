<?php $__env->startSection('title','Orgánicos'); ?>
<?php $__env->startSection('page_title','Orgánicos'); ?>

<?php $__env->startSection('content'); ?>


<div class="mb-3">
    <div class="bg-agro rounded-lg p-3 d-flex align-items-center text-white">
        <div>
            <h3 class="mb-0">Listado de Orgánicos</h3>
            <small><?php echo e($organicos->total()); ?> producto(s) registrado(s)</small>
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
                <a href="<?php echo e(route('organicos.create')); ?>" class="btn btn-outline-light btn-sm mr-2">
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



<?php if($organicos->count()): ?>
    <div class="row">
        <?php $__currentLoopData = $organicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">

                <div class="card shadow-sm border-0 h-100">

                    
                    <?php
                        $img = optional($o->imagenes->first())->ruta ?? null;
                    ?>
                    <div class="w-100 d-flex justify-content-center align-items-center" style="height: 200px; background:#fff;">
    <img
        src="<?php echo e($img ? asset('storage/'.$img) : asset('img/organico-placeholder.jpg')); ?>"
        style="max-height: 100%; max-width: 100%; object-fit: contain;"
        alt="<?php echo e($o->nombre); ?>"
    >
</div>


                    <div class="card-body d-flex flex-column">

                        
                        <h5 class="card-title mb-1">
                            <a href="<?php echo e(route('organicos.show', $o)); ?>" class="text-dark">
                                <?php echo e($o->nombre); ?>

                            </a>
                        </h5>

                        
                        <div class="mb-2">
                            <?php if($o->categoria): ?>
                                <span class="badge badge-agro">
                                    <?php echo e($o->categoria->nombre); ?>

                                </span>
                            <?php endif; ?>

                            <?php if($o->unidad_medida): ?>
                                <span class="badge badge-secondary">
                                    <?php echo e($o->unidad_medida); ?>

                                </span>
                            <?php endif; ?>
                        </div>

                        
                        <?php if($o->fecha_cosecha): ?>
                            <small class="text-muted d-block mb-2">
                                <i class="fas fa-calendar-alt"></i>
                                <?php echo e(\Carbon\Carbon::parse($o->fecha_cosecha)->format('d/m/Y')); ?>

                            </small>
                        <?php endif; ?>

                        
                        <?php if($o->descripcion): ?>
                            <p class="text-muted mb-2" style="font-size: 0.85rem;">
                                <?php echo e(Str::limit($o->descripcion, 70)); ?>

                            </p>
                        <?php endif; ?>

                        
                        <div class="text-agro font-weight-bold mb-2" style="font-size: 1.2rem;">
                            Bs <?php echo e(number_format($o->precio, 2)); ?>

                        </div>

                        
                        <span class="badge badge-agro mb-3">
                            <?php echo e($o->stock); ?> unidades
                        </span>

                        
                        <div class="mt-auto">
                            <a href="<?php echo e(route('organicos.show', $o)); ?>" class="btn btn-sm btn-outline-agro w-100 mb-1">
                                <i class="fas fa-eye"></i> Ver
                            </a>

                            <?php if(auth()->check() && (auth()->user()->isAdmin() || $o->user_id == auth()->id())): ?>
                                <a href="<?php echo e(route('organicos.edit', $o)); ?>" class="btn btn-sm btn-outline-primary w-100 mb-1">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <form action="<?php echo e(route('organicos.destroy', $o)); ?>" method="post">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-outline-danger w-100"
                                            onclick="return confirm('¿Eliminar este orgánico?')">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-3">
        <?php echo e($organicos->appends(['q' => $q ?? null])->links()); ?>

    </div>

<?php else: ?>
    <div class="card">
        <div class="card-body text-center text-muted">No hay productos orgánicos registrados.</div>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/organicos/index.blade.php ENDPATH**/ ?>