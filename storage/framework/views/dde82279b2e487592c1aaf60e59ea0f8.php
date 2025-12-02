<?php $__env->startSection('title', 'Detalle de Ganado'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
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
        <a href="<?php echo e(url()->previous() !== url()->current() ? url()->previous() : route('ganados.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="row">
        <!-- Galería de Imágenes -->
        <div class="col-lg-5 mb-4">
            <?php if($ganado->imagenes && $ganado->imagenes->count() > 0): ?>
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body p-0">
                        <div class="position-relative bg-white d-flex justify-content-center align-items-center" 
                             style="height: 450px; border-radius: 8px;">
                            <img id="imagen-principal" 
                                 src="<?php echo e(asset('storage/'.$ganado->imagenes->first()->ruta)); ?>" 
                                 alt="<?php echo e($ganado->nombre); ?>" 
                                 style="max-height: 100%; max-width: 100%; object-fit: contain; cursor: pointer;"
                                 data-toggle="modal"
                                 data-target="#imageModal"
                                 onclick="document.getElementById('imageModalImg').src = this.src"
                                 title="Click para ver imagen completa">
                            <div class="position-absolute" style="top:10px; right:10px;">
                                <span class="badge badge-success badge-lg">
                                    <i class="fas fa-image"></i> Click para ampliar
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if($ganado->imagenes->count() > 1): ?>
                    <div class="row">
                        <?php $__currentLoopData = $ganado->imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-4 mb-2">
                                <div class="bg-white border rounded d-flex align-items-center justify-content-center" 
                                     style="height: 90px; cursor: pointer; transition: all 0.2s;"
                                     onclick="
                                        document.getElementById('imagen-principal').src = '<?php echo e(asset('storage/'.$imagen->ruta)); ?>';
                                        document.getElementById('imageModalImg').src = '<?php echo e(asset('storage/'.$imagen->ruta)); ?>';
                                     "
                                     onmouseover="this.style.borderColor='#28a745'; this.style.transform='scale(1.05)'" 
                                     onmouseout="this.style.borderColor='#dee2e6'; this.style.transform='scale(1)'">
                                    <img src="<?php echo e(asset('storage/'.$imagen->ruta)); ?>" 
                                         alt="Imagen <?php echo e($loop->iteration); ?>" 
                                         style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            <?php elseif($ganado->imagen): ?>
                <!-- Compatibilidad con imagen antigua -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="position-relative bg-white d-flex justify-content-center align-items-center" 
                             style="height: 450px; border-radius: 8px;">
                            <img src="<?php echo e(asset('storage/'.$ganado->imagen)); ?>" 
                                 alt="Imagen de <?php echo e($ganado->nombre); ?>" 
                                 style="max-height: 100%; max-width: 100%; object-fit: contain; cursor: pointer;"
                                 onclick="window.open('<?php echo e(asset('storage/'.$ganado->imagen)); ?>', '_blank')"
                                 title="Click para ver imagen completa">
                            <div class="position-absolute" style="top:10px; right:10px;">
                                <span class="badge badge-success badge-lg">
                                    <i class="fas fa-image"></i> Click para ampliar
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 450px;">
                            <div class="text-center text-muted">
                                <i class="fas fa-image fa-4x mb-3"></i>
                                <p class="mb-0">Sin imágenes disponibles</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Información Principal -->
        <div class="col-lg-7">
            <!-- Título y Precio -->
            <div class="card shadow-sm border-0 mb-4 panel-info-card">
                <div class="card-body">
                    <h2 class="h4 mb-3 text-dark"><?php echo e($ganado->nombre); ?></h2>
                    
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                        <span class="badge badge-success badge-lg px-3 py-2">
                            <i class="fas fa-tag"></i> <?php echo e($ganado->categoria->nombre ?? 'Sin categoría'); ?>

                        </span>
                        <?php if($ganado->tipoAnimal): ?>
                            <span class="badge badge-info badge-lg px-3 py-2">
                                <i class="fas fa-paw"></i> <?php echo e($ganado->tipoAnimal->nombre); ?>

                            </span>
                        <?php endif; ?>
                        <?php if($ganado->stock ?? 0 > 0): ?>
                            <span class="badge badge-primary badge-lg px-3 py-2">
                                <i class="fas fa-box"></i> Stock: <?php echo e($ganado->stock); ?>

                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if($ganado->precio): ?>
                        <div class="bg-success-light p-4 rounded mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block mb-1">Precio</small>
                                    <h3 class="h4 mb-0 text-success font-weight-bold">
                                        Bs <?php echo e(number_format($ganado->precio, 2)); ?>

                                    </h3>
                                </div>
                                <div class="text-right">
                                    <i class="fas fa-money-bill-wave fa-3x text-success opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle"></i> Precio a consultar
                        </div>
                    <?php endif; ?>

                    <?php if(auth()->guard()->check()): ?>
                        <?php if($ganado->precio && ($ganado->stock ?? 0) > 0): ?>
                            <div class="border-top pt-4">
                                <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_type" value="ganado">
                                    <input type="hidden" name="product_id" value="<?php echo e($ganado->id); ?>">
                                    <div class="form-row align-items-end">
                                        <div class="col-auto">
                                            <label class="small font-weight-bold text-muted mb-2 d-block">Cantidad</label>
                                            <input type="number" 
                                                   name="cantidad" 
                                                   class="form-control form-control-lg" 
                                                   value="1" 
                                                   min="1" 
                                                   max="<?php echo e($ganado->stock ?? 1); ?>" 
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
                        <?php endif; ?>
                    <?php endif; ?>
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
                                    <strong class="d-block"><?php echo e($ganado->raza->nombre ?? 'No especificada'); ?></strong>
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
                                    <strong class="d-block"><?php echo e($ganado->edad ?? '—'); ?> meses</strong>
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
                                    <strong class="d-block"><?php echo e($ganado->tipoPeso->nombre ?? '—'); ?></strong>
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
                                    <strong class="d-block"><?php echo e($ganado->sexo ?? '—'); ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if($ganado->descripcion): ?>
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-align-left"></i> Descripción
                            </h6>
                            <p class="mb-0 text-dark"><?php echo e($ganado->descripcion); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if($ganado->datoSanitario): ?>
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-syringe text-success"></i> Datos Sanitarios
                            </h6>
                            <div class="row">
                                <?php if($ganado->datoSanitario->vacunado_fiebre_aftosa || $ganado->datoSanitario->vacunado_antirabica): ?>
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block mb-2">Vacunaciones Específicas</small>
                                        <?php if($ganado->datoSanitario->vacunado_fiebre_aftosa): ?>
                                            <span class="badge badge-success badge-lg mr-2 mb-2">
                                                <i class="fas fa-check-circle"></i> Vacunado de Libre de Fiebre Aftosa
                                            </span>
                                        <?php endif; ?>
                                        <?php if($ganado->datoSanitario->vacunado_antirabica): ?>
                                            <span class="badge badge-success badge-lg mr-2 mb-2">
                                                <i class="fas fa-check-circle"></i> Vacunado de Antirrábica
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->vacuna): ?>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Otras Vacunas</small>
                                        <strong><?php echo e($ganado->datoSanitario->vacuna); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->tratamiento): ?>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Tratamiento</small>
                                        <strong><?php echo e($ganado->datoSanitario->tratamiento); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->medicamento): ?>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Medicamento</small>
                                        <strong><?php echo e($ganado->datoSanitario->medicamento); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->fecha_aplicacion): ?>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Fecha de Aplicación</small>
                                        <strong><?php echo e(\Carbon\Carbon::parse($ganado->datoSanitario->fecha_aplicacion)->format('d/m/Y')); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->proxima_fecha): ?>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Próxima Fecha</small>
                                        <strong><?php echo e(\Carbon\Carbon::parse($ganado->datoSanitario->proxima_fecha)->format('d/m/Y')); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->veterinario): ?>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Veterinario</small>
                                        <strong><?php echo e($ganado->datoSanitario->veterinario); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->observaciones): ?>
                                    <div class="col-12 mb-2">
                                        <small class="text-muted d-block">Observaciones</small>
                                        <p class="mb-0"><?php echo e($ganado->datoSanitario->observaciones); ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->certificado_imagen): ?>
                                    <div class="col-12 mb-2">
                                        <small class="text-muted d-block mb-2">Certificado de Vacunación SENASAG</small>
                                        <a href="<?php echo e(asset('storage/'.$ganado->datoSanitario->certificado_imagen)); ?>" 
                                           target="_blank" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-file-image"></i> Ver Certificado
                                        </a>
                                        <img src="<?php echo e(asset('storage/'.$ganado->datoSanitario->certificado_imagen)); ?>" 
                                             alt="Certificado SENASAG" 
                                             class="img-thumbnail mt-2" 
                                             style="max-width: 200px; cursor: pointer;"
                                             onclick="window.open('<?php echo e(asset('storage/'.$ganado->datoSanitario->certificado_imagen)); ?>', '_blank')"
                                             title="Click para ver imagen completa">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if($ganado->datoSanitario->marca_ganado || $ganado->datoSanitario->senal_numero || $ganado->datoSanitario->marca_ganado_foto): ?>
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-tag text-primary"></i> Marca del Animal
                            </h6>
                            <div class="row">
                                <?php if($ganado->datoSanitario->marca_ganado): ?>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Marca del Ganado</small>
                                        <strong><?php echo e($ganado->datoSanitario->marca_ganado); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->senal_numero): ?>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Señal o #</small>
                                        <strong><?php echo e($ganado->datoSanitario->senal_numero); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->marca_ganado_foto): ?>
                                    <div class="col-12 mb-2">
                                        <small class="text-muted d-block mb-2">Foto de la Marca</small>
                                        <a href="<?php echo e(asset('storage/'.$ganado->datoSanitario->marca_ganado_foto)); ?>" 
                                           target="_blank" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-image"></i> Ver Foto Marca
                                        </a>
                                        <img src="<?php echo e(asset('storage/'.$ganado->datoSanitario->marca_ganado_foto)); ?>" 
                                             alt="Foto de la Marca" 
                                             class="img-thumbnail mt-2" 
                                             style="max-width: 200px; cursor: pointer;"
                                             onclick="window.open('<?php echo e(asset('storage/'.$ganado->datoSanitario->marca_ganado_foto)); ?>', '_blank')"
                                             title="Click para ver imagen completa">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($ganado->datoSanitario->nombre_dueño || $ganado->datoSanitario->carnet_dueño_foto): ?>
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-user text-info"></i> Información del Dueño
                            </h6>
                            <div class="row">
                                <?php if($ganado->datoSanitario->nombre_dueño): ?>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted d-block">Nombre del Dueño</small>
                                        <strong><?php echo e($ganado->datoSanitario->nombre_dueño); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($ganado->datoSanitario->carnet_dueño_foto): ?>
                                    <div class="col-12 mb-2">
                                        <small class="text-muted d-block mb-2">Carnet del Dueño</small>
                                        <a href="<?php echo e(asset('storage/'.$ganado->datoSanitario->carnet_dueño_foto)); ?>" 
                                           target="_blank" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-id-card"></i> Ver Carnet
                                        </a>
                                        <img src="<?php echo e(asset('storage/'.$ganado->datoSanitario->carnet_dueño_foto)); ?>" 
                                             alt="Carnet Dueño" 
                                             class="img-thumbnail mt-2" 
                                             style="max-width: 200px; cursor: pointer;"
                                             onclick="window.open('<?php echo e(asset('storage/'.$ganado->datoSanitario->carnet_dueño_foto)); ?>', '_blank')"
                                             title="Click para ver imagen completa">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
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
                    <?php if($ganado->ciudad || $ganado->municipio || $ganado->departamento): ?>
                        <div class="mb-3">
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <strong>Ciudad:</strong>
                                </div>
                                <div class="col-md-9">
                                    <?php echo e($ganado->ciudad ?? $ganado->municipio ?? 'No disponible'); ?>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Dirección:</strong>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                        $direccion = [];
                                        if($ganado->municipio) $direccion[] = $ganado->municipio;
                                        if($ganado->provincia) $direccion[] = 'Provincia ' . $ganado->provincia;
                                        if($ganado->departamento) $direccion[] = $ganado->departamento;
                                        $direccion[] = 'Bolivia';
                                        $direccionCompleta = implode(', ', $direccion);
                                    ?>
                                    <?php echo e($direccionCompleta); ?>

                                </div>
                            </div>
                        </div>
                    <?php elseif($ganado->ubicacion): ?>
                        <p class="mb-2">
                            <i class="fas fa-location-dot text-danger"></i> 
                            <strong><?php echo e($ganado->ubicacion); ?></strong>
                        </p>
                    <?php else: ?>
                        <p class="text-muted mb-2">Sin ubicación especificada</p>
                    <?php endif; ?>
                    <?php if($ganado->latitud && $ganado->longitud): ?>
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#mapModal">
                            <i class="fas fa-map"></i> Ver Mapa
                        </button>
                    <?php endif; ?>
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
                    <?php if($ganado->fecha_publicacion): ?>
                        <div>
                            <small class="text-muted d-block mb-1">Fecha de Publicación</small>
                            <strong><?php echo e(\Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y')); ?></strong>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">Sin fecha de publicación</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal del Mapa -->
<?php if($ganado->latitud && $ganado->longitud): ?>
<div class="modal fade" id="mapModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-map-marker-alt text-danger"></i> Ubicación del Anuncio
                </h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-0">
                <div id="map-ganado-modal" style="height:500px; width:100%;"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Esperar a que todo esté cargado
window.addEventListener('load', function() {
    $(document).ready(function() {
        let mapGanado = null;
        
        <?php
            $popupText = $ganado->nombre;
            if($ganado->ciudad || $ganado->municipio) {
                $popupText .= ' - ' . ($ganado->ciudad ?? $ganado->municipio);
            }
            if($ganado->municipio || $ganado->provincia || $ganado->departamento) {
                $direccion = [];
                if($ganado->municipio) $direccion[] = $ganado->municipio;
                if($ganado->provincia) $direccion[] = 'Provincia ' . $ganado->provincia;
                if($ganado->departamento) $direccion[] = $ganado->departamento;
                $direccion[] = 'Bolivia';
                $popupText .= ' - ' . implode(', ', $direccion);
            } elseif($ganado->ubicacion) {
                $popupText .= ' - ' . $ganado->ubicacion;
            }
        ?>

        function initMap() {
            if (typeof L === 'undefined') {
                console.error('Leaflet no está disponible');
                return false;
            }
            
            try {
                mapGanado = L.map('map-ganado-modal').setView(
                    [<?php echo e($ganado->latitud); ?>, <?php echo e($ganado->longitud); ?>],
                    12
                );

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapGanado);

                L.marker([<?php echo e($ganado->latitud); ?>, <?php echo e($ganado->longitud); ?>])
                    .addTo(mapGanado)
                    .bindPopup("<?php echo e(addslashes($popupText)); ?>");
                
                return true;
            } catch (error) {
                console.error('Error al inicializar el mapa:', error);
                return false;
            }
        }

        $('#mapModal').on('shown.bs.modal', function () {
            if (!mapGanado) {
                // Esperar a que el modal esté completamente visible
                setTimeout(function() {
                    if (!initMap()) {
                        // Si falla, reintentar después de un momento
                        setTimeout(initMap, 500);
                    }
                }, 200);
            } else {
                // Si el mapa ya existe, solo invalidar el tamaño
                setTimeout(function() {
                    mapGanado.invalidateSize();
                }, 100);
            }
        });
    });
});
</script>
<?php endif; ?>


<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <button type="button" class="close text-white ml-auto mr-2 mt-2" data-dismiss="modal" aria-label="Close" style="font-size: 2rem; z-index: 1051;">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0 text-center">
                <img id="imageModalImg" src="" class="img-fluid rounded"
                     style="max-height: 80vh; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/ganados/show.blade.php ENDPATH**/ ?>