<?php $__env->startSection('content'); ?>
<div class="x_panel">
    <div class="x_title">
        <h2>Editar Categoría</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <form action="<?php echo e(route('admin.categorias.update', $categoria)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre"
                       value="<?php echo e($categoria->nombre); ?>" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" name="descripcion" rows="3">
                    <?php echo e($categoria->descripcion); ?>

                </textarea>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="<?php echo e(route('admin.categorias.index')); ?>" class="btn btn-secondary">Cancelar</a>

        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.gentelella', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proy2\ProyectoAgricolaLocal\resources\views/categorias/edit.blade.php ENDPATH**/ ?>