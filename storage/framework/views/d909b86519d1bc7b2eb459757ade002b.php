<?php $__env->startSection('title', 'Nueva Raza'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-3">Nueva Raza</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?php echo e(route('admin.razas.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Tipo de Animal</label>
                    <select name="tipo_animal_id" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($t->id); ?>"><?php echo e($t->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Descripción</label>
                    <textarea name="descripcion" class="form-control"></textarea>
                </div>

                <button class="btn btn-success">Guardar</button>
                <a href="<?php echo e(route('admin.razas.index')); ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proy2\ProyectoAgricolaLocal\resources\views/razas/create.blade.php ENDPATH**/ ?>