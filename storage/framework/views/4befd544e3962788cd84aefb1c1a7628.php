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
    <input type="hidden" name="departamento" id="departamento">
    <input type="hidden" name="municipio" id="municipio">
    <input type="hidden" name="provincia" id="provincia">
    <input type="hidden" name="ciudad" id="ciudad">

    <div id="info-ubicacion" class="mt-3" style="display: none;">
        <div class="card border">
            <div class="card-body">
                <h6 class="mb-3"><strong>Ubicación</strong></h6>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <strong>Ciudad:</strong>
                    </div>
                    <div class="col-md-9" id="ciudad-texto">
                        -
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <strong>Dirección:</strong>
                    </div>
                    <div class="col-md-9" id="direccion-texto">
                        -
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    <label>Imágenes (máximo 3)</label>
                    
                    <div id="preview-container" class="row mb-3"></div>
                    
                    <input type="file" name="imagenes[]" class="form-control" accept="image/*" multiple id="imagenes-input">
                    <small class="form-text text-muted">Puedes seleccionar hasta 3 imágenes. Formatos permitidos: JPG, PNG, GIF. Tamaño máximo por imagen: 2MB</small>
                    <div id="imagenes-count" class="text-muted mt-2"></div>
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
        
        // Obtener información geográfica
        obtenerInformacionGeografica(lat, lng);
    });

    // Función para obtener información geográfica
    function obtenerInformacionGeografica(lat, lng) {
        // Mostrar contenedor de información
        document.getElementById('info-ubicacion').style.display = 'block';
        document.getElementById('ciudad-texto').textContent = 'Cargando...';
        document.getElementById('direccion-texto').textContent = 'Cargando...';

        fetch('/api/geocodificacion?latitud=' + lat + '&longitud=' + lng)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    var info = data.data;
                    
                    // Guardar en campos ocultos
                    document.getElementById('departamento').value = info.departamento || '';
                    document.getElementById('municipio').value = info.municipio || '';
                    document.getElementById('provincia').value = info.provincia || '';
                    document.getElementById('ciudad').value = info.ciudad || '';
                    
                    // Mostrar en la interfaz
                    document.getElementById('ciudad-texto').textContent = info.ciudad || info.municipio || 'No disponible';
                    
                    // Construir dirección completa: Municipio, Provincia, Departamento, Bolivia
                    var direccion = [];
                    if (info.municipio) direccion.push(info.municipio);
                    if (info.provincia) direccion.push('Provincia ' + info.provincia);
                    if (info.departamento) direccion.push(info.departamento);
                    direccion.push('Bolivia');
                    
                    var direccionCompleta = direccion.join(', ');
                    document.getElementById('direccion-texto').textContent = direccionCompleta || 'No disponible';
                    
                    // Actualizar campo ubicación
                    if (direccionCompleta) {
                        document.getElementById('ubicacion').value = direccionCompleta;
                    }
                } else {
                    document.getElementById('ciudad-texto').textContent = 'No disponible';
                    document.getElementById('direccion-texto').textContent = 'No disponible';
                }
            })
            .catch(error => {
                console.error('Error al obtener información geográfica:', error);
                document.getElementById('ciudad-texto').textContent = 'Error';
                document.getElementById('direccion-texto').textContent = 'Error';
            });
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('imagenes-input');
    const previewContainer = document.getElementById('preview-container');
    const countDisplay = document.getElementById('imagenes-count');
    let imagenesNuevas = 0;

    function updateCount() {
        countDisplay.textContent = `Total de imágenes: ${imagenesNuevas} / 3`;
        
        if (imagenesNuevas > 3) {
            countDisplay.className = 'text-danger mt-2';
            countDisplay.textContent += ' (Excede el límite de 3 imágenes)';
        } else {
            countDisplay.className = 'text-muted mt-2';
        }
    }

    let fileMap = new Map();
    
    input.addEventListener('change', function(e) {
        previewContainer.innerHTML = '';
        imagenesNuevas = 0;
        fileMap.clear();
        
        const files = Array.from(e.target.files);
        const maxFiles = 3;
        
        files.slice(0, maxFiles).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const fileId = Date.now() + '-' + index;
                fileMap.set(fileId, file);
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-4 mb-3';
                    col.setAttribute('data-file-id', fileId);
                    col.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" 
                                 alt="Preview ${index + 1}" 
                                 class="img-thumbnail" 
                                 style="width: 100%; height: 150px; object-fit: cover;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 eliminar-preview" 
                                    data-file-id="${fileId}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    previewContainer.appendChild(col);
                    imagenesNuevas++;
                    updateCount();
                    
                    // Agregar evento para eliminar preview
                    col.querySelector('.eliminar-preview').addEventListener('click', function() {
                        const fileIdToRemove = this.getAttribute('data-file-id');
                        fileMap.delete(fileIdToRemove);
                        
                        const dataTransfer = new DataTransfer();
                        fileMap.forEach(file => dataTransfer.items.add(file));
                        input.files = dataTransfer.files;
                        
                        col.remove();
                        imagenesNuevas--;
                        updateCount();
                    });
                };
                reader.readAsDataURL(file);
            }
        });
        
        updateCount();
    });

    updateCount();
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/ganados/create.blade.php ENDPATH**/ ?>