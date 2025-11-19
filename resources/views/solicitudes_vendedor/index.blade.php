@extends('layouts.adminlte')

@section('title', 'Solicitudes de Vendedor')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">
            <i class="fas fa-clipboard-list"></i> Solicitudes de Vendedor
        </h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
            <div class="card-tools">
                <form method="GET" action="{{ route('admin.solicitudes-vendedor.index') }}" class="d-inline">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <select name="estado" class="form-control" onchange="this.form.submit()">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                            <option value="aprobada" {{ request('estado') == 'aprobada' ? 'selected' : '' }}>Aprobadas</option>
                            <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazadas</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered table-striped table-hover mb-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Fecha Solicitud</th>
                        <th>Fecha Revisión</th>
                        <th>Documento</th>
                        <th style="width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->id }}</td>
                            <td>
                                <strong>{{ $solicitud->user->name }}</strong>
                                <br>
                                <small class="text-muted">Rol: {{ $solicitud->user->role_name ?? 'cliente' }}</small>
                            </td>
                            <td>{{ $solicitud->user->email }}</td>
                            <td>{{ $solicitud->telefono }}</td>
                            <td>
                                <small>{{ Str::limit($solicitud->direccion, 30) }}</small>
                            </td>
                            <td>
                                <small>{{ Str::limit($solicitud->motivo, 50) }}</small>
                            </td>
                            <td>
                                @if($solicitud->estado == 'pendiente')
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i> Pendiente
                                    </span>
                                @elseif($solicitud->estado == 'aprobada')
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> Aprobada
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i> Rechazada
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $solicitud->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td>
                                @if($solicitud->fecha_revision_admin)
                                    <small>{{ $solicitud->fecha_revision_admin->format('d/m/Y H:i') }}</small>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($solicitud->archivo_documento)
                                    <a href="{{ asset('storage/'.$solicitud->archivo_documento) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-file-download"></i> Ver
                                    </a>
                                @else
                                    <span class="text-muted">Sin documento</span>
                                @endif
                            </td>
                            <td>
                                @if($solicitud->estado == 'pendiente')
                                    <form action="{{ route('admin.solicitudes-vendedor.aprobar', $solicitud->id) }}" 
                                          method="POST" class="d-inline-block">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm btn-success mb-1"
                                                onclick="return confirm('¿Aprobar esta solicitud? El usuario {{ $solicitud->user->name ?? 'N/A' }} obtendrá rol de vendedor.')">
                                            <i class="fas fa-check"></i> Aprobar
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.solicitudes-vendedor.rechazar', $solicitud->id) }}" 
                                          method="POST" class="d-inline-block">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger mb-1"
                                                onclick="return confirm('¿Estás seguro de rechazar la solicitud de {{ $solicitud->user->name ?? 'N/A' }}?')">
                                            <i class="fas fa-times"></i> Rechazar
                                        </button>
                                    </form>
                                @else
                                    <span class="badge badge-secondary">Procesada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                <p>No hay solicitudes registradas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $solicitudes->links() }}
        </div>
    </div>
</div>
@endsection

