<?php $__env->startSection('title','Nuevo Registro Sanitario'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">
                <i class="fas fa-syringe text-success"></i> Nuevo Registro Sanitario
            </h1>
            <p class="text-muted mb-0">Complete el formulario para registrar los datos sanitarios del animal</p>
        </div>
        <a href="<?php echo e(route('admin.datos-sanitarios.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
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

    <div class="alert alert-info border-left-info">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-2x mr-3"></i>
            <div>
                <strong>Nota importante:</strong> Puede agregar datos sanitarios a cualquier animal registrado en el sistema, 
                independientemente de si tiene fecha de publicación o no. Los animales sin publicar aparecerán marcados con 
                <span class="badge badge-warning">[Sin publicar]</span>.
            </div>
        </div>
    </div>

    <form action="<?php echo e(route('admin.datos-sanitarios.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <!-- Sección: Información del Animal -->
        <div class="card shadow-sm mb-4 border-left-primary">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-cow text-primary"></i> Información del Animal
                </h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="font-weight-bold">
                        <i class="fas fa-paw text-primary"></i> Animal <span class="text-danger">*</span>
                    </label>
                    <select name="ganado_id" class="form-control form-control-lg" required>
                        <option value="">Seleccione un animal...</option>
                        <?php $__currentLoopData = $ganados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($g->id); ?>">
                            <?php echo e($g->nombre); ?>

                            <?php if($g->tipoAnimal): ?>
                                - <?php echo e($g->tipoAnimal->nombre); ?>

                            <?php endif; ?>
                            <?php if($g->raza): ?>
                                (<?php echo e($g->raza->nombre); ?>)
                            <?php endif; ?>
                            <?php if($g->edad): ?>
                                - <?php echo e($g->edad); ?> meses
                            <?php endif; ?>
                            <?php if(!$g->fecha_publicacion): ?>
                                [Sin publicar]
                            <?php endif; ?>
                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle"></i> Puede seleccionar cualquier animal registrado, incluso si no tiene fecha de publicación.
                    </small>
                </div>
            </div>
        </div>

        <!-- Sección: Vacunaciones -->
        <div class="card shadow-sm mb-4 border-left-success">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-syringe text-success"></i> Vacunaciones
                </h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="font-weight-bold">
                        <i class="fas fa-vial text-success"></i> Otras Vacunas
                    </label>
                    <input type="text" name="vacuna" class="form-control" placeholder="Ej: Triple, Brucelosis, etc. (opcional)">
                    <small class="form-text text-muted">Especifique otras vacunas además de las marcadas abajo</small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold d-block mb-3">
                        <i class="fas fa-check-double text-success"></i> Vacunaciones Específicas
                    </label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox custom-control-lg mb-3">
                                <input type="checkbox" class="custom-control-input" name="vacunado_fiebre_aftosa" id="vacunado_fiebre_aftosa" value="1">
                                <label class="custom-control-label" for="vacunado_fiebre_aftosa">
                                    <i class="fas fa-shield-alt text-success"></i> 
                                    <strong>Vacunado de Libre de Fiebre Aftosa</strong>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox custom-control-lg mb-3">
                                <input type="checkbox" class="custom-control-input" name="vacunado_antirabica" id="vacunado_antirabica" value="1">
                                <label class="custom-control-label" for="vacunado_antirabica">
                                    <i class="fas fa-shield-alt text-success"></i> 
                                    <strong>Vacunado de Antirrábica</strong>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: Tratamientos y Medicamentos -->
        <div class="card shadow-sm mb-4 border-left-info">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-pills text-info"></i> Tratamientos y Medicamentos
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-stethoscope text-info"></i> Tratamiento
                            </label>
                            <input type="text" name="tratamiento" class="form-control" placeholder="Tipo de tratamiento aplicado">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-capsules text-info"></i> Medicamento
                            </label>
                            <input type="text" name="medicamento" class="form-control" placeholder="Nombre del medicamento">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-calendar-check text-info"></i> Fecha de Aplicación
                            </label>
                            <input type="date" name="fecha_aplicacion" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-calendar-alt text-info"></i> Próxima Fecha
                            </label>
                            <input type="date" name="proxima_fecha" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">
                        <i class="fas fa-user-md text-info"></i> Veterinario
                    </label>
                    <input type="text" name="veterinario" class="form-control" placeholder="Nombre del veterinario responsable">
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">
                        <i class="fas fa-comment-alt text-info"></i> Observaciones
                    </label>
                    <textarea name="observaciones" class="form-control" rows="4" placeholder="Notas adicionales sobre el tratamiento o estado del animal"></textarea>
                </div>
            </div>
        </div>

        <!-- Sección: Certificado SENASAG -->
        <div class="card shadow-sm mb-4 border-left-warning">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-certificate text-warning"></i> Certificado de Vacunación SENASAG
                </h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="font-weight-bold">
                        <i class="fas fa-file-image text-warning"></i> Imagen del Certificado
                    </label>
                    <div class="custom-file">
                        <input type="file" name="certificado_imagen" class="custom-file-input" id="certificado_imagen" accept="image/*">
                        <label class="custom-file-label" for="certificado_imagen">
                            <i class="fas fa-upload"></i> Seleccione una imagen...
                        </label>
                    </div>
                    <small class="form-text text-muted mt-2">
                        <i class="fas fa-info-circle"></i> Tamaño máximo: 5MB. Formatos permitidos: JPG, PNG, GIF
                    </small>
                </div>
            </div>
        </div>

        <!-- Sección: Guía de Movimiento -->
        <div class="card shadow-sm mb-4 border-left-primary">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-road text-primary"></i> Guía de Movimiento del Animal
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-map-marker-alt text-primary"></i> Destino (Matadero o Campo)
                            </label>
                            <input type="text" name="destino_matadero_campo" class="form-control" 
                                   placeholder="Ej: Matadero Municipal, Campo de Pastoreo">
                            <small class="form-text text-muted">Especifique el destino del animal</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-tag text-primary"></i> Marca del Ganado
                            </label>
                            <input type="text" name="marca_ganado" class="form-control" 
                                   placeholder="Ej: Marca registrada del animal">
                            <small class="form-text text-muted">Marca identificadora del ganado</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-hashtag text-primary"></i> Señal o #
                            </label>
                            <input type="text" name="senal_numero" class="form-control" 
                                   placeholder="Ej: #12345, Señal A-001">
                            <small class="form-text text-muted">Número de señal o identificación</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-route text-primary"></i> Hoja de Ruta (Foto)
                            </label>
                            <div class="custom-file">
                                <input type="file" name="hoja_ruta_foto" class="custom-file-input" id="hoja_ruta_foto" accept="image/*">
                                <label class="custom-file-label" for="hoja_ruta_foto">
                                    <i class="fas fa-upload"></i> Seleccione una imagen...
                                </label>
                            </div>
                            <small class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle"></i> Tamaño máximo: 5MB. Formatos: JPG, PNG, GIF
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: Información del Dueño -->
        <div class="card shadow-sm mb-4 border-left-info">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-user text-info"></i> Información del Dueño
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-user-circle text-info"></i> Nombre del Dueño
                            </label>
                            <input type="text" name="nombre_dueño" class="form-control" 
                                   placeholder="Ej: Juan Pérez, María González">
                            <small class="form-text text-muted">Nombre completo del dueño de los animales</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-id-card text-info"></i> Foto del Carnet del Dueño
                            </label>
                            <div class="custom-file">
                                <input type="file" name="carnet_dueño_foto" class="custom-file-input" id="carnet_dueño_foto" accept="image/*">
                                <label class="custom-file-label" for="carnet_dueño_foto">
                                    <i class="fas fa-upload"></i> Seleccione una imagen...
                                </label>
                            </div>
                            <small class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle"></i> Tamaño máximo: 5MB. Formatos: JPG, PNG, GIF
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="<?php echo e(route('admin.datos-sanitarios.index')); ?>" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save"></i> Guardar Registro Sanitario
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Actualizar labels de archivos seleccionados
document.getElementById('certificado_imagen').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Seleccione una imagen...';
    e.target.nextElementSibling.innerHTML = '<i class="fas fa-file-image"></i> ' + fileName;
});

document.getElementById('hoja_ruta_foto').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Seleccione una imagen...';
    e.target.nextElementSibling.innerHTML = '<i class="fas fa-file-image"></i> ' + fileName;
});

document.getElementById('carnet_dueño_foto').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Seleccione una imagen...';
    e.target.nextElementSibling.innerHTML = '<i class="fas fa-file-image"></i> ' + fileName;
});
</script>

<style>
.border-left-primary {
    border-left: 4px solid #007bff !important;
}
.border-left-success {
    border-left: 4px solid #28a745 !important;
}
.border-left-info {
    border-left: 4px solid #17a2b8 !important;
}
.border-left-warning {
    border-left: 4px solid #ffc107 !important;
}
.custom-control-lg .custom-control-label::before {
    width: 1.5rem;
    height: 1.5rem;
    top: 0.25rem;
}
.custom-control-lg .custom-control-label::after {
    width: 1.5rem;
    height: 1.5rem;
    top: 0.25rem;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proy2\ProyectoAgricolaLocal\resources\views/datos_sanitarios/create.blade.php ENDPATH**/ ?>