<?php $__env->startSection('title', 'Editar Ganado'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Editar Registro de Ganado</h1>
        <a href="<?php echo e(route('ganados.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="<?php echo e(route('ganados.update', $ganado->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <div class="form-group mb-3">
                    <label>Nombre *</label>
                    <input type="text" name="nombre" class="form-control" value="<?php echo e($ganado->nombre); ?>" required>
                </div>

                
                <div class="form-group mb-3">
                    <label>Tipo de Animal *</label>
                    <select name="tipo_animal_id" id="tipo_animal_id" class="form-control" required>
                        <?php $__currentLoopData = $tipo_animals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" <?php echo e($ganado->tipo_animal_id == $item->id ? 'selected' : ''); ?>>
                                <?php echo e($item->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div class="form-group mb-3">
                    <label>Raza</label>
                    <select name="raza_id" id="raza_id" class="form-control">
                        <?php $__currentLoopData = $razas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $raza): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($raza->id); ?>" <?php echo e($ganado->raza_id == $raza->id ? 'selected' : ''); ?>>
                                <?php echo e($raza->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div class="form-group mb-3">
                    <label>Edad</label>
                    <?php
                        $anos = floor($ganado->edad / 12);
                        $meses = $ganado->edad % 12;
                    ?>

                    <div class="d-flex" style="gap: 10px;">
                        <select name="edad_anos" class="form-control" style="max-width: 150px;">
                            <?php for($i=0;$i<=25;$i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e($i == $anos ? 'selected' : ''); ?>>
                                    <?php echo e($i); ?> años
                                </option>
                            <?php endfor; ?>
                        </select>

                        <select name="edad_meses" class="form-control" style="max-width: 150px;">
                            <?php for($i=0;$i<=11;$i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e($i == $meses ? 'selected' : ''); ?>>
                                    <?php echo e($i); ?> meses
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                
                <div class="form-group mb-3">
                    <label>Método de Venta / Tipo de Peso</label>
                    <select name="tipo_peso_id" class="form-control" required>
                        <?php $__currentLoopData = $tipoPesos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($peso->id); ?>" <?php echo e($ganado->tipo_peso_id == $peso->id ? 'selected' : ''); ?>>
                                <?php echo e($peso->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div class="form-group mb-3">
                    <label>Sexo</label>
                    <select name="sexo" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Macho" <?php echo e($ganado->sexo == 'Macho' ? 'selected' : ''); ?>>Macho</option>
                        <option value="Hembra" <?php echo e($ganado->sexo == 'Hembra' ? 'selected' : ''); ?>>Hembra</option>
                    </select>
                </div>

                
                <div class="form-group mb-3">
                    <label>Categoría *</label>
                    <select name="categoria_id" class="form-control" required>
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>" <?php echo e($ganado->categoria_id == $cat->id ? 'selected' : ''); ?>>
                                <?php echo e($cat->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

               

                
                <div class="form-group mb-3">
                    <label>Fecha de Publicación</label>
                    <input type="date" class="form-control" name="fecha_publicacion"
                           value="<?php echo e($ganado->fecha_publicacion); ?>">
                </div>

                
                <div class="form-group mb-3">
                    <label>Ubicación</label>
                    <input type="text" id="ubicacion" name="ubicacion" class="form-control"
                           value="<?php echo e($ganado->ubicacion); ?>" readonly>

                    <div id="map" style="height: 400px; margin-top:10px;"></div>

                    <input type="hidden" name="latitud" id="latitud" value="<?php echo e($ganado->latitud); ?>">
                    <input type="hidden" name="longitud" id="longitud" value="<?php echo e($ganado->longitud); ?>">
                </div>

                
                <div class="form-group mb-3">
                    <label>Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3"><?php echo e($ganado->descripcion); ?></textarea>
                </div>

                
                <div class="form-group mb-3">
                    <label>Precio (Bs)</label>
                    <input type="number" name="precio" class="form-control" step="0.01"
                           value="<?php echo e($ganado->precio); ?>">
                </div>

                
                <div class="form-group mb-3">
                    <label>Stock (Cantidad) *</label>
                    <input type="number" name="stock" class="form-control" min="0"
                           value="<?php echo e($ganado->stock ?? 0); ?>" required>
                    <small class="form-text text-muted">Ingrese la cantidad disponible de ganado</small>
                </div>

                
                <div class="form-group mb-3">
                    <label>Imagen</label><br>

                    <?php if($ganado->imagen): ?>
                        <div class="mb-3">
                            <img src="<?php echo e(asset('storage/'.$ganado->imagen)); ?>" 
                                 alt="<?php echo e($ganado->nombre); ?>" 
                                 class="img-thumbnail" 
                                 style="max-width: 200px; max-height: 200px; object-fit: cover; cursor: pointer;"
                                 onclick="window.open('<?php echo e(asset('storage/'.$ganado->imagen)); ?>', '_blank')"
                                 title="Click para ver imagen completa">
                            <p class="text-muted mt-2">
                                <i class="fas fa-image"></i> Imagen actual (click para ampliar)
                            </p>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">
                            <i class="fas fa-image"></i> Sin imagen actual
                        </p>
                    <?php endif; ?>

                    <input type="file" name="imagen" class="form-control" accept="image/*">
                    <small class="form-text text-muted">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Registro
                </button>

            </form>

        </div>
    </div>

</div>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    var map = L.map('map').setView([<?php echo e($ganado->latitud ?? -17.7833); ?>, <?php echo e($ganado->longitud ?? -63.1821); ?>], 7);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var marker = L.marker([<?php echo e($ganado->latitud ?? -17.7833); ?>, <?php echo e($ganado->longitud ?? -63.1821); ?>]).addTo(map);

    map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(7);
        var lng = e.latlng.lng.toFixed(7);

        marker.setLatLng([lat, lng]);

        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
        document.getElementById('ubicacion').value = "Lat: " + lat + " - Lng: " + lng;
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/ganados/edit.blade.php ENDPATH**/ ?>