<?php $__env->startSection('title', 'Detalle de Maquinaria'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <style>
        /* Card derecha (título, badges, precio, botón) */
        .panel-info-card {
            height: 400px; /* igual que la imagen principal */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Cards inferiores (Información Detallada y Ubicación) */
        .panel-equal-card {
            height: 280px; /* ajusta si quieres más o menos alto */
        }

        /* En pantallas pequeñas se vuelven automáticas */
        @media (max-width: 992px) {
            .panel-info-card,
            .panel-equal-card {
                height: auto !important;
            }
        }
    </style>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">
                <i class="fas fa-tractor text-warning"></i> Detalle de Maquinaria
            </h1>
            <p class="text-muted mb-0">Información completa del producto</p>
        </div>
        <a href="<?php echo e(url()->previous() !== url()->current() ? url()->previous() : route('maquinarias.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="row">
        <!-- Galería de Imágenes -->
        <div class="col-lg-5 mb-4">
            <?php if($maquinaria->imagenes && $maquinaria->imagenes->count() > 0): ?>
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body p-0">
                        <div class="position-relative" style="overflow: hidden; border-radius: 8px 8px 0 0; background:#fff;">
                            
                            <div class="d-flex justify-content-center align-items-center" style="height: 400px;">
                                <img id="mainImage" 
                                     src="<?php echo e(asset('storage/'.$maquinaria->imagenes->first()->ruta)); ?>" 
                                     alt="<?php echo e($maquinaria->nombre); ?>" 
                                     style="max-height: 100%; max-width: 100%; object-fit: contain; cursor: pointer;"
                                     data-toggle="modal"
                                     data-target="#imageModal"
                                     onclick="document.getElementById('imageModalImg').src = this.src"
                                     title="Click para ver imagen completa">
                            </div>

                            <div class="position-absolute" style="top:10px; right:10px;">
                                <span class="badge badge-success badge-lg">
                                    <i class="fas fa-image"></i> Click para ampliar
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if($maquinaria->imagenes->count() > 1): ?>
                    <div class="row">
                        <?php $__currentLoopData = $maquinaria->imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-4 mb-2">
                                
                                <div class="bg-white border rounded d-flex align-items-center justify-content-center" style="height: 90px;">
                                    <img src="<?php echo e(asset('storage/'.$imagen->ruta)); ?>" 
                                         alt="Imagen <?php echo e($loop->iteration); ?>" 
                                         style="max-height: 100%; max-width: 100%; object-fit: contain; cursor: pointer; transition: opacity .2s;"
                                         onclick="
                                            document.getElementById('mainImage').src = this.src;
                                            document.getElementById('imageModalImg').src = this.src;
                                         "
                                         onmouseover="this.style.opacity='0.7'" 
                                         onmouseout="this.style.opacity='1'"
                                         title="Click para ver">
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
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
                    <h2 class="h4 mb-3 text-dark"><?php echo e($maquinaria->nombre); ?></h2>
                    
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                        <?php if($maquinaria->tipoMaquinaria): ?>
                            <span class="badge badge-warning badge-lg px-3 py-2">
                                <i class="fas fa-cog"></i> <?php echo e($maquinaria->tipoMaquinaria->nombre); ?>

                            </span>
                        <?php endif; ?>
                        <?php if($maquinaria->marcaMaquinaria): ?>
                            <span class="badge badge-info badge-lg px-3 py-2">
                                <i class="fas fa-tag"></i> <?php echo e($maquinaria->marcaMaquinaria->nombre); ?>

                            </span>
                        <?php endif; ?>
                        <?php if($maquinaria->estadoMaquinaria): ?>
                            <span class="badge badge-primary badge-lg px-3 py-2">
                                <i class="fas fa-check-circle"></i> <?php echo e($maquinaria->estadoMaquinaria->nombre); ?>

                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if($maquinaria->precio_dia): ?>
                        <div class="bg-warning-light p-4 rounded mb-3" style="background-color: #fff3cd;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block mb-1">Precio por día</small>
                                    <h3 class="h4 mb-0 text-warning font-weight-bold">
                                        Bs <?php echo e(number_format($maquinaria->precio_dia, 2)); ?>/día
                                    </h3>
                                </div>
                                <div class="text-right">
                                    <i class="fas fa-calendar-day fa-3x text-warning opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(auth()->guard()->check()): ?>
                        <?php if($maquinaria->precio_dia): ?>
                            <div class="border-top pt-4">
                                <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_type" value="maquinaria">
                                    <input type="hidden" name="product_id" value="<?php echo e($maquinaria->id); ?>">
                                    <div class="form-row align-items-end">
                                        <div class="col-auto">
                                            <label class="small font-weight-bold text-muted mb-2 d-block">Días de alquiler</label>
                                            <input type="number" 
                                                   name="dias_alquiler" 
                                                   class="form-control form-control-lg" 
                                                   value="1" 
                                                   min="1" 
                                                   required
                                                   style="width: 150px;">
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
            <div class="card shadow-sm border-0 mb-4 panel-equal-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary"></i> Información Detallada
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if($maquinaria->modelo): ?>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="mr-3">
                                        <i class="fas fa-tag fa-2x text-primary opacity-50"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block mb-1">Modelo</small>
                                        <strong class="d-block"><?php echo e($maquinaria->modelo); ?></strong>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($maquinaria->telefono): ?>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="mr-3">
                                        <i class="fas fa-phone fa-2x text-success opacity-50"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block mb-1">Teléfono de Contacto</small>
                                        <strong class="d-block">
                                            <a href="tel:<?php echo e($maquinaria->telefono); ?>" class="text-dark">
                                                <?php echo e($maquinaria->telefono); ?>

                                            </a>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($maquinaria->descripcion): ?>
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-align-left"></i> Descripción
                            </h6>
                            <p class="mb-0 text-dark"><?php echo e($maquinaria->descripcion); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Ubicación -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marker-alt text-danger"></i> Ubicación
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($maquinaria->ciudad || $maquinaria->municipio || $maquinaria->departamento): ?>
                        <div class="mb-3">
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <strong>Ciudad:</strong>
                                </div>
                                <div class="col-md-9">
                                    <?php echo e($maquinaria->ciudad ?? $maquinaria->municipio ?? 'No disponible'); ?>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Dirección:</strong>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                        $direccion = [];
                                        if($maquinaria->municipio) $direccion[] = $maquinaria->municipio;
                                        if($maquinaria->provincia) $direccion[] = 'Provincia ' . $maquinaria->provincia;
                                        if($maquinaria->departamento) $direccion[] = $maquinaria->departamento;
                                        $direccion[] = 'Bolivia';
                                        $direccionCompleta = implode(', ', $direccion);
                                    ?>
                                    <?php echo e($direccionCompleta); ?>

                                </div>
                            </div>
                        </div>
                    <?php elseif($maquinaria->ubicacion): ?>
                        <p class="mb-2">
                            <i class="fas fa-location-dot text-danger"></i> 
                            <strong><?php echo e($maquinaria->ubicacion); ?></strong>
                        </p>
                    <?php else: ?>
                        <p class="text-muted mb-2">Sin ubicación especificada</p>
                    <?php endif; ?>
                    <?php if($maquinaria->latitud && $maquinaria->longitud): ?>
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#mapModal">
                            <i class="fas fa-map"></i> Ver Mapa
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal del Mapa -->
<?php if($maquinaria->latitud && $maquinaria->longitud): ?>
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
                <div id="map-maquinaria-modal" style="height: 500px; width: 100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
window.addEventListener('load', function() {
    $(document).ready(function() {
        let mapMaquinaria = null;
        
        <?php
            $popupText = $maquinaria->nombre;
            if($maquinaria->ciudad || $maquinaria->municipio) {
                $popupText .= ' - ' . ($maquinaria->ciudad ?? $maquinaria->municipio);
            }
            if($maquinaria->municipio || $maquinaria->provincia || $maquinaria->departamento) {
                $direccion = [];
                if($maquinaria->municipio) $direccion[] = $maquinaria->municipio;
                if($maquinaria->provincia) $direccion[] = 'Provincia ' . $maquinaria->provincia;
                if($maquinaria->departamento) $direccion[] = $maquinaria->departamento;
                $direccion[] = 'Bolivia';
                $popupText .= ' - ' . implode(', ', $direccion);
            } elseif($maquinaria->ubicacion) {
                $popupText .= ' - ' . $maquinaria->ubicacion;
            }
        ?>

        function initMap() {
            if (typeof L === 'undefined') {
                console.error('Leaflet no está disponible');
                return false;
            }
            
            try {
                mapMaquinaria = L.map('map-maquinaria-modal').setView(
                    [<?php echo e($maquinaria->latitud); ?>, <?php echo e($maquinaria->longitud); ?>],
                    12
                );

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapMaquinaria);

                L.marker([<?php echo e($maquinaria->latitud); ?>, <?php echo e($maquinaria->longitud); ?>])
                    .addTo(mapMaquinaria)
                    .bindPopup("<?php echo e(addslashes($popupText)); ?>");
                
                return true;
            } catch (error) {
                console.error('Error al inicializar el mapa:', error);
                return false;
            }
        }

        $('#mapModal').on('shown.bs.modal', function () {
            if (!mapMaquinaria) {
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
                    mapMaquinaria.invalidateSize();
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

            <button type="button" class="close text-white ml-auto mr-2 mt-2" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="modal-body p-0 text-center">
                <img id="imageModalImg" src="" class="img-fluid rounded"
                     style="max-height: 80vh; object-fit: contain;">
            </div>

        </div>
    </div>
</div>

<style>
.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
}
.bg-warning-light {
    background-color: #fff3cd !important;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/maquinarias/show.blade.php ENDPATH**/ ?>