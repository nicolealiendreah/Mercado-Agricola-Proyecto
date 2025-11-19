<?php $__env->startSection('title', 'Registrar Ganado'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Registrar Nuevo Ganado</h1>
        <a href="<?php echo e(route('ganados.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?php echo e(route('ganados.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="form-group mb-3">
                    <label for="nombre">Nombre *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo e(old('nombre')); ?>" required>
                </div>

                <div class="form-group">
    
    <div class="form-group">
    <label for="tipo_animal_id">Tipo de Animal</label>
    <select name="tipo_animal_id" id="tipo_animal_id" class="form-control" required>
        <option value="">Seleccione...</option>
        <?php $__currentLoopData = $tipo_animals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($item->id); ?>"><?php echo e($item->nombre); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="form-group">
    <label for="raza_id">Raza</label>
    <select name="raza_id" id="raza_id" class="form-control" disabled>
        <option value="">Seleccione un tipo de animal primero</option>
    </select>
</div>




                <div class="form-group mb-3">
    <label>Edad</label>
    <div class="d-flex" style="gap: 10px;">
        
        <select name="edad_anos" class="form-control" style="max-width: 150px;" required>
            <option value="">Años</option>
            <?php for($i = 0; $i <= 25; $i++): ?>
                <option value="<?php echo e($i); ?>"><?php echo e($i); ?> años</option>
            <?php endfor; ?>
        </select>

        <select name="edad_meses" class="form-control" style="max-width: 150px;" required>
            <option value="">Meses</option>
            <?php for($i = 0; $i <= 11; $i++): ?>
                <option value="<?php echo e($i); ?>"><?php echo e($i); ?> meses</option>
            <?php endfor; ?>
        </select>

    </div>
</div>


                <div class="mb-3">
    <label for="tipo_peso_id" class="form-label">Método de Venta / Tipo de Peso</label>
    <select name="tipo_peso_id" class="form-control" required>
    <?php $__currentLoopData = $tipoPesos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($peso->id); ?>"><?php echo e($peso->nombre); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>

</div>


                <div class="form-group mb-3">
                    <label for="sexo">Sexo</label>
                    <select name="sexo" id="sexo" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="categoria_id">Categoría *</label>
                    <select name="categoria_id" id="categoria_id" class="form-control" required>
                        <option value="">Seleccione una categoría</option>
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($categoria->id); ?>"><?php echo e($categoria->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
<div class="form-group mt-3">
    <label for="dato_sanitario_id">Datos Sanitarios</label>
    <select name="dato_sanitario_id" class="form-control">
        <option value="">Sin registro sanitario</option>
        <?php $__currentLoopData = $datosSanitarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($ds->id); ?>">
                <?php echo e($ds->vacuna ?? 'Sin vacuna'); ?> - <?php echo e($ds->fecha_aplicacion); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="form-group mt-3">
    <label for="fecha_publicacion">Fecha de Publicación</label>
    <input type="date" class="form-control" name="fecha_publicacion">
</div>

<div class="form-group mt-3">
    <label for="map">Ubicación (seleccione en el mapa)</label>
    
    <div id="map" style="height: 400px; border-radius: 10px;"></div>

    <input type="hidden" name="latitud" id="latitud">
    <input type="hidden" name="longitud" id="longitud">

    <input type="text" name="ubicacion" id="ubicacion" class="form-control mt-2"
           placeholder="Ubicación seleccionada" readonly>
</div>


                <div class="form-group mb-3">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="3"><?php echo e(old('descripcion')); ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="precio">Precio (Bs)</label>
                    <input type="number" name="precio" id="precio" class="form-control" step="0.01" min="0" value="<?php echo e(old('precio')); ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="stock">Stock (Cantidad) *</label>
                    <input type="number" name="stock" id="stock" class="form-control" min="0" value="<?php echo e(old('stock', 0)); ?>" required>
                    <small class="form-text text-muted">Ingrese la cantidad disponible de ganado</small>
                </div>

                <div class="form-group mb-3">
                    <label for="imagen">Imagen</label>
                    <input type="file" name="imagen" id="imagen" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Registro
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('tipo_animal_id').addEventListener('change', function() {
        let tipoID = this.value;

        fetch('/razas-por-tipo/' + tipoID)
            .then(response => response.json())
            .then(data => {
                let selectRaza = document.getElementById('raza_id');
                selectRaza.innerHTML = '<option value="">Seleccione raza</option>';

                data.forEach(function(raza) {
                    selectRaza.innerHTML += `<option value="${raza.id}">${raza.nombre}</option>`;
                });
            });
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tipoAnimalSelect = document.getElementById('tipo_animal_id');
    const razaSelect = document.getElementById('raza_id');

    // Cargar todas las razas desde PHP (ya las enviaste desde el controlador)
    const razas = <?php echo json_encode($razas, 15, 512) ?>;

    tipoAnimalSelect.addEventListener('change', function () {
        const tipoAnimalID = this.value;

        // Limpiar el select de raza
        razaSelect.innerHTML = '';
        
        if (!tipoAnimalID) {
            razaSelect.disabled = true;
            razaSelect.innerHTML = '<option value="">Seleccione un tipo de animal primero</option>';
            return;
        }

        // Filtrar razas del tipo seleccionado
        const filtradas = razas.filter(r => r.tipo_animal_id == tipoAnimalID);

        // Rellenar el select
        if (filtradas.length > 0) {
            razaSelect.disabled = false;
            razaSelect.innerHTML = '<option value="">Seleccione una raza...</option>';

            filtradas.forEach(r => {
                razaSelect.innerHTML += `<option value="${r.id}">${r.nombre}</option>`;
            });

        } else {
            razaSelect.disabled = true;
            razaSelect.innerHTML = '<option value="">No hay razas registradas para este tipo</option>';
        }
    });
});
</script>
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Crear el mapa centrado en Bolivia
    var map = L.map('map').setView([-17.7833, -63.1821], 6);

    // Capa gratuita de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'OpenStreetMap'
    }).addTo(map);

    var marker;

    // Evento click en mapa
    map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(7);
        var lng = e.latlng.lng.toFixed(7);

        if (marker) map.removeLayer(marker);

        marker = L.marker([lat, lng]).addTo(map);

        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
        document.getElementById('ubicacion').value = "Lat: " + lat + " - Lng: " + lng;
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/ganados/create.blade.php ENDPATH**/ ?>