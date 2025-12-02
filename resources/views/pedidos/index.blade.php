@extends('layouts.adminlte')

@section('title', 'Mis Pedidos')
@section('page_title', 'Mis Pedidos')

@section('content')
<div class="container-fluid">
  <div class="card shadow-sm">
    <div class="card-header">
      <h3 class="card-title"><i class="fas fa-receipt mr-2"></i>Mis Pedidos</h3>
    </div>
    <div class="card-body">
      @if($pedidos->count())
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Fecha</th>
              <th>Total</th>
              <th>Estado</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          @foreach($pedidos as $pedido)
            <tr>
              <td>{{ $pedido->id }}</td>
              <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
              <td>Bs {{ number_format($pedido->total, 2) }}</td>
              <td><span class="badge badge-info text-uppercase">{{ $pedido->estado }}</span></td>
              <td>
                <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-eye mr-1"></i>Ver
                </a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>

        {{ $pedidos->links() }}
      @else
        <p class="text-muted mb-0">Aún no tienes pedidos.</p>
      @endif
    </div>
  </div>
</div>
@endsection
