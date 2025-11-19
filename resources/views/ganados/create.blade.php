@extends('layouts.adminlte')

@section('title', 'Registrar Ganado')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Registrar Nuevo Ganado</h1>
        <a href="{{ route('ganados.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('ganados.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="nombre">Nombre *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                </div>

                <div class="form-group">
    
    <div class="form-group">
    <label for="tipo_animal_id">Tipo de Animal</label>
    <select name="tipo_animal_id" id="tipo_animal_id" class="form-control" required>
        <option value="">Seleccione...</option>
        @foreach($tipo_animals as $item)
            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
        @endforeach
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
            @for($i = 0; $i <= 25; $i++)
                <option value="{{ $i }}">{{ $i }} años</option>
            @endfor
        </select>

        <select name="edad_meses" class="form-control" style="max-width: 150px;" required>
            <option value="">Meses</option>
            @for($i = 0; $i <= 11; $i++)
                <option value="{{ $i }}">{{ $i }} meses</option>
            @endfor
        </select>

    </div>
</div>


                <div class="mb-3">
    <label for="tipo_peso_id" class="form-label">Método de Venta / Tipo de Peso</label>
    <select name="tipo_peso_id" class="form-control" required>
    @foreach($tipoPesos as $peso)
        <option value="{{ $peso->id }}">{{ $peso->nombre }}</option>
    @endforeach
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
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>
<div class="form-group mt-3">
    <label for="dato_sanitario_id">Datos Sanitarios</label>
    <select name="dato_sanitario_id" class="form-control">
        <option value="">Sin registro sanitario</option>
        @foreach($datosSanitarios as $ds)
            <option value="{{ $ds->id }}">
                {{ $ds->vacuna ?? 'Sin vacuna' }} - {{ $ds->fecha_aplicacion }}
            </option>
        @endforeach
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
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="precio">Precio (Bs)</label>
                    <input type="number" name="precio" id="precio" class="form-control" step="0.01" min="0" value="{{ old('precio') }}">
                </div>

                <div class="form-group mb-3">
                    <label for="stock">Stock (Cantidad) *</label>
                    <input type="number" name="stock" id="stock" class="form-control" min="0" value="{{ old('stock', 0) }}" required>
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
    const razas = @json($razas);

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

@endsection
