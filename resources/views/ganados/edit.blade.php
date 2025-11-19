@extends('layouts.adminlte')

@section('title', 'Editar Ganado')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Editar Registro de Ganado</h1>
        <a href="{{ route('ganados.index') }}" class="btn btn-secondary">
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

                {{-- IMAGEN --}}
                <div class="form-group mb-3">
                    <label>Imagen</label><br>

                    @if($ganado->imagen)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$ganado->imagen) }}" 
                                 alt="{{ $ganado->nombre }}" 
                                 class="img-thumbnail" 
                                 style="max-width: 200px; max-height: 200px; object-fit: cover; cursor: pointer;"
                                 onclick="window.open('{{ asset('storage/'.$ganado->imagen) }}', '_blank')"
                                 title="Click para ver imagen completa">
                            <p class="text-muted mt-2">
                                <i class="fas fa-image"></i> Imagen actual (click para ampliar)
                            </p>
                        </div>
                    @else
                        <p class="text-muted">
                            <i class="fas fa-image"></i> Sin imagen actual
                        </p>
                    @endif

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
    });
</script>

@endsection
