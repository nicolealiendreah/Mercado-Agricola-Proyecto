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
<div class="form-group"><label>Teléfono</label>
  <input type="tel" name="telefono" class="form-control" value="<?php echo e(old('telefono', $maquinaria->telefono ?? '')); ?>" placeholder="Ej: +57 300 123 4567">
</div>
<div class="form-group"><label>Precio por día *</label>
  <input type="number" step="0.01" name="precio_dia" class="form-control" value="<?php echo e(old('precio_dia', $maquinaria->precio_dia ?? 0)); ?>" required>
</div>
<div class="form-group">
    <label>Estado *</label>
    <select name="estado_maquinaria_id" class="form-control" required>
        <option value="">Seleccione un estado</option>
        <?php $__currentLoopData = $estado_maquinarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($estado->id); ?>"
                <?php echo e(old('estado_maquinaria_id', $maquinaria->estado_maquinaria_id ?? '') == $estado->id ? 'selected' : ''); ?>>
                <?php echo e($estado->nombre); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
<div class="form-group"><label>Descripción</label>
  <textarea name="descripcion" class="form-control" rows="3"><?php echo e(old('descripcion', $maquinaria->descripcion ?? '')); ?></textarea>
</div>

<div class="form-group">
    <label>Ubicación</label>
    <input type="text" id="ubicacion" name="ubicacion" class="form-control" 
           value="<?php echo e(old('ubicacion', $maquinaria->ubicacion ?? '')); ?>" readonly>
    <small class="form-text text-muted">Haz clic en el mapa para seleccionar la ubicación de la maquinaria</small>
    <div id="map" style="height: 400px; margin-top: 10px; border: 1px solid #ddd; border-radius: 4px;"></div>
    <input type="hidden" name="latitud" id="latitud" value="<?php echo e(old('latitud', $maquinaria->latitud ?? '')); ?>">
    <input type="hidden" name="longitud" id="longitud" value="<?php echo e(old('longitud', $maquinaria->longitud ?? '')); ?>">
</div>

<div class="form-group">
    <label>Imágenes (máximo 4)</label>
    
    <?php if(isset($maquinaria) && $maquinaria->imagenes->count() > 0): ?>
        <div class="mb-3">
            <p class="text-muted">Imágenes actuales:</p>
            <div class="row" id="imagenes-actuales">
                <?php $__currentLoopData = $maquinaria->imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
<a href="<?php echo e(url()->previous() !== url()->current() ? url()->previous() : route('maquinarias.index')); ?>" class="btn btn-secondary">Volver</a>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('imagenes-input');
    const previewContainer = document.getElementById('preview-container');
    const countDisplay = document.getElementById('imagenes-count');
    const imagenesActuales = <?php echo e(isset($maquinaria) && $maquinaria->imagenes ? $maquinaria->imagenes->count() : 0); ?>;
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

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Coordenadas iniciales (centro de Bolivia)
    var initialLat = <?php echo e(old('latitud', $maquinaria->latitud ?? -17.7833)); ?>;
    var initialLng = <?php echo e(old('longitud', $maquinaria->longitud ?? -63.1821)); ?>;
    var initialZoom = <?php echo e(isset($maquinaria) && $maquinaria->latitud ? 12 : 6); ?>;

    // Crear el mapa
    var map = L.map('map').setView([initialLat, initialLng], initialZoom);

    // Capa gratuita de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'OpenStreetMap'
    }).addTo(map);

    var marker;

    // Si hay coordenadas existentes, mostrar el marcador
    <?php if(isset($maquinaria) && $maquinaria->latitud && $maquinaria->longitud): ?>
        marker = L.marker([initialLat, initialLng]).addTo(map);
    <?php endif; ?>

    // Evento click en mapa
    map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(7);
        var lng = e.latlng.lng.toFixed(7);

        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }

        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
        document.getElementById('ubicacion').value = "Lat: " + lat + " - Lng: " + lng;
    });
</script>
<?php /**PATH C:\Users\Nicole\proy2\ProyectoAgricolaLocal\resources\views/maquinarias/_form.blade.php ENDPATH**/ ?>