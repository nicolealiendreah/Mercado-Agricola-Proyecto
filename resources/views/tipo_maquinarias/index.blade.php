@extends('layouts.adminlte')

@section('title', 'Tipos de Maquinaria')
@section('page_title', 'Tipos de Maquinaria')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title mb-0">Tipos de Maquinaria</h3>

        <form method="get" class="form-inline ml-auto">
            <input type="text" name="q" class="form-control form-control-sm mr-2" placeholder="Buscar..." value="{{ $q ?? '' }}">
            <button class="btn btn-sm btn-primary">Buscar</button>
        </form>

        <a href="{{ route('tipo_maquinarias.create') }}" class="btn btn-sm btn-success ml-2">
            <i class="fas fa-plus"></i> Nuevo
        </a>
    </div>

    <div class="card-body p-0">
        @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show m-3">
            <i class="fas fa-check-circle"></i> {{ session('ok') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th class="text-right pr-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td><strong>{{ $item->nombre }}</strong></td>
                    <td>{{ $item->descripcion ?? '—' }}</td>
                    <td class="text-right pr-3">
                        <a href="{{ route('tipo_maquinarias.edit', $item) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('tipo_maquinarias.destroy', $item) }}" method="post" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este tipo de maquinaria?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle"></i> No hay tipos de maquinaria registrados.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $items->links() }}
    </div>
</div>
@endsection

