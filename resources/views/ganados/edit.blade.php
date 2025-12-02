@extends('layouts.adminlte')

@section('title', 'Editar Ganado')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Editar Registro de Ganado</h1>
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('ganados.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('ganados.update', $ganado->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- NOMBRE --}}
                <div class="form-group mb-3">
                    <label>Nombre *</label>
                    <input type="text" name="nombre" class="form-control" value="{{ $ganado->nombre }}" required>
                </div>

                {{-- TIPO ANIMAL --}}
                <div class="form-group mb-3">
                    <label>Tipo de Animal *</label>
                    <select name="tipo_animal_id" id="tipo_animal_id" class="form-control" required>
                        @foreach($tipo_animals as $item)
                            <option value="{{ $item->id }}" {{ $ganado->tipo_animal_id == $item->id ? 'selected' : '' }}>
                                {{ $item->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- RAZA --}}
                <div class="form-group mb-3">
                    <label>Raza</label>
                    <select name="raza_id" id="raza_id" class="form-control">
                        @foreach($razas as $raza)
                            <option value="{{ $raza->id }}" {{ $ganado->raza_id == $raza->id ? 'selected' : '' }}>
                                {{ $raza->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- EDAD --}}
                <div class="form-group mb-3">
                    <label>Edad</label>
                    @php
                        $anos = floor($ganado->edad / 12);
                        $meses = $ganado->edad % 12;
                    @endphp

                    <div class="d-flex" style="gap: 10px;">
                        <select name="edad_anos" class="form-control" style="max-width: 150px;">
                            @for($i=0;$i<=25;$i++)
                                <option value="{{ $i }}" {{ $i == $anos ? 'selected' : '' }}>
                                    {{ $i }} años
                                </option>
                            @endfor
                        </select>

                        <select name="edad_meses" class="form-control" style="max-width: 150px;">
                            @for($i=0;$i<=11;$i++)
                                <option value="{{ $i }}" {{ $i == $meses ? 'selected' : '' }}>
                                    {{ $i }} meses
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                {{-- TIPO PESO --}}
                <div class="form-group mb-3">
                    <label>Método de Venta / Tipo de Peso</label>
                    <select name="tipo_peso_id" class="form-control" required>
                        @foreach($tipoPesos as $peso)
                            <option value="{{ $peso->id }}" {{ $ganado->tipo_peso_id == $peso->id ? 'selected' : '' }}>
                                {{ $peso->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- SEXO --}}
                <div class="form-group mb-3">
                    <label>Sexo</label>
                    <select name="sexo" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Macho" {{ $ganado->sexo == 'Macho' ? 'selected' : '' }}>Macho</option>
                        <option value="Hembra" {{ $ganado->sexo == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                    </select>
                </div>

                {{-- CATEGORIA --}}
                <div class="form-group mb-3">
                    <label>Categoría *</label>
                    <select name="categoria_id" class="form-control" required>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ $ganado->categoria_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- DATOS SANITARIOS --}}
                <div class="form-group mb-3">
                    <label for="dato_sanitario_id">Datos Sanitarios</label>
                    <select name="dato_sanitario_id" class="form-control">
                        <option value="">Sin registro sanitario</option>
                        @foreach($datosSanitarios as $ds)
                            <option value="{{ $ds->id }}" {{ $ganado->dato_sanitario_id == $ds->id ? 'selected' : '' }}>
                                {{ $ds->vacuna ?? 'Sin vacuna' }} - {{ $ds->fecha_aplicacion ?? 'Sin fecha' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- FECHA PUBLICACION --}}
                <div class="form-group mb-3">
                    <label>Fecha de Publicación</label>
                    <input type="date" class="form-control" name="fecha_publicacion"
                           value="{{ $ganado->fecha_publicacion }}">
                </div>

                {{-- UBICACIÓN + MAPA --}}
                <div class="form-group mb-3">
                    <label>Ubicación</label>
                    <input type="text" id="ubicacion" name="ubicacion" class="form-control"
                           value="{{ $ganado->ubicacion }}" readonly>

                    <div id="map" style="height: 400px; margin-top:10px;"></div>

                    <input type="hidden" name="latitud" id="latitud" value="{{ $ganado->latitud }}">
                    <input type="hidden" name="longitud" id="longitud" value="{{ $ganado->longitud }}">
                    <input type="hidden" name="departamento" id="departamento" value="{{ $ganado->departamento }}">
                    <input type="hidden" name="municipio" id="municipio" value="{{ $ganado->municipio }}">
                    <input type="hidden" name="provincia" id="provincia" value="{{ $ganado->provincia }}">
                    <input type="hidden" name="ciudad" id="ciudad" value="{{ $ganado->ciudad }}">
                    
                    <div id="info-ubicacion" class="mt-3" style="display: {{ ($ganado->ciudad || $ganado->municipio) ? 'block' : 'none' }};">
                        <div class="card border">
                            <div class="card-body">
                                <h6 class="mb-3"><strong>Ubicación</strong></h6>
                                <div class="row mb-2">
                                    <div class="col-md-3">
                                        <strong>Ciudad:</strong>
                                    </div>
                                    <div class="col-md-9" id="ciudad-texto">
                                        {{ $ganado->ciudad ?? $ganado->municipio ?? '-' }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Dirección:</strong>
                                    </div>
                                    <div class="col-md-9" id="direccion-texto">
                                        @php
                                            $direccion = [];
                                            if($ganado->municipio) $direccion[] = $ganado->municipio;
                                            if($ganado->provincia) $direccion[] = 'Provincia ' . $ganado->provincia;
                                            if($ganado->departamento) $direccion[] = $ganado->departamento;
                                            $direccion[] = 'Bolivia';
                                            $direccionCompleta = implode(', ', $direccion);
                                        @endphp
                                        {{ $direccionCompleta }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="form-group mb-3">
                    <label>Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3">{{ $ganado->descripcion }}</textarea>
                </div>

                {{-- PRECIO --}}
                <div class="form-group mb-3">
                    <label>Precio (Bs)</label>
                    <input type="number" name="precio" class="form-control" step="0.01"
                           value="{{ $ganado->precio }}">
                </div>

                {{-- STOCK --}}
                <div class="form-group mb-3">
                    <label>Stock (Cantidad) *</label>
                    <input type="number" name="stock" class="form-control" min="0"
                           value="{{ $ganado->stock ?? 0 }}" required>
                    <small class="form-text text-muted">Ingrese la cantidad disponible de ganado</small>
                </div>

                {{-- IMÁGENES --}}
                <div class="form-group mb-3">
                    <label>Imágenes (máximo 3)</label>
                    
                    @if($ganado->imagenes && $ganado->imagenes->count() > 0)
                        <div class="mb-3">
                            <p class="text-muted">Imágenes actuales:</p>
                            <div class="row" id="imagenes-actuales">
                                @foreach($ganado->imagenes as $imagen)
                                    <div class="col-md-4 mb-3 imagen-item" data-imagen-id="{{ $imagen->id }}">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/'.$imagen->ruta) }}" 
                                                 alt="Imagen {{ $loop->iteration }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 100%; height: 150px; object-fit: cover;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 eliminar-imagen" 
                                                    data-imagen-id="{{ $imagen->id }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="imagenes_eliminar[]" value="" class="imagen-eliminar-input">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <div id="preview-container" class="row mb-3"></div>
                    
                    <input type="file" name="imagenes[]" class="form-control" accept="image/*" multiple id="imagenes-input">
                    <small class="form-text text-muted">Puedes seleccionar hasta 3 imágenes. Formatos permitidos: JPG, PNG, GIF. Tamaño máximo por imagen: 2MB</small>
                    <div id="imagenes-count" class="text-muted mt-2"></div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Registro
                </button>

            </form>

        </div>
    </div>

</div>

{{-- Leaflet Map --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    var map = L.map('map').setView([{{ $ganado->latitud ?? -17.7833 }}, {{ $ganado->longitud ?? -63.1821 }}], 7);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var marker = L.marker([{{ $ganado->latitud ?? -17.7833 }}, {{ $ganado->longitud ?? -63.1821 }}]).addTo(map);

    map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(7);
        var lng = e.latlng.lng.toFixed(7);

        marker.setLatLng([lat, lng]);

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
    const imagenesActuales = {{ $ganado->imagenes ? $ganado->imagenes->count() : 0 }};
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
            updateCount();
        });
    });

    function updateCount() {
        const total = imagenesActuales - imagenesAEliminar.length + imagenesNuevas;
        countDisplay.textContent = `Total de imágenes: ${total} / 3`;
        
        if (total > 3) {
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
        const maxFiles = 3 - (imagenesActuales - imagenesAEliminar.length);
        
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

@endsection
