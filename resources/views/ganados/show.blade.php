@extends('layouts.adminlte')

@section('title', 'Detalle de Ganado')

@section('content')
<div class="container-fluid">

    {{-- ESTILOS PARA IGUALAR ALTURAS Y BADGES --}}
    <style>
        /* Card derecha (título, badges, precio, botón) */
        .panel-info-card {
            height: 450px; /* igual que la imagen principal */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* En pantallas pequeñas que se adapte normal */
        @media (max-width: 992px) {
            .panel-info-card {
                height: auto !important;
            }
        }

        .badge-lg {
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
        }
        .bg-success-light {
            background-color: #d4edda !important;
        }
    </style>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">
                <i class="fas fa-cow text-success"></i> Detalle del Ganado
            </h1>
            <p class="text-muted mb-0">Información completa del producto</p>
        </div>
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('ganados.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="row">
        <!-- Imagen Principal -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    @if($ganado->imagen)
                        <div class="position-relative" style="overflow: hidden; border-radius: 8px 8px 0 0;">
                            <img src="{{ asset('storage/'.$ganado->imagen) }}" 
                                 alt="Imagen de {{ $ganado->nombre }}" 
                                 class="img-fluid w-100" 
                                 style="height: 450px; object-fit: cover; cursor: pointer;"
                                 onclick="window.open('{{ asset('storage/'.$ganado->imagen) }}', '_blank')"
                                 title="Click para ver imagen completa">
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge badge-success badge-lg">
                                    <i class="fas fa-image"></i> Click para ampliar
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 450px;">
                            <div class="text-center text-muted">
                                <i class="fas fa-image fa-4x mb-3"></i>
                                <p class="mb-0">Sin imagen disponible</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información Principal -->
        <div class="col-lg-7">
            <!-- Título y Precio -->
            <div class="card shadow-sm border-0 mb-4 panel-info-card">
                <div class="card-body">
                    <h2 class="h4 mb-3 text-dark">{{ $ganado->nombre }}</h2>
                    
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                        <span class="badge badge-success badge-lg px-3 py-2">
                            <i class="fas fa-tag"></i> {{ $ganado->categoria->nombre ?? 'Sin categoría' }}
                        </span>
                        @if($ganado->tipoAnimal)
                            <span class="badge badge-info badge-lg px-3 py-2">
                                <i class="fas fa-paw"></i> {{ $ganado->tipoAnimal->nombre }}
                            </span>
                        @endif
                        @if($ganado->stock ?? 0 > 0)
                            <span class="badge badge-primary badge-lg px-3 py-2">
                                <i class="fas fa-box"></i> Stock: {{ $ganado->stock }}
                            </span>
                        @endif
                    </div>

                    @if($ganado->precio)
                        <div class="bg-success-light p-4 rounded mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block mb-1">Precio</small>
                                    <h3 class="h4 mb-0 text-success font-weight-bold">
                                        Bs {{ number_format($ganado->precio, 2) }}
                                    </h3>
                                </div>
                                <div class="text-right">
                                    <i class="fas fa-money-bill-wave fa-3x text-success opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle"></i> Precio a consultar
                        </div>
                    @endif

                    @auth
                        @if($ganado->precio && ($ganado->stock ?? 0) > 0)
                            <div class="border-top pt-4">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_type" value="ganado">
                                    <input type="hidden" name="product_id" value="{{ $ganado->id }}">
                                    <div class="form-row align-items-end">
                                        <div class="col-auto">
                                            <label class="small font-weight-bold text-muted mb-2 d-block">Cantidad</label>
                                            <input type="number" 
                                                   name="cantidad" 
                                                   class="form-control form-control-lg" 
                                                   value="1" 
                                                   min="1" 
                                                   max="{{ $ganado->stock ?? 1 }}" 
                                                   required
                                                   style="width: 120px;">
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-success btn-lg btn-block shadow-sm">
                                                <i class="fas fa-cart-plus"></i> Agregar al Carrito
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Información Detallada -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary"></i> Información Detallada
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="mr-3">
                                    <i class="fas fa-dna fa-2x text-primary opacity-50"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block mb-1">Raza</small>
                                    <strong class="d-block">{{ $ganado->raza->nombre ?? 'No especificada' }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="mr-3">
                                    <i class="fas fa-birthday-cake fa-2x text-warning opacity-50"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block mb-1">Edad</small>
                                    <strong class="d-block">{{ $ganado->edad ?? '—' }} meses</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="mr-3">
                                    <i class="fas fa-weight fa-2x text-info opacity-50"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block mb-1">Tipo de Peso</small>
                                    <strong class="d-block">{{ $ganado->tipoPeso->nombre ?? '—' }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="mr-3">
                                    <i class="fas fa-venus-mars fa-2x text-danger opacity-50"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block mb-1">Sexo</small>
                                    <strong class="d-block">{{ $ganado->sexo ?? '—' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($ganado->descripcion)
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-align-left"></i> Descripción
                            </h6>
                            <p class="mb-0 text-dark">{{ $ganado->descripcion }}</p>
                        </div>
                    @endif

                    @if($ganado->datoSanitario)
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-syringe text-success"></i> Datos Sanitarios
                            </h6>
                            <div class="row">
                                @if($ganado->datoSanitario->vacunado_fiebre_aftosa || $ganado->datoSanitario->vacunado_antirabica)
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block mb-2">Vacunaciones Específicas</small>
                                        @if($ganado->datoSanitario->vacunado_fiebre_aftosa)
                                            <span class="badge badge-success badge-lg mr-2 mb-2">
                                                <i class="fas fa-check-circle"></i> Vacunado de Libre de Fiebre Aftosa
                                            </span>
                                        @endif
                                        @if($ganado->datoSanitario->vacunado_antirabica)
                                            <span class="badge badge-success badge-lg mr-2 mb-2">
                                                <i class="fas fa-check-circle"></i> Vacunado de Antirrábica
                                            </span>
                                        @endif
                                    </div>
                                @endif
                                @if($ganado->datoSanitario->vacuna)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Otras Vacunas</small>
                                        <strong>{{ $ganado->datoSanitario->vacuna }}</strong>
                                    </div>
                                @endif
                                @if($ganado->datoSanitario->tratamiento)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Tratamiento</small>
                                        <strong>{{ $ganado->datoSanitario->tratamiento }}</strong>
                                    </div>
                                @endif
                                @if($ganado->datoSanitario->medicamento)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Medicamento</small>
                                        <strong>{{ $ganado->datoSanitario->medicamento }}</strong>
                                    </div>
                                @endif
                                @if($ganado->datoSanitario->fecha_aplicacion)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Fecha de Aplicación</small>
                                        <strong>{{ \Carbon\Carbon::parse($ganado->datoSanitario->fecha_aplicacion)->format('d/m/Y') }}</strong>
                                    </div>
                                @endif
                                @if($ganado->datoSanitario->proxima_fecha)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Próxima Fecha</small>
                                        <strong>{{ \Carbon\Carbon::parse($ganado->datoSanitario->proxima_fecha)->format('d/m/Y') }}</strong>
                                    </div>
                                @endif
                                @if($ganado->datoSanitario->veterinario)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Veterinario</small>
                                        <strong>{{ $ganado->datoSanitario->veterinario }}</strong>
                                    </div>
                                @endif
                                @if($ganado->datoSanitario->observaciones)
                                    <div class="col-12 mb-2">
                                        <small class="text-muted d-block">Observaciones</small>
                                        <p class="mb-0">{{ $ganado->datoSanitario->observaciones }}</p>
                                    </div>
                                @endif
                                @if($ganado->datoSanitario->certificado_imagen)
                                    <div class="col-12 mb-2">
                                        <small class="text-muted d-block mb-2">Certificado de Vacunación SENASAG</small>
                                        <a href="{{ asset('storage/'.$ganado->datoSanitario->certificado_imagen) }}" 
                                           target="_blank" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-file-image"></i> Ver Certificado
                                        </a>
                                        <img src="{{ asset('storage/'.$ganado->datoSanitario->certificado_imagen) }}" 
                                             alt="Certificado SENASAG" 
                                             class="img-thumbnail mt-2" 
                                             style="max-width: 200px; cursor: pointer;"
                                             onclick="window.open('{{ asset('storage/'.$ganado->datoSanitario->certificado_imagen) }}', '_blank')"
                                             title="Click para ver imagen completa">
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($ganado->datoSanitario->destino_matadero_campo || $ganado->datoSanitario->hoja_ruta_foto || $ganado->datoSanitario->marca_ganado || $ganado->datoSanitario->senal_numero)
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-road text-primary"></i> Guía de Movimiento del Animal
                            </h6>
                            <div class="row">
                                @if($ganado->datoSanitario->destino_matadero_campo)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Destino (Matadero o Campo)</small>
                                        <strong>{{ $ganado->datoSanitario->destino_matadero_campo }}</strong>
                                    </div>
                                @endif
                                @if($ganado->datoSanitario->marca_ganado)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Marca del Ganado</small>
                                        <strong>{{ $ganado->datoSanitario->marca_ganado }}</strong>
                                    </div>
                                @endif
                                @if($ganado->datoSanitario->senal_numero)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Señal o #</small>
                                        <strong>{{ $ganado->datoSanitario->senal_numero }}</strong>
                                    </div>
                                @endif
                                @if($ganado->datoSanitario->hoja_ruta_foto)
                                    <div class="col-12 mb-2">
                                        <small class="text-muted d-block mb-2">Hoja de Ruta</small>
                                        <a href="{{ asset('storage/'.$ganado->datoSanitario->hoja_ruta_foto) }}" 
                                           target="_blank" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-road"></i> Ver Hoja de Ruta
                                        </a>
                                        <img src="{{ asset('storage/'.$ganado->datoSanitario->hoja_ruta_foto) }}" 
                                             alt="Hoja de Ruta" 
                                             class="img-thumbnail mt-2" 
                                             style="max-width: 200px; cursor: pointer;"
                                             onclick="window.open('{{ asset('storage/'.$ganado->datoSanitario->hoja_ruta_foto) }}', '_blank')"
                                             title="Click para ver imagen completa">
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($ganado->datoSanitario->nombre_dueño || $ganado->datoSanitario->carnet_dueño_foto)
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-user text-info"></i> Información del Dueño
                            </h6>
                            <div class="row">
                                @if($ganado->datoSanitario->nombre_dueño)
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Nombre del Dueño</small>
                                        <strong>{{ $ganado->datoSanitario->nombre_dueño }}</strong>
                                    </div>
                                @endif
                                @if($ganado->datoSanitario->carnet_dueño_foto)
                                    <div class="col-12 mb-2">
                                        <small class="text-muted d-block mb-2">Carnet del Dueño</small>
                                        <a href="{{ asset('storage/'.$ganado->datoSanitario->carnet_dueño_foto) }}" 
                                           target="_blank" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-id-card"></i> Ver Carnet
                                        </a>
                                        <img src="{{ asset('storage/'.$ganado->datoSanitario->carnet_dueño_foto) }}" 
                                             alt="Carnet Dueño" 
                                             class="img-thumbnail mt-2" 
                                             style="max-width: 200px; cursor: pointer;"
                                             onclick="window.open('{{ asset('storage/'.$ganado->datoSanitario->carnet_dueño_foto) }}', '_blank')"
                                             title="Click para ver imagen completa">
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Ubicación -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marker-alt text-danger"></i> Ubicación
                    </h5>
                </div>
                <div class="card-body">
                    @if($ganado->ubicacion)
                        <p class="mb-2">
                            <i class="fas fa-location-dot text-danger"></i> 
                            <strong>{{ $ganado->ubicacion }}</strong>
                        </p>
                    @else
                        <p class="text-muted mb-2">Sin ubicación especificada</p>
                    @endif
                    @if($ganado->latitud && $ganado->longitud)
                        <small class="text-muted d-block mb-3">
                            <i class="fas fa-globe"></i> 
                            Lat: {{ $ganado->latitud }}, Lng: {{ $ganado->longitud }}
                        </small>
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#mapModal">
                            <i class="fas fa-map"></i> Ver Mapa
                        </button>
                    @endif
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt text-info"></i> Fechas
                    </h5>
                </div>
                <div class="card-body">
                    @if($ganado->fecha_publicacion)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Fecha de Publicación</small>
                            <strong>{{ \Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y') }}</strong>
                        </div>
                    @endif
                    <div>
                        <small class="text-muted d-block mb-1">Fecha de Registro</small>
                        <strong>{{ $ganado->created_at->format('d/m/Y H:i') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal del Mapa -->
@if($ganado->latitud && $ganado->longitud)
<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel">
                    <i class="fas fa-map-marker-alt text-danger"></i> Ubicación del Anuncio
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div id="map" style="height: 500px; width: 100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    var mapGanado = null;
    
    // Inicializar el mapa cuando se abra el modal
    $('#mapModal').on('shown.bs.modal', function () {
        if (!mapGanado) {
            mapGanado = L.map('map').setView([{{ $ganado->latitud }}, {{ $ganado->longitud }}], 12);

            // Capa gratuita de OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'OpenStreetMap'
            }).addTo(mapGanado);

            // Agregar marcador en la ubicación
            var marker = L.marker([{{ $ganado->latitud }}, {{ $ganado->longitud }}]).addTo(mapGanado);
            
            // Agregar popup con información
            marker.bindPopup('<b>{{ $ganado->nombre }}</b><br>{{ $ganado->ubicacion ?? "Ubicación del ganado" }}').openPopup();
        } else {
            mapGanado.invalidateSize();
        }
    });
</script>
@endif

@endsection
