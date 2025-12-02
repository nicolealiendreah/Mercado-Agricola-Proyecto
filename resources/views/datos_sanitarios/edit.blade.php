@extends('layouts.adminlte')

@section('title','Editar Registro Sanitario')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">
                <i class="fas fa-edit text-primary"></i> Editar Registro Sanitario
            </h1>
            <p class="text-muted mb-0">Actualice la información del registro sanitario</p>
        </div>
        <a href="{{ route('admin.datos-sanitarios.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
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

    <form action="{{ route('admin.datos-sanitarios.update', $datoSanitario->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Sección: Información del Animal -->
        <div class="card shadow-sm mb-4 border-left-primary">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-cow text-primary"></i> Información del Animal
                </h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="font-weight-bold">
                        <i class="fas fa-paw text-primary"></i> Animal
                    </label>
                    <select name="ganado_id" class="form-control form-control-lg">
                        <option value="">Sin animal asignado (opcional)...</option>
                        @foreach($ganados as $g)
                            <option value="{{ $g->id }}" {{ $datoSanitario->ganado_id == $g->id ? 'selected' : '' }}>
                                {{ $g->nombre }}
                                @if($g->tipoAnimal)
                                    - {{ $g->tipoAnimal->nombre }}
                                @endif
                                @if($g->raza)
                                    ({{ $g->raza->nombre }})
                                @endif
                                @if($g->edad)
                                    - {{ $g->edad }} meses
                                @endif
                                @if(!$g->fecha_publicacion)
                                    [Sin publicar]
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Sección: Vacunaciones -->
        <div class="card shadow-sm mb-4 border-left-success">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-syringe text-success"></i> Vacunaciones
                </h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="font-weight-bold">
                        <i class="fas fa-vial text-success"></i> Otras Vacunas
                    </label>
                            <input type="text" name="vacuna" class="form-control" value="{{ $datoSanitario->vacuna ?? '' }}" placeholder="Ej: Triple, Brucelosis, etc. (opcional)">
                </div>

                <div class="form-group">
                    <label class="font-weight-bold d-block mb-3">
                        <i class="fas fa-check-double text-success"></i> Vacunaciones Específicas
                    </label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox custom-control-lg mb-3">
                                <input type="checkbox" class="custom-control-input" name="vacunado_fiebre_aftosa" id="vacunado_fiebre_aftosa" value="1"
                                       {{ $datoSanitario->vacunado_fiebre_aftosa ? 'checked' : '' }}>
                                <label class="custom-control-label" for="vacunado_fiebre_aftosa">
                                    <i class="fas fa-shield-alt text-success"></i> 
                                    <strong>Vacunado de Libre de Fiebre Aftosa</strong>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox custom-control-lg mb-3">
                                <input type="checkbox" class="custom-control-input" name="vacunado_antirabica" id="vacunado_antirabica" value="1"
                                       {{ $datoSanitario->vacunado_antirabica ? 'checked' : '' }}>
                                <label class="custom-control-label" for="vacunado_antirabica">
                                    <i class="fas fa-shield-alt text-success"></i> 
                                    <strong>Vacunado de Antirrábica</strong>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: Tratamientos y Medicamentos -->
        <div class="card shadow-sm mb-4 border-left-info">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-pills text-info"></i> Tratamientos y Medicamentos
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-stethoscope text-info"></i> Tratamiento
                            </label>
                            <input type="text" name="tratamiento" class="form-control" value="{{ $datoSanitario->tratamiento ?? '' }}" placeholder="Sin datos">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-capsules text-info"></i> Medicamento
                            </label>
                            <input type="text" name="medicamento" class="form-control" value="{{ $datoSanitario->medicamento ?? '' }}" placeholder="Sin datos">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-calendar-check text-info"></i> Fecha de Aplicación
                            </label>
                            <input type="date" name="fecha_aplicacion" class="form-control" value="{{ $datoSanitario->fecha_aplicacion ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-calendar-alt text-info"></i> Próxima Fecha
                            </label>
                            <input type="date" name="proxima_fecha" class="form-control" value="{{ $datoSanitario->proxima_fecha ?? '' }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">
                        <i class="fas fa-user-md text-info"></i> Veterinario
                    </label>
                    <input type="text" name="veterinario" class="form-control" value="{{ $datoSanitario->veterinario ?? '' }}" placeholder="Sin datos">
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">
                        <i class="fas fa-comment-alt text-info"></i> Observaciones
                    </label>
                    <textarea name="observaciones" class="form-control" rows="4" placeholder="Sin datos">{{ $datoSanitario->observaciones ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Sección: Certificado SENASAG -->
        <div class="card shadow-sm mb-4 border-left-warning">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-certificate text-warning"></i> Certificado de Vacunación SENASAG
                </h5>
            </div>
            <div class="card-body">
                @if($datoSanitario->certificado_imagen)
                    <div class="mb-3 p-3 bg-light rounded">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-image text-warning fa-2x mr-3"></i>
                            <div>
                                <strong>Certificado Actual</strong>
                                <p class="text-muted mb-0 small">Click en la imagen para ver en tamaño completo</p>
                            </div>
                        </div>
                        <img src="{{ asset('storage/'.$datoSanitario->certificado_imagen) }}" 
                             alt="Certificado SENASAG" 
                             class="img-thumbnail" 
                             style="max-width: 300px; max-height: 300px; cursor: pointer;"
                             onclick="window.open('{{ asset('storage/'.$datoSanitario->certificado_imagen) }}', '_blank')"
                             title="Click para ver imagen completa">
                    </div>
                @endif
                <div class="form-group">
                    <label class="font-weight-bold">
                        <i class="fas fa-file-image text-warning"></i> 
                        @if($datoSanitario->certificado_imagen)
                            Actualizar Imagen del Certificado
                        @else
                            Imagen del Certificado
                        @endif
                    </label>
                    <div class="custom-file">
                        <input type="file" name="certificado_imagen" class="custom-file-input" id="certificado_imagen" accept="image/*">
                        <label class="custom-file-label" for="certificado_imagen">
                            <i class="fas fa-upload"></i> 
                            @if($datoSanitario->certificado_imagen)
                                Deje vacío para mantener la imagen actual o seleccione una nueva...
                            @else
                                Seleccione una imagen...
                            @endif
                        </label>
                    </div>
                    <small class="form-text text-muted mt-2">
                        <i class="fas fa-info-circle"></i> Tamaño máximo: 5MB. Formatos: JPG, PNG, GIF
                    </small>
                </div>
            </div>
        </div>

        <!-- Sección: Marca del Animal -->
        <div class="card shadow-sm mb-4 border-left-primary">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-tag text-primary"></i> Marca del Animal
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-tag text-primary"></i> Marca del Ganado
                            </label>
                            <input type="text" name="marca_ganado" class="form-control" 
                                   value="{{ $datoSanitario->marca_ganado ?? '' }}" placeholder="Sin datos">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-hashtag text-primary"></i> Señal o #
                            </label>
                            <input type="text" name="senal_numero" class="form-control" 
                                   value="{{ $datoSanitario->senal_numero ?? '' }}" placeholder="Sin datos">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-image text-primary"></i> Foto de la Marca
                            </label>
                            @if($datoSanitario->marca_ganado_foto)
                                <div class="mb-2 p-2 bg-light rounded">
                                    <img src="{{ asset('storage/'.$datoSanitario->marca_ganado_foto) }}" 
                                         alt="Foto de la Marca" 
                                         class="img-thumbnail" 
                                         style="max-width: 200px; max-height: 200px; cursor: pointer;"
                                         onclick="window.open('{{ asset('storage/'.$datoSanitario->marca_ganado_foto) }}', '_blank')"
                                         title="Click para ver imagen completa">
                                </div>
                            @endif
                            <div class="custom-file">
                                <input type="file" name="marca_ganado_foto" class="custom-file-input" id="marca_ganado_foto" accept="image/*">
                                <label class="custom-file-label" for="marca_ganado_foto">
                                    <i class="fas fa-upload"></i> 
                                    @if($datoSanitario->marca_ganado_foto)
                                        Deje vacío para mantener la imagen actual o seleccione una nueva...
                                    @else
                                        Seleccione una imagen de la marca...
                                    @endif
                                </label>
                            </div>
                            <small class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle"></i> Tamaño máximo: 5MB. Formatos: JPG, PNG, GIF
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: Información del Dueño -->
        <div class="card shadow-sm mb-4 border-left-info">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-user text-info"></i> Información del Dueño
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-user-circle text-info"></i> Nombre del Dueño
                            </label>
                            <input type="text" name="nombre_dueño" class="form-control" 
                                   value="{{ $datoSanitario->nombre_dueño ?? '' }}" placeholder="Sin datos">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-id-card text-info"></i> Foto del Carnet del Dueño
                            </label>
                            @if($datoSanitario->carnet_dueño_foto)
                                <div class="mb-2 p-2 bg-light rounded">
                                    <img src="{{ asset('storage/'.$datoSanitario->carnet_dueño_foto) }}" 
                                         alt="Carnet Dueño" 
                                         class="img-thumbnail" 
                                         style="max-width: 200px; max-height: 200px; cursor: pointer;"
                                         onclick="window.open('{{ asset('storage/'.$datoSanitario->carnet_dueño_foto) }}', '_blank')"
                                         title="Click para ver imagen completa">
                                </div>
                            @endif
                            <div class="custom-file">
                                <input type="file" name="carnet_dueño_foto" class="custom-file-input" id="carnet_dueño_foto" accept="image/*">
                                <label class="custom-file-label" for="carnet_dueño_foto">
                                    <i class="fas fa-upload"></i> 
                                    @if($datoSanitario->carnet_dueño_foto)
                                        Deje vacío para mantener la imagen actual o seleccione una nueva...
                                    @else
                                        Seleccione una imagen...
                                    @endif
                                </label>
                            </div>
                            <small class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle"></i> Tamaño máximo: 5MB. Formatos: JPG, PNG, GIF
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.datos-sanitarios.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Actualizar Registro Sanitario
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Actualizar labels de archivos seleccionados
document.getElementById('certificado_imagen').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Seleccione una imagen...';
    e.target.nextElementSibling.innerHTML = '<i class="fas fa-file-image"></i> ' + fileName;
});

document.getElementById('hoja_ruta_foto').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Seleccione una imagen...';
    e.target.nextElementSibling.innerHTML = '<i class="fas fa-file-image"></i> ' + fileName;
});

document.getElementById('marca_ganado_foto').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Seleccione una imagen...';
    e.target.nextElementSibling.innerHTML = '<i class="fas fa-file-image"></i> ' + fileName;
});

document.getElementById('carnet_dueño_foto').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Seleccione una imagen...';
    e.target.nextElementSibling.innerHTML = '<i class="fas fa-file-image"></i> ' + fileName;
});
</script>

<style>
.border-left-primary {
    border-left: 4px solid #007bff !important;
}
.border-left-success {
    border-left: 4px solid #28a745 !important;
}
.border-left-info {
    border-left: 4px solid #17a2b8 !important;
}
.border-left-warning {
    border-left: 4px solid #ffc107 !important;
}
.custom-control-lg .custom-control-label::before {
    width: 1.5rem;
    height: 1.5rem;
    top: 0.25rem;
}
.custom-control-lg .custom-control-label::after {
    width: 1.5rem;
    height: 1.5rem;
    top: 0.25rem;
}
</style>
@endsection
