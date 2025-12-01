<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">Nuevo Tipo de Animal</div>

    <div class="card-body">
            <form action="<?php echo e(route('admin.tipo_animals.store')); ?>" method="post">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea class="form-control" name="descripcion"></textarea>
            </div>

            <button class="btn btn-success">Guardar</button>
            <a href="<?php echo e(route('admin.tipo_animals.index')); ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proy2\ProyectoAgricolaLocal\resources\views/tipo_animals/create.blade.php ENDPATH**/ ?>