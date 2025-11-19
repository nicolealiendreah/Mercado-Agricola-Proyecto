@extends('layouts.adminlte')
@section('content')
<div class="x_panel">
  <div class="x_title"><h2>Detalle de Maquinaria</h2></div>
  <div class="x_content">
    <dl class="row">
      <dt class="col-sm-2">Nombre</dt><dd class="col-sm-10">{{ $maquinaria->nombre }}</dd>
      <dt class="col-sm-2">Tipo de Maquinaria</dt><dd class="col-sm-10">{{ $maquinaria->tipoMaquinaria->nombre ?? '—' }}</dd>
      <dt class="col-sm-2">Marca de Maquinaria</dt><dd class="col-sm-10">{{ $maquinaria->marcaMaquinaria->nombre ?? '—' }}</dd>
      <dt class="col-sm-2">Modelo</dt><dd class="col-sm-10">{{ $maquinaria->modelo }}</dd>
      <dt class="col-sm-2">Precio por día</dt><dd class="col-sm-10">{{ number_format($maquinaria->precio_dia,2) }}</dd>
      <dt class="col-sm-2">Estado</dt><dd class="col-sm-10">{{ $maquinaria->estado }}</dd>
      <dt class="col-sm-2">Descripción</dt><dd class="col-sm-10">{{ $maquinaria->descripcion }}</dd>
    </dl>
    <a class="btn btn-secondary" href="{{ route('maquinarias.index') }}">Volver</a>
  </div>
</div>
@endsection
