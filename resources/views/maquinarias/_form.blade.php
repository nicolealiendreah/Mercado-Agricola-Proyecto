@csrf
<div class="form-group"><label>Nombre *</label>
  <input name="nombre" class="form-control" value="{{ old('nombre', $maquinaria->nombre ?? '') }}" required>
</div>
<div class="form-group">
    <label>Categoría *</label>
    <select name="categoria_id" class="form-control" required>
        <option value="">Seleccione una categoría</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}"
                {{ old('categoria_id', $maquinaria->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Tipo de Maquinaria *</label>
    <select name="tipo_maquinaria_id" class="form-control" required>
        <option value="">Seleccione un tipo de maquinaria</option>
        @foreach($tipo_maquinarias as $tipo)
            <option value="{{ $tipo->id }}"
                {{ old('tipo_maquinaria_id', $maquinaria->tipo_maquinaria_id ?? '') == $tipo->id ? 'selected' : '' }}>
                {{ $tipo->nombre }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label>Marca de Maquinaria *</label>
    <select name="marca_maquinaria_id" class="form-control" required>
        <option value="">Seleccione una marca de maquinaria</option>
        @foreach($marcas_maquinarias as $marca)
            <option value="{{ $marca->id }}"
                {{ old('marca_maquinaria_id', $maquinaria->marca_maquinaria_id ?? '') == $marca->id ? 'selected' : '' }}>
                {{ $marca->nombre }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group"><label>Modelo</label>
  <input name="modelo" class="form-control" value="{{ old('modelo', $maquinaria->modelo ?? '') }}">
</div>
<div class="form-group"><label>Precio por día *</label>
  <input type="number" step="0.01" name="precio_dia" class="form-control" value="{{ old('precio_dia', $maquinaria->precio_dia ?? 0) }}" required>
</div>
<div class="form-group"><label>Estado *</label>
  <select name="estado" class="form-control" required>
    @foreach(['disponible','en_mantenimiento','dado_baja'] as $e)
      <option value="{{ $e }}" @selected(old('estado', $maquinaria->estado ?? '')==$e)>{{ $e }}</option>
    @endforeach
  </select>
</div>
<div class="form-group"><label>Descripción</label>
  <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $maquinaria->descripcion ?? '') }}</textarea>
</div>
<button class="btn btn-success">Guardar</button>
<a href="{{ route('maquinarias.index') }}" class="btn btn-secondary">Volver</a>
