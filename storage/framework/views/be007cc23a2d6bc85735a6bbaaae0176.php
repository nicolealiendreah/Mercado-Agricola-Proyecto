<?php $__env->startSection('content'); ?>
<div class="x_panel">
    <div class="x_title">
        <h2>Nueva Categoría</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <form action="<?php echo e(route('admin.categorias.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="<?php echo e(route('admin.categorias.index')); ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.gentelella', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proy2\ProyectoAgricolaLocal\resources\views/categorias/create.blade.php ENDPATH**/ ?>