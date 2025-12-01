<?php $__env->startSection('title', 'Detalle de Orgánico'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <style>
        /* Tarjeta derecha (nombre, categoría, precio) */
        .panel-info-card {
            height: 430px; /* igual a la altura de la imagen principal */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Tarjetas inferiores (Información Detallada y Ubicación) */
        .panel-equal-card {
            height: 280px; /* ajusta si quieres más o menos alto */
        }

        /* En pantallas pequeñas que se adapte normal */
        @media (max-width: 992px) {
            .panel-info-card,
            .panel-equal-card {
                height: auto !important;
            }
        }
    </style>

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">
                <i class="fas fa-leaf text-success"></i> Detalle de Orgánico
            </h1>
            <p class="text-muted mb-0">Información completa del producto</p>
        </div>

        <a href="<?php echo e(route('organicos.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="row">

        <!-- IMAGEN PRINCIPAL -->
        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body p-0">

                    <div class="position-relative bg-white d-flex justify-content-center align-items-center" 
                         style="height: 430px; border-radius: 8px;">
                        
                        <?php if($organico->imagenes->count()): ?>
                            <img id="mainImage" 
                                 src="<?php echo e(asset('storage/'.$organico->imagenes->first()->ruta)); ?>"
                                 style="max-height:100%; max-width:100%; object-fit:contain; cursor:pointer;"
                                 data-toggle="modal" 
                                 data-target="#imageModal"
                                 onclick="document.getElementById('imageModalImg').src = this.src">
                        <?php else: ?>
                            <img src="<?php echo e(asset('img/organico-placeholder.jpg')); ?>"
                                 style="max-height:100%; max-width:100%; object-fit:contain;">
                        <?php endif; ?>

                        <span class="badge badge-success position-absolute" style="top:10px; right:10px;">
                            <i class="fas fa-image"></i> Click para ampliar
                        </span>
                    </div>

                </div>
            </div>

            <!-- Miniaturas -->
            <?php if($organico->imagenes->count() > 1): ?>
                <div class="row">
                    <?php $__currentLoopData = $organico->imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-4 mb-2">
                            <div class="bg-white border rounded d-flex align-items-center justify-content-center"
                                 style="height:90px; cursor:pointer;"
                                 onclick="document.getElementById('mainImage').src = this.querySelector('img').src">

                                <img src="<?php echo e(asset('storage/'.$img->ruta)); ?>"
                                     style="max-height:100%; max-width:100%; object-fit:contain;">
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

        </div> <!-- END LEFT -->

        <!-- INFO PRINCIPAL -->
        <div class="col-lg-6">

            <div class="card shadow-sm border-0 mb-4 panel-info-card">
                <div class="card-body">

                    <h2 class="h4 text-dark mb-3"><?php echo e($organico->nombre); ?></h2>

                    <!-- Badges -->
                    <div class="mb-3">
                        <?php if($organico->categoria): ?>
                            <span class="badge badge-success px-3 py-2">
                                <i class="fas fa-tag"></i> <?php echo e($organico->categoria->nombre); ?>

                            </span>
                        <?php endif; ?>

                        <?php if($organico->unidad): ?>
                            <span class="badge badge-info px-3 py-2">
                                <i class="fas fa-balance-scale"></i> <?php echo e($organico->unidad->nombre); ?>

                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Precio -->
                    <div class="p-3 mb-3 rounded" style="background:#e8f5e9;">
                        <small class="text-muted d-block mb-1">Precio</small>
                        <h3 class="h4 text-success font-weight-bold">
                            Bs <?php echo e(number_format($organico->precio, 2)); ?>

                        </h3>
                    </div>

                </div>
            </div>

        </div> <!-- END RIGHT -->
    </div>

    <!-- INFORMACIÓN DETALLADA -->
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

                        <!-- Fecha de cosecha -->
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-calendar-alt fa-2x text-primary mr-3"></i>
                                <div>
                                    <small class="text-muted">Fecha de Cosecha</small>
                                    <div class="font-weight-bold">
                                        <?php echo e($organico->fecha_cosecha 
                                            ? \Carbon\Carbon::parse($organico->fecha_cosecha)->format('d/m/Y') 
                                            : '—'); ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stock -->
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-clipboard-check fa-2x text-success mr-3"></i>
                                <div>
                                    <small class="text-muted">Stock</small>
                                    <div class="font-weight-bold"><?php echo e($organico->stock); ?> unidades</div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Descripción -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-align-left"></i> Descripción
                        </h6>
                        <p class="text-dark">
                            <?php echo e($organico->descripcion ?: 'Sin descripción'); ?>

                        </p>
                    </div>

                </div>
            </div>

        </div>

        <!-- UBICACIÓN -->
        <div class="col-lg-4">

            <div class="card shadow-sm border-0 mb-4 panel-equal-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marker-alt text-danger"></i> Ubicación
                    </h5>
                </div>

                <div class="card-body">

                    <p class="mb-2">
                        <?php if($organico->origen): ?>
                            <?php echo e($organico->origen); ?>

                        <?php elseif($organico->latitud_origen && $organico->longitud_origen): ?>
                            Lat: <?php echo e($organico->latitud_origen); ?>, Lng: <?php echo e($organico->longitud_origen); ?>

                        <?php else: ?>
                            <span class="text-muted">No registrada</span>
                        <?php endif; ?>
                    </p>

                    <?php if($organico->latitud_origen && $organico->longitud_origen): ?>
                        <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#mapModal">
                            <i class="fas fa-map"></i> Ver Mapa
                        </button>
                    <?php endif; ?>

                </div>
            </div>

        </div>

    </div>

</div>

<!-- MODAL MAPA -->
<?php if($organico->latitud_origen && $organico->longitud_origen): ?>
<div class="modal fade" id="mapModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-map-marker-alt text-danger"></i> Ubicación del Producto
                </h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body p-0">
                <div id="map-organico" style="height:500px; width:100%;"></div>
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
let map;

$('#mapModal').on('shown.bs.modal', function () {
    if (!map) {
        map = L.map('map-organico').setView(
            [<?php echo e($organico->latitud_origen); ?>, <?php echo e($organico->longitud_origen); ?>],
            16
        );

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
        { maxZoom: 19 }).addTo(map);

        L.marker([<?php echo e($organico->latitud_origen); ?>, <?php echo e($organico->longitud_origen); ?>])
            .addTo(map)
            .bindPopup("<?php echo e($organico->nombre); ?>");
    } else {
        map.invalidateSize();
    }
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proy2\ProyectoAgricolaLocal\resources\views/organicos/show.blade.php ENDPATH**/ ?>