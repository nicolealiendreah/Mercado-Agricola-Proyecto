<?php echo csrf_field(); ?>
<div class="form-group">
  <label>Nombre *</label>
  <input type="text" name="nombre" class="form-control" value="<?php echo e(old('nombre', $organico->nombre ?? '')); ?>" required>
</div>
<div class="form-group">
    <label for="categoria_id">Categoría *</label>
    <select name="categoria_id" id="categoria_id" class="form-control" required>
        <option value="">Seleccione una categoría</option>
        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($categoria->id); ?>"
                <?php echo e(old('categoria_id', $organico->categoria_id ?? '') == $categoria->id ? 'selected' : ''); ?>>
                <?php echo e($categoria->nombre); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="form-group">
    <label for="unidad_id">Unidad de Medida</label>
    <select name="unidad_id" id="unidad_id" class="form-control">
        <option value="">Seleccione una unidad</option>
        <?php $__currentLoopData = $unidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($unidad->id); ?>"
                <?php echo e(old('unidad_id', $organico->unidad_id ?? '') == $unidad->id ? 'selected' : ''); ?>>
                <?php echo e($unidad->nombre); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <small class="form-text text-muted">Ejemplos: Kg, Libras, Atados, Saco 50kg, Docena</small>
</div>

<div class="form-group">
  <label>Precio *</label>
  <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo e(old('precio', $organico->precio ?? 0)); ?>" required>
</div>
<div class="form-group">
  <label>Stock *</label>
  <input type="number" name="stock" class="form-control" value="<?php echo e(old('stock', $organico->stock ?? 0)); ?>" required>
</div>
<div class="form-group">
  <label>Fecha de cosecha</label>
  <input type="date" name="fecha_cosecha" class="form-control" value="<?php echo e(old('fecha_cosecha', $organico->fecha_cosecha ?? '')); ?>">
</div>
<div class="form-group">
  <label>Descripción</label>
  <textarea name="descripcion" class="form-control" rows="3"><?php echo e(old('descripcion', $organico->descripcion ?? '')); ?></textarea>
</div>

<div class="form-group">
    <label>Origen / Procedencia</label>
    <input type="text" id="origen" name="origen" class="form-control" 
           value="<?php echo e(old('origen', $organico->origen ?? '')); ?>" readonly>
    <small class="form-text text-muted">Haz clic en el mapa para seleccionar el lugar donde se cosechó</small>
    <div id="map-origen" style="height: 400px; margin-top: 10px; border: 1px solid #ddd; border-radius: 4px;"></div>
    <input type="hidden" name="latitud_origen" id="latitud_origen" value="<?php echo e(old('latitud_origen', $organico->latitud_origen ?? '')); ?>">
    <input type="hidden" name="longitud_origen" id="longitud_origen" value="<?php echo e(old('longitud_origen', $organico->longitud_origen ?? '')); ?>">
</div>

<div class="form-group">
    <label>Imágenes (máximo 4)</label>
    
    <?php if(isset($organico) && $organico->imagenes && $organico->imagenes->count() > 0): ?>
        <div class="mb-3">
            <p class="text-muted">Imágenes actuales:</p>
            <div class="row" id="imagenes-actuales">
                <?php $__currentLoopData = $organico->imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3 mb-3 imagen-item" data-imagen-id="<?php echo e($imagen->id); ?>">
                        <div class="position-relative">
                            <img src="<?php echo e(asset('storage/'.$imagen->ruta)); ?>" 
                                 alt="Imagen <?php echo e($loop->iteration); ?>" 
                                 class="img-thumbnail" 
                                 style="width: 100%; height: 150px; object-fit: cover;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 eliminar-imagen" 
                                    data-imagen-id="<?php echo e($imagen->id); ?>">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <input type="hidden" name="imagenes_eliminar[]" value="" class="imagen-eliminar-input">
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
    
    <div id="preview-container" class="row mb-3"></div>
    
    <input type="file" name="imagenes[]" class="form-control" accept="image/*" multiple id="imagenes-input">
    <small class="form-text text-muted">Puedes seleccionar hasta 4 imágenes. Formatos permitidos: JPG, PNG, GIF. Tamaño máximo por imagen: 2MB</small>
    <div id="imagenes-count" class="text-muted mt-2"></div>
</div>

<button class="btn btn-success">Guardar</button>
<a href="<?php echo e(url()->previous() !== url()->current() ? url()->previous() : route('organicos.index')); ?>" class="btn btn-secondary">Volver</a>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Coordenadas iniciales (centro de Bolivia)
    var initialLat = <?php echo e(old('latitud_origen', $organico->latitud_origen ?? -17.7833)); ?>;
    var initialLng = <?php echo e(old('longitud_origen', $organico->longitud_origen ?? -63.1821)); ?>;
    var initialZoom = <?php echo e(isset($organico) && $organico->latitud_origen ? 12 : 6); ?>;

    // Crear el mapa
    var mapOrigen = L.map('map-origen').setView([initialLat, initialLng], initialZoom);

    // Capa gratuita de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'OpenStreetMap'
    }).addTo(mapOrigen);

    var markerOrigen;

    // Si hay coordenadas existentes, mostrar el marcador
    <?php if(isset($organico) && $organico->latitud_origen && $organico->longitud_origen): ?>
        markerOrigen = L.marker([initialLat, initialLng]).addTo(mapOrigen);
    <?php endif; ?>

    // Evento click en mapa
    mapOrigen.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(7);
        var lng = e.latlng.lng.toFixed(7);

        if (markerOrigen) {
            markerOrigen.setLatLng([lat, lng]);
        } else {
            markerOrigen = L.marker([lat, lng]).addTo(mapOrigen);
        }

        document.getElementById('latitud_origen').value = lat;
        document.getElementById('longitud_origen').value = lng;
        document.getElementById('origen').value = "Lat: " + lat + " - Lng: " + lng;
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('imagenes-input');
    const previewContainer = document.getElementById('preview-container');
    const countDisplay = document.getElementById('imagenes-count');
    const imagenesActuales = <?php echo e(isset($organico) && $organico->imagenes ? $organico->imagenes->count() : 0); ?>;
    let imagenesNuevas = 0;
    let imagenesAEliminar = [];

    // Manejar eliminación de imágenes existentes
    document.querySelectorAll('.eliminar-imagen').forEach(btn => {
        btn.addEventListener('click', function() {
            const imagenId = this.getAttribute('data-imagen-id');
            const imagenItem = this.closest('.imagen-item');
            const inputEliminar = imagenItem.querySelector('.imagen-eliminar-input');
            
            if (inputEliminar.value === '') {
                inputEliminar.value = imagenId;
                imagenItem.style.opacity = '0.5';
                this.innerHTML = '<i class="fas fa-undo"></i>';
                imagenesAEliminar.push(imagenId);
            } else {
                inputEliminar.value = '';
                imagenItem.style.opacity = '1';
                this.innerHTML = '<i class="fas fa-times"></i>';
                imagenesAEliminar = imagenesAEliminar.filter(id => id !== imagenId);
            }
        });
    });

    function updateCount() {
        const total = imagenesActuales - imagenesAEliminar.length + imagenesNuevas;
        countDisplay.textContent = `Total de imágenes: ${total} / 4`;
        
        if (total > 4) {
            countDisplay.className = 'text-danger mt-2';
            countDisplay.textContent += ' (Excede el límite de 4 imágenes)';
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
        const maxFiles = 4 - (imagenesActuales - imagenesAEliminar.length);
        
        files.slice(0, maxFiles).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const fileId = Date.now() + '-' + index;
                fileMap.set(fileId, file);
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-3';
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
<?php /**PATH C:\Users\Nicole\proy2\ProyectoAgricolaLocal\resources\views/organicos/_form.blade.php ENDPATH**/ ?>