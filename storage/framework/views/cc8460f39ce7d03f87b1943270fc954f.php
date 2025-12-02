<?php $__env->startSection('title', 'Listado de Animales'); ?>
<?php $__env->startSection('page_title', 'Listado de Animales'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .animals-header {
    background: var(--agro) !important;
    color: white;
    padding: 2rem;
    border-radius: 15px 15px 0 0;
    margin-bottom: 0;
  }

  .animal-card {
    border: 1px solid #e9ecef;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .animal-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    transform: translateY(-4px);
  }

  .animal-image-wrapper {
    width: 100%;
    height: 220px;
    background: #f8f9fa;
    border-radius: 12px;
    border: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    overflow: hidden;
    cursor: pointer;
  }

  .animal-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; /* se ve completa */
    transition: transform 0.3s ease;
  }

  .animal-image-wrapper:hover .animal-image {
    transform: scale(1.03);
  }

  .animal-info h5 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
  }

  .info-badge {
    padding: 0.25rem 0.6rem;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 500;
    margin-right: 0.25rem;
    margin-bottom: 0.25rem;
    display: inline-block;
  }

  .price-tag {
    font-size: 1.4rem;
    font-weight: 700;
    color: #28a745;
  }

  .stock-badge {
    font-size: 0.9rem;
    padding: 0.35rem 0.8rem;
    border-radius: 999px;
  }

  .info-row {
    display: flex;
    align-items: center;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
  }

  .info-row i {
    width: 18px;
    color: #6c757d;
    margin-right: 0.35rem;
  }

  .action-buttons {
    display: flex;
    gap: 0.4rem;
    flex-wrap: wrap;
  }

  .btn-action {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
  }

  .btn-action:hover {
    transform: translateY(-2px);
  }

  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
  }

  .empty-state i {
    font-size: 5rem;
    color: #dee2e6;
    margin-bottom: 1.5rem;
  }

  @media (max-width: 768px) {
    .animal-card {
      padding: 1rem;
    }

    .animal-image-wrapper {
      height: 180px;
    }
  }
</style>

<div class="container-fluid">
  <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
    <div class="animals-header">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h3 class="mb-1" style="font-weight: 700;">
            <i class="fas fa-cow mr-2"></i>Listado de Animales
          </h3>
          <p class="mb-0 text-white-50">
            <i class="fas fa-list mr-1"></i><?php echo e($ganados->total() ?? $ganados->count()); ?> 
            <?php echo e(($ganados->total() ?? $ganados->count()) == 1 ? 'animal registrado' : 'animales registrados'); ?>

          </p>
        </div>
        <?php if(auth()->check() && (auth()->user()->isVendedor() || auth()->user()->isAdmin())): ?>
          <a href="<?php echo e(route('ganados.create')); ?>" class="btn btn-light btn-lg">
            <i class="fas fa-plus-circle mr-2"></i>Nuevo Registro
          </a>
        <?php endif; ?>
      </div>
    </div>

    <div class="card-body p-4">
      <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle mr-2"></i><?php echo e(session('success')); ?>

          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle mr-2"></i><?php echo e(session('error')); ?>

          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <?php if($ganados->count() > 0): ?>
        <div class="row">
          <?php $__currentLoopData = $ganados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ganado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="animal-card">

                
                <div class="animal-image-wrapper"
                     <?php if($ganado->imagen): ?>
                       onclick="window.open('<?php echo e(asset('storage/'.$ganado->imagen)); ?>', '_blank')"
                       title="Click para ver imagen completa"
                     <?php endif; ?>>
                  <?php if($ganado->imagen): ?>
                    <img src="<?php echo e(asset('storage/'.$ganado->imagen)); ?>"
                         alt="<?php echo e($ganado->nombre); ?>"
                         class="animal-image">
                  <?php else: ?>
                    <i class="fas fa-image fa-3x text-muted"></i>
                  <?php endif; ?>
                </div>

                
                <div class="animal-info mb-3">
                  <h5 class="d-flex align-items-center justify-content-between">
                    <span>
                      <i class="fas fa-tag text-primary mr-2"></i><?php echo e($ganado->nombre); ?>

                    </span>
                    <span class="badge badge-secondary ml-2">#<?php echo e($ganado->id); ?></span>
                  </h5>

                  <div class="mb-2">
                    <?php if($ganado->tipoAnimal): ?>
                      <span class="info-badge badge-info">
                        <i class="fas fa-paw mr-1"></i><?php echo e($ganado->tipoAnimal->nombre); ?>

                      </span>
                    <?php endif; ?>
                    <?php if($ganado->raza): ?>
                      <span class="info-badge badge-secondary">
                        <i class="fas fa-dna mr-1"></i><?php echo e($ganado->raza->nombre); ?>

                      </span>
                    <?php endif; ?>
                    <?php if($ganado->categoria): ?>
                      <span class="info-badge badge-success">
                        <i class="fas fa-tags mr-1"></i><?php echo e($ganado->categoria->nombre); ?>

                      </span>
                    <?php endif; ?>
                  </div>

                  <div class="info-row">
                    <i class="fas fa-birthday-cake"></i>
                    <span><strong>Edad:</strong> <?php echo e($ganado->edad ?? 'N/A'); ?> meses</span>
                  </div>

                  <div class="info-row">
                    <i class="fas fa-venus-mars"></i>
                    <span><strong>Sexo:</strong> <?php echo e($ganado->sexo ?? 'N/A'); ?></span>
                  </div>

                  <?php if($ganado->tipoPeso): ?>
                    <div class="info-row">
                      <i class="fas fa-weight-hanging"></i>
                      <span><strong>Peso:</strong> <?php echo e($ganado->tipoPeso->nombre); ?></span>
                    </div>
                  <?php endif; ?>

                  <div class="info-row">
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="text-muted">
                      <?php echo e(Str::limit($ganado->ubicacion ?? 'Sin ubicación', 45)); ?>

                    </span>
                  </div>

                  <?php if($ganado->fecha_publicacion): ?>
                    <div class="info-row">
                      <i class="fas fa-calendar-check"></i>
                      <span class="text-success">
                        <strong>Publicado:</strong> <?php echo e(\Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y')); ?>

                      </span>
                    </div>
                  <?php else: ?>
                    <div class="info-row">
                      <i class="fas fa-calendar-times"></i>
                      <span class="text-warning"><strong>No publicado</strong></span>
                    </div>
                  <?php endif; ?>

                  <?php if($ganado->datoSanitario): ?>
                    <div class="info-row">
                      <i class="fas fa-syringe"></i>
                      <span class="text-info">
                        <strong>Datos sanitarios:</strong> <?php echo e(Str::limit($ganado->datoSanitario->vacuna ?? 'Registrado', 40)); ?>

                      </span>
                    </div>
                  <?php else: ?>
                    <div class="info-row">
                      <i class="fas fa-syringe"></i>
                      <span class="text-muted">Sin registro sanitario</span>
                    </div>
                  <?php endif; ?>
                </div>

                
                <div class="mt-auto">
                  <?php if($ganado->precio): ?>
                    <div class="mb-2">
                      <span class="text-muted small d-block">Precio</span>
                      <div class="price-tag">Bs <?php echo e(number_format($ganado->precio, 2)); ?></div>
                    </div>
                  <?php endif; ?>

                  <div class="mb-3">
                    <span class="text-muted small d-block">Stock disponible</span>
                    <span class="stock-badge badge <?php echo e(($ganado->stock ?? 0) > 0 ? 'badge-success' : 'badge-danger'); ?>">
                      <i class="fas fa-boxes mr-1"></i><?php echo e($ganado->stock ?? 0); ?> unidades
                    </span>
                  </div>

                  <div class="action-buttons">
                    <a href="<?php echo e(route('ganados.show', $ganado->id)); ?>" 
                       class="btn btn-info btn-action" 
                       title="Ver detalles">
                      <i class="fas fa-eye"></i>
                    </a>

                    <?php if(auth()->check() && (auth()->user()->isVendedor() || auth()->user()->isAdmin())): ?>
                      <?php if(auth()->user()->isAdmin() || $ganado->user_id == auth()->id()): ?>
                        <a href="<?php echo e(route('ganados.edit', $ganado->id)); ?>"
                           class="btn btn-warning btn-action"
                           title="Editar">
                          <i class="fas fa-edit"></i>
                        </a>

                        <form action="<?php echo e(route('ganados.destroy', $ganado->id)); ?>"
                              method="POST" 
                              class="d-inline"
                              id="deleteForm<?php echo e($ganado->id); ?>">
                          <?php echo csrf_field(); ?>
                          <?php echo method_field('DELETE'); ?>
                          <button type="button" 
                                  class="btn btn-danger btn-action"
                                  onclick="confirmDelete(<?php echo e($ganado->id); ?>)"
                                  title="Eliminar">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>
                </div>

              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-4">
          <?php echo e($ganados->links()); ?>

        </div>
      <?php else: ?>
        <div class="empty-state">
          <i class="fas fa-cow"></i>
          <h3 class="text-muted mb-3">No hay animales registrados</h3>
          <p class="text-muted mb-4">Comienza agregando tu primer animal al sistema</p>
          <?php if(auth()->check() && (auth()->user()->isVendedor() || auth()->user()->isAdmin())): ?>
            <a href="<?php echo e(route('ganados.create')); ?>" class="btn btn-success btn-lg">
              <i class="fas fa-plus-circle mr-2"></i>Agregar Primer Animal
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
function confirmDelete(ganadoId) {
  if (confirm('¿Estás seguro de eliminar este animal? Esta acción no se puede deshacer.')) {
    document.getElementById('deleteForm' + ganadoId).submit();
  }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adminlte', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/ganados/index.blade.php ENDPATH**/ ?>