<?php echo csrf_field(); ?>
<div class="form-group"><label>Nombre *</label>
  <input name="nombre" class="form-control" value="<?php echo e(old('nombre', $maquinaria->nombre ?? '')); ?>" required>
</div>
<div class="form-group">
    <label>Categoría *</label>
    <select name="categoria_id" class="form-control" required>
        <option value="">Seleccione una categoría</option>
        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($categoria->id); ?>"
                <?php echo e(old('categoria_id', $maquinaria->categoria_id ?? '') == $categoria->id ? 'selected' : ''); ?>>
                <?php echo e($categoria->nombre); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="form-group">
    <label>Tipo de Maquinaria *</label>
    <select name="tipo_maquinaria_id" class="form-control" required>
        <option value="">Seleccione un tipo de maquinaria</option>
        <?php $__currentLoopData = $tipo_maquinarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($tipo->id); ?>"
                <?php echo e(old('tipo_maquinaria_id', $maquinaria->tipo_maquinaria_id ?? '') == $tipo->id ? 'selected' : ''); ?>>
                <?php echo e($tipo->nombre); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
<div class="form-group">
    <label>Marca de Maquinaria *</label>
    <select name="marca_maquinaria_id" class="form-control" required>
        <option value="">Seleccione una marca de maquinaria</option>
        <?php $__currentLoopData = $marcas_maquinarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($marca->id); ?>"
                <?php echo e(old('marca_maquinaria_id', $maquinaria->marca_maquinaria_id ?? '') == $marca->id ? 'selected' : ''); ?>>
                <?php echo e($marca->nombre); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
<div class="form-group"><label>Modelo</label>
  <input name="modelo" class="form-control" value="<?php echo e(old('modelo', $maquinaria->modelo ?? '')); ?>">
</div>
<div class="form-group"><label>Precio por día *</label>
  <input type="number" step="0.01" name="precio_dia" class="form-control" value="<?php echo e(old('precio_dia', $maquinaria->precio_dia ?? 0)); ?>" required>
</div>
<div class="form-group"><label>Estado *</label>
  <select name="estado" class="form-control" required>
    <?php $__currentLoopData = ['disponible','en_mantenimiento','dado_baja']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($e); ?>" <?php if(old('estado', $maquinaria->estado ?? '')==$e): echo 'selected'; endif; ?>><?php echo e($e); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
</div>
<div class="form-group"><label>Descripción</label>
  <textarea name="descripcion" class="form-control" rows="3"><?php echo e(old('descripcion', $maquinaria->descripcion ?? '')); ?></textarea>
</div>
<button class="btn btn-success">Guardar</button>
<a href="<?php echo e(route('maquinarias.index')); ?>" class="btn btn-secondary">Volver</a>
<?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/maquinarias/_form.blade.php ENDPATH**/ ?>