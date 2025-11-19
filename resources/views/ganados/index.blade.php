@extends('layouts.adminlte')

@section('title', 'Gestión de Ganado')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Lista de Ganado</h1>
        @if(auth()->check() && (auth()->user()->isVendedor() || auth()->user()->isAdmin()))
            <a href="{{ route('ganados.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Nuevo Registro
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-bordered table-striped mb-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo de Animal</th>
                        <th>Raza</th>
                        <th>Edad</th>
                        <th>Tipo de Peso</th>
                        <th>Sexo</th>
                        <th>Categoría</th>
                        <th>Ubicación</th>
                        <th>Fecha Publicación</th>
                        <th>Datos Sanitarios</th>
                        <th>Precio (Bs)</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                        <th style="width:150px;">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($ganados as $ganado)
                        <tr>
                            <td>{{ $ganado->id }}</td>
                            <td>{{ $ganado->nombre }}</td>

                            <td>{{ $ganado->tipoAnimal->nombre ?? '—' }}</td>
                            <td>{{ $ganado->raza->nombre ?? '—' }}</td>

                            <td>{{ $ganado->edad ?? '-' }} meses</td>

                            <td>{{ $ganado->tipoPeso->nombre ?? '-' }}</td>

                            <td>{{ $ganado->sexo ?? '-' }}</td>

                            <td>{{ $ganado->categoria->nombre ?? '-' }}</td>

                            <td>{{ $ganado->ubicacion ?? 'Sin ubicación' }}</td>

                            <td>
                                {{ $ganado->fecha_publicacion
                                    ? \Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y')
                                    : 'No publicada' }}
                            </td>

                            <td>
                               {{ $ganado->datoSanitario->vacuna ?? 'Sin registro' }}

                            </td>

                            <td>{{ $ganado->precio ? number_format($ganado->precio, 2) : '-' }}</td>

                            <td>
                                <span class="badge {{ ($ganado->stock ?? 0) > 0 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $ganado->stock ?? 0 }}
                                </span>
                            </td>

                            <td>
                                @if($ganado->imagen)
                                    <img src="{{ asset('storage/'.$ganado->imagen) }}" 
                                         alt="{{ $ganado->nombre }}" 
                                         class="img-thumbnail" 
                                         style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                         onclick="window.open('{{ asset('storage/'.$ganado->imagen) }}', '_blank')"
                                         title="Click para ver imagen completa">
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-image"></i> Sin imagen
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if(auth()->check() && (auth()->user()->isVendedor() || auth()->user()->isAdmin()))
                                    {{-- Solo mostrar botones si es el dueño o admin --}}
                                    @if(auth()->user()->isAdmin() || $ganado->user_id == auth()->id())
                                        <a href="{{ route('ganados.edit', $ganado->id) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('ganados.destroy', $ganado->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Eliminar este registro?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('ganados.show', $ganado->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('ganados.show', $ganado->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="16" class="text-center text-muted">
                                No hay registros de ganado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        <div class="card-footer">
            {{ $ganados->links() }}
        </div>

    </div>
</div>

@endsection
