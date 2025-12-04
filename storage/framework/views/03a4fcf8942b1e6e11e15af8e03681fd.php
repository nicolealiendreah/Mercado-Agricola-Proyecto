<?php $__env->startSection('title', 'Detalle de Orgánico'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <style>
        .panel-info-card {
            min-height: 360px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .panel-equal-card {
            min-height: 260px;
        }

        .badge-meta {
            font-size: 0.8rem;
            border-radius: 999px;
        }

        @media (max-width: 992px) {
            .panel-info-card,
            .panel-equal-card {
                min-height: auto !important;
            }
        }
    </style>

    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">
                <i class="fas fa-leaf text-success"></i>
                Detalle de Orgánico
            </h1>
            <p class="text-muted mb-0">Información completa del producto agrícola</p>
        </div>

        <a href="<?php echo e(route('organicos.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    
    <div class="row">

        
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body p-0">

                    <div class="position-relative bg-white d-flex justify-content-center align-items-center"
                         style="height: 430px; border-radius: 8px; overflow:hidden;">

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

                        <span class="badge badge-success position-absolute"
                              style="top:10px; right:10px;">
                            <i class="fas fa-image"></i> Click para ampliar
                        </span>
                    </div>

                </div>
            </div>

            
            <?php if($organico->imagenes->count() > 1): ?>
                <div class="row">
                    <?php $__currentLoopData = $organico->imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-4 mb-2">
                            <div class="bg-white border rounded d-flex align-items-center justify-content-center"
                                 style="height:90px; cursor:pointer;"
                                 onclick="document.getElementById('mainImage').src = this.querySelector('img').src">

                                <img src="<?php echo e(asset('storage/'.$img->ruta)); ?>"
                                     style="max-height:100%; max-width:100%; object-fit:cover;">
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

        </div>

        
        <div class="col-lg-6">

            <div class="card shadow-sm border-0 mb-4 panel-info-card">
                <div class="card-body">

                    
                    <h2 class="h4 text-dark mb-2"><?php echo e($organico->nombre); ?></h2>

                    <p class="text-muted mb-3">
                        <?php if($organico->categoria): ?>
                            <?php echo e($organico->categoria->nombre); ?>

                        <?php endif; ?>

                        <?php if($organico->tipoCultivo): ?>
                            • <?php echo e($organico->tipoCultivo->nombre); ?>

                        <?php endif; ?>
                    </p>

                    <div class="mb-3">
                        <?php if($organico->categoria): ?>
                            <span class="badge badge-success px-3 py-2 mr-1 badge-meta">
                                <i class="fas fa-tag"></i> <?php echo e($organico->categoria->nombre); ?>

                            </span>
                        <?php endif; ?>

                        <?php if($organico->tipoCultivo): ?>
                            <span class="badge badge-warning px-3 py-2 mr-1 badge-meta">
                                <i class="fas fa-seedling"></i> <?php echo e($organico->tipoCultivo->nombre); ?>

                            </span>
                        <?php endif; ?>

                        <?php if($organico->unidad): ?>
                            <span class="badge badge-info px-3 py-2 badge-meta">
                                <i class="fas fa-balance-scale"></i> <?php echo e($organico->unidad->nombre); ?>

                            </span>
                        <?php endif; ?>
                    </div>

                    
                    <div class="p-3 mb-3 rounded" style="background:#e8f5e9;">
                        <small class="text-muted d-block mb-1">Precio</small>
                        <h3 class="h4 text-success font-weight-bold mb-1">
                            Bs <?php echo e(number_format($organico->precio, 2)); ?>

                        </h3>
                        <small class="text-muted">
                            <?php if($organico->unidad): ?>
                                Precio por <?php echo e(strtolower($organico->unidad->nombre)); ?>.
                            <?php else: ?>
                                Precio unitario.
                            <?php endif; ?>
                        </small>
                    </div>

                    <div class="d-flex flex-wrap mb-3">
                        <div class="mr-4 mb-2">
                            <small class="text-muted d-block">Stock disponible</small>
                            <span class="font-weight-bold">
                                <?php echo e($organico->stock); ?> <?php echo e($organico->unidad ? strtolower($organico->unidad->nombre) : 'unidades'); ?>

                            </span>
                        </div>

                        <?php if($organico->user): ?>
                            <div class="mb-2">
                                <small class="text-muted d-block">Productor</small>
                                <span class="font-weight-bold">
                                    <?php echo e($organico->user->name); ?>

                                </span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($organico->created_at): ?>
                        <small class="text-muted d-block mb-3">
                            Publicado el <?php echo e($organico->created_at->format('d/m/Y')); ?>

                        </small>
                    <?php endif; ?>

                    
                    <?php if(auth()->guard()->check()): ?>
                        <?php if($organico->precio && ($organico->stock ?? 0) > 0): ?>
                            <div class="border-top pt-3 mt-3">
                                <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_type" value="organico">
                                    <input type="hidden" name="product_id" value="<?php echo e($organico->id); ?>">

                                    <div class="form-row align-items-end">
                                        <div class="col-auto">
                                            <label class="small font-weight-bold text-muted mb-1 d-block">
                                                Cantidad
                                            </label>
                                            <input type="number"
                                                   name="cantidad"
                                                   class="form-control"
                                                   value="1"
                                                   min="1"
                                                   max="<?php echo e($organico->stock ?? 1); ?>"
                                                   required
                                                   style="width: 100px;">
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-success btn-block">
                                                <i class="fas fa-cart-plus mr-1"></i> Agregar al Carrito
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php elseif(($organico->stock ?? 0) <= 0): ?>
                            <div class="alert alert-warning mt-3 mb-0">
                                <small><i class="fas fa-exclamation-triangle"></i> Sin stock disponible</small>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="mt-3 pt-2 border-top">
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-success btn-block">
                                <i class="fas fa-sign-in-alt mr-1"></i> Inicia sesión para comprar
                            </a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

    
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

                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-calendar-alt fa-2x text-primary mr-3"></i>
                                <div>
                                    <small class="text-muted d-block">Fecha de Cosecha</small>
                                    <div class="font-weight-bold">
                                        <?php echo e($organico->fecha_cosecha
                                            ? \Carbon\Carbon::parse($organico->fecha_cosecha)->format('d/m/Y')
                                            : '—'); ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-clipboard-check fa-2x text-success mr-3"></i>
                                <div>
                                    <small class="text-muted d-block">Stock</small>
                                    <div class="font-weight-bold">
                                        <?php echo e($organico->stock); ?> <?php echo e($organico->unidad ? strtolower($organico->unidad->nombre) : 'unidades'); ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-seedling fa-2x text-warning mr-3"></i>
                                <div>
                                    <small class="text-muted d-block">Tipo de Cultivo</small>
                                    <div class="font-weight-bold">
                                        <?php echo e($organico->tipoCultivo->nombre ?? '—'); ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-align-left mr-1"></i> Descripción
                        </h6>
                        <p class="text-dark mb-0">
                            <?php echo e($organico->descripcion ?: 'Sin descripción'); ?>

                        </p>
                    </div>

                </div>
            </div>

        </div>

        
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
                            <i class="fas fa-map mr-1"></i> Ver Mapa
                        </button>
                    <?php endif; ?>

                </div>
            </div>

        </div>

    </div>

</div>



<?php if($organico->latitud_origen && $organico->longitud_origen): ?>
<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-map-marker-alt text-danger"></i> Ubicación del Producto
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-0">
                
                <div id="map-organico-modal" style="height:500px; width:100%;"></div>
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
window.addEventListener('load', function () {
    $(document).ready(function () {
        let mapOrganico = null;

        function initMapOrganico() {
            if (typeof L === 'undefined') {
                console.error('Leaflet no está disponible');
                return false;
            }

            try {
                mapOrganico = L.map('map-organico-modal').setView(
                    [<?php echo e($organico->latitud_origen); ?>, <?php echo e($organico->longitud_origen); ?>],
                    15
                );

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapOrganico);

                L.marker([<?php echo e($organico->latitud_origen); ?>, <?php echo e($organico->longitud_origen); ?>])
                    .addTo(mapOrganico)
                    .bindPopup("<?php echo e(addslashes($organico->nombre)); ?>");

                return true;
            } catch (e) {
                console.error('Error al inicializar el mapa de orgánico:', e);
                return false;
            }
        }

        $('#mapModal').on('shown.bs.modal', function () {
            if (!mapOrganico) {
                // Esperar a que el modal termine de animarse
                setTimeout(function () {
                    if (!initMapOrganico()) {
                        // Si falló, reintenta
                        setTimeout(initMapOrganico, 500);
                    }
                }, 200);
            } else {
                // Si el mapa ya existe, solo corregir tamaño
                setTimeout(function () {
                    mapOrganico.invalidateSize();
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/organicos/show.blade.php ENDPATH**/ ?>