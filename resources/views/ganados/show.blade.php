@extends('layouts.adminlte')

@section('title', 'Detalle de Ganado')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Detalle del Ganado</h1>
        <a href="{{ route('ganados.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if($ganado->imagen)
                        <img src="{{ asset('storage/'.$ganado->imagen) }}" 
                             alt="Imagen de {{ $ganado->nombre }}" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 300px; max-width: 100%; cursor: pointer; object-fit: cover;"
                             onclick="window.open('{{ asset('storage/'.$ganado->imagen) }}', '_blank')"
                             title="Click para ver imagen completa">
                        <p class="text-muted mt-2">
                            <i class="fas fa-image"></i> Click en la imagen para ampliar
                        </p>
                    @else
                        <div class="text-muted p-5 border rounded">
                            <i class="fas fa-image fa-3x mb-2"></i>
                            <p>Sin imagen disponible</p>
                        </div>
                    @endif
                </div>

                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td>{{ $ganado->id }}</td>
                        </tr>
                        <tr>
                            <th>Nombre</th>
                            <td>{{ $ganado->nombre }}</td>
                        </tr>
                        <tr>
                            <th>Tipo de Animal</th>
                            <td>{{ $ganado->tipoAnimal->nombre ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Raza</th>
                            <td>{{ $ganado->raza->nombre ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Edad (meses)</th>
                            <td>{{ $ganado->edad ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tipo de Peso</th>
                            <td>{{ $ganado->tipoPeso->nombre ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Sexo</th>
                            <td>{{ $ganado->sexo ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Categoría</th>
                            <td>
                                <span class="badge badge-success">{{ $ganado->categoria->nombre ?? '-' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Ubicación</th>
                            <td>{{ $ganado->ubicacion ?? 'Sin ubicación' }}</td>
                        </tr>
                        @if($ganado->latitud && $ganado->longitud)
                        <tr>
                            <th>Coordenadas</th>
                            <td>
                                <small class="text-muted">
                                    Lat: {{ $ganado->latitud }}, Lng: {{ $ganado->longitud }}
                                </small>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <th>Descripción</th>
                            <td>{{ $ganado->descripcion ?? '—' }}</td>
                        </tr>
                        <tr>
                            <th>Precio (Bs)</th>
                            <td>
                                @if($ganado->precio)
                                    <span class="h5 text-success font-weight-bold">Bs {{ number_format($ganado->precio, 2) }}</span>
                                @else
                                    <span class="text-muted">Precio a consultar</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Stock (Cantidad)</th>
                            <td>
                                <span class="badge {{ ($ganado->stock ?? 0) > 0 ? 'badge-success' : 'badge-danger' }} badge-lg">
                                    {{ $ganado->stock ?? 0 }}
                                </span>
                            </td>
                        </tr>
                        @if($ganado->datoSanitario)
                        <tr>
                            <th>Datos Sanitarios</th>
                            <td>
                                <small class="text-muted">
                                    @if($ganado->datoSanitario->vacuna)
                                        <i class="fas fa-syringe"></i> Vacuna: {{ $ganado->datoSanitario->vacuna }}
                                    @endif
                                </small>
                            </td>
                        </tr>
                        @endif
                        @if($ganado->fecha_publicacion)
                        <tr>
                            <th>Fecha de Publicación</th>
                            <td>{{ \Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Fecha de Registro</th>
                            <td>{{ $ganado->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
