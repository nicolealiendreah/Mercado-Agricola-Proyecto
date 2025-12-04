<?php $__env->startSection('title','Anuncios'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .ganado-card {
    transition: all 0.3s ease;
    border: 3px solid #28a745 !important;
    background: #ffffff;
  }
  
  .ganado-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(40, 167, 69, 0.3) !important;
    border-color: #1e7e34 !important;
  }
  
  .ganado-img {
    transition: transform 0.3s ease;
  }
  
  .ganado-card:hover .ganado-img {
    transform: scale(1.05);
  }
  
  .card-img-wrapper {
    position: relative;
    overflow: hidden;
  }
  
  .badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
  }
  
  .bg-success-light {
    background-color: #d4edda !important;
  }
  
  .border-success {
    border-color: #28a745 !important;
  }
</style>
<section class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-success mb-0">
      <i class="fas fa-bullhorn"></i> Anuncios
    </h2>
    <?php if(auth()->guard()->check()): ?>
      <?php if(auth()->user()->isVendedor() || auth()->user()->isAdmin()): ?>
        <div class="btn-group">
          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-plus-circle"></i> Publicar Anuncio
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="<?php echo e(route('ganados.create')); ?>">
              <i class="fas fa-cow"></i> Publicar Animal
            </a>
            <a class="dropdown-item" href="<?php echo e(route('maquinarias.create')); ?>">
              <i class="fas fa-tractor"></i> Publicar Maquinaria
            </a>
            <a class="dropdown-item" href="<?php echo e(route('organicos.create')); ?>">
              <i class="fas fa-leaf"></i> Publicar Orgánico
            </a>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <form method="GET" action="<?php echo e(route('ads.index')); ?>" class="row align-items-end">
        <div class="col-md-4 mb-2">
          <label class="small font-weight-bold mb-1">Categoría</label>
          <select name="categoria_id" class="form-control">
            <option value="">Todas las categorías</option>
            <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($categoria->id); ?>" <?php echo e(request('categoria_id') == $categoria->id ? 'selected' : ''); ?>>
                <?php echo e($categoria->nombre); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="col-md-6 mb-2">
          <label class="small font-weight-bold mb-1">Buscar</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text bg-success text-white"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" name="q" class="form-control" placeholder="Buscar productos, marcas, lugares..." value="<?php echo e(request('q')); ?>">
          </div>
        </div>
        <div class="col-md-2 mb-2">
          <button type="submit" class="btn btn-success btn-block">
            <i class="fas fa-search"></i> Buscar
          </button>
        </div>
      </form>
      <?php if(request()->has('q') || request()->has('categoria_id')): ?>
        <div class="mt-2">
          <a href="<?php echo e(route('ads.index')); ?>" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-times"></i> Limpiar filtros
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  
  <?php if(auth()->guard()->check()): ?>
    <?php if((auth()->user()->isVendedor() || auth()->user()->isAdmin()) && ($misGanados->count() > 0 || $misMaquinarias->count() > 0 || $misOrganicos->count() > 0)): ?>
      <div class="card shadow-sm mb-4 border-primary">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">
            <i class="fas fa-user-circle"></i> Mis Publicaciones
            <small class="ml-2">(<?php echo e($misGanados->count() + $misMaquinarias->count() + $misOrganicos->count()); ?> total)</small>
          </h4>
        </div>
        <div class="card-body">
          
          <?php if($misGanados->count() > 0): ?>
            <div class="mb-4">
              <h5 class="text-primary mb-3">
                <i class="fas fa-cow"></i> Mis Animales (<?php echo e($misGanados->count()); ?>)
              </h5>
              <div class="row">
                <?php $__currentLoopData = $misGanados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ganado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 shadow-sm border-left-primary">
                      <?php
                        $imagenPrincipal = $ganado->imagenes->first()->ruta ?? $ganado->imagen ?? null;
                      ?>
                      <?php if($imagenPrincipal): ?>
                        <img src="<?php echo e(asset('storage/'.$imagenPrincipal)); ?>" 
                             class="card-img-top" 
                             style="height:150px; object-fit:cover;"
                             alt="<?php echo e($ganado->nombre); ?>">
                      <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:150px;">
                          <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                      <?php endif; ?>
                      <div class="card-body p-2">
                        <h6 class="card-title mb-1"><?php echo e($ganado->nombre); ?></h6>
                        <p class="card-text text-muted small mb-1">
                          <i class="fas fa-tag"></i> <?php echo e($ganado->categoria->nombre ?? 'Sin categoría'); ?>

                        </p>
                        <?php if($ganado->fecha_publicacion): ?>
                          <p class="card-text text-muted small mb-1">
                            <i class="fas fa-calendar-alt"></i> <?php echo e(\Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y')); ?>

                          </p>
                        <?php endif; ?>
                        <?php if($ganado->precio): ?>
                          <p class="mb-1"><strong class="text-success">Bs <?php echo e(number_format($ganado->precio, 2)); ?></strong></p>
                        <?php endif; ?>
                      </div>
                      <div class="card-footer bg-white p-2">
                        <div class="btn-group btn-group-sm w-100">
                          <a href="<?php echo e(route('ganados.show', $ganado->id)); ?>" class="btn btn-info">
                            <i class="fas fa-eye"></i> Ver
                          </a>
                          <a href="<?php echo e(route('ganados.edit', $ganado->id)); ?>" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          <?php endif; ?>

          
          <?php if($misMaquinarias->count() > 0): ?>
            <div class="mb-4">
              <h5 class="text-primary mb-3">
                <i class="fas fa-tractor"></i> Mis Maquinarias (<?php echo e($misMaquinarias->count()); ?>)
              </h5>
              <div class="row">
                <?php $__currentLoopData = $misMaquinarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maquinaria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 shadow-sm border-left-info">
                      <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:150px;">
                        <i class="fas fa-tractor fa-4x text-success"></i>
                      </div>
                      <div class="card-body p-2">
                        <h6 class="card-title mb-1"><?php echo e($maquinaria->nombre); ?></h6>
                        <p class="card-text text-muted small mb-1">
                          <i class="fas fa-tag"></i> <?php echo e($maquinaria->categoria->nombre ?? 'Sin categoría'); ?>

                        </p>
                        <?php if($maquinaria->precio_dia): ?>
                          <p class="mb-1"><strong class="text-success">Bs <?php echo e(number_format($maquinaria->precio_dia, 2)); ?>/día</strong></p>
                        <?php endif; ?>
                      </div>
                      <div class="card-footer bg-white p-2">
                        <div class="btn-group btn-group-sm w-100">
                          <a href="<?php echo e(route('maquinarias.show', $maquinaria->id)); ?>" class="btn btn-info">
                            <i class="fas fa-eye"></i> Ver
                          </a>
                          <a href="<?php echo e(route('maquinarias.edit', $maquinaria->id)); ?>" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          <?php endif; ?>

          
          <?php if($misOrganicos->count() > 0): ?>
            <div class="mb-4">
              <h5 class="text-primary mb-3">
                <i class="fas fa-leaf"></i> Mis Orgánicos (<?php echo e($misOrganicos->count()); ?>)
              </h5>
              <div class="row">
                <?php $__currentLoopData = $misOrganicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 shadow-sm border-left-success">
                      <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:150px;">
                        <i class="fas fa-leaf fa-4x text-success"></i>
                      </div>
                      <div class="card-body p-2">
                        <h6 class="card-title mb-1"><?php echo e($organico->nombre); ?></h6>
                        <p class="card-text text-muted small mb-1">
                          <i class="fas fa-tag"></i> <?php echo e($organico->categoria->nombre ?? 'Sin categoría'); ?>

                        </p>
                        <?php if($organico->precio): ?>
                          <p class="mb-1"><strong class="text-success">Bs <?php echo e(number_format($organico->precio, 2)); ?></strong></p>
                        <?php endif; ?>
                      </div>
                      <div class="card-footer bg-white p-2">
                        <div class="btn-group btn-group-sm w-100">
                          <a href="<?php echo e(route('organicos.show', $organico->id)); ?>" class="btn btn-info">
                            <i class="fas fa-eye"></i> Ver
                          </a>
                          <a href="<?php echo e(route('organicos.edit', $organico->id)); ?>" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>

  
  <?php
    $totalResultados = 0;
    if (method_exists($ganados, 'total')) $totalResultados += $ganados->total();
    elseif ($ganados->count() > 0) $totalResultados += $ganados->count();
    if (method_exists($maquinarias, 'total')) $totalResultados += $maquinarias->total();
    elseif ($maquinarias->count() > 0) $totalResultados += $maquinarias->count();
    if (method_exists($organicos, 'total')) $totalResultados += $organicos->total();
    elseif ($organicos->count() > 0) $totalResultados += $organicos->count();
  ?>

  <?php if($totalResultados > 0 || (!request()->has('q') && !request()->has('categoria_id') && !request()->has('tipo'))): ?>
    
    <?php if(isset($ganados) && ($ganados->count() > 0 || (method_exists($ganados, 'total') && $ganados->total() > 0))): ?>
      <div class="mb-4">
        <h4 class="text-primary mb-3">
          <i class="fas fa-cow"></i> Animales 
          <?php if(method_exists($ganados, 'total')): ?>
            <span class="badge badge-info">(<?php echo e($ganados->total()); ?>)</span>
          <?php else: ?>
            <span class="badge badge-info">(<?php echo e($ganados->count()); ?>)</span>
          <?php endif; ?>
        </h4>
        <div class="row">
          <?php $__currentLoopData = $ganados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ganado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4 mb-4">
              <a href="<?php echo e(route('ganados.show', $ganado->id)); ?>" class="text-decoration-none" style="color: inherit;">
                <div class="card h-100 ganado-card shadow-lg rounded-lg border-success border-3 overflow-hidden" style="cursor: pointer;">
                  <?php
                    $imagenPrincipal = $ganado->imagenes->first()->ruta ?? $ganado->imagen ?? null;
                  ?>
                  <?php if($imagenPrincipal): ?>
                    <div class="card-img-wrapper position-relative overflow-hidden">
                      <img src="<?php echo e(asset('storage/'.$imagenPrincipal)); ?>" 
                           class="ad-img ganado-img" 
                           style="height:220px; object-fit:cover; transition: transform 0.3s ease;"
                           alt="<?php echo e($ganado->nombre); ?>">
                      <div class="position-absolute top-0 right-0 m-2">
                        <span class="badge badge-success badge-lg shadow-sm">
                          <i class="fas fa-star"></i> Destacado
                        </span>
                      </div>
                    </div>
                  <?php else: ?>
                    <div class="ad-img bg-light d-flex align-items-center justify-content-center" style="height:220px; border-bottom: 3px solid #28a745;">
                      <i class="fas fa-image fa-4x text-muted"></i>
                    </div>
                  <?php endif; ?>
                  <div class="card-body p-3">
                    <h5 class="card-title font-weight-bold text-dark mb-2" style="font-size: 1.1rem; line-height: 1.3;">
                      <i class="fas fa-tag text-success mr-1"></i><?php echo e($ganado->nombre); ?>

                    </h5>
                    <ul class="ad-meta list-unstyled mb-2">
                      <?php if($ganado->ubicacion): ?>
                        <li class="mb-1"><i class="fas fa-map-marker-alt text-success"></i> <span class="small"><?php echo e(Str::limit($ganado->ubicacion, 40)); ?></span></li>
                      <?php endif; ?>
                      <?php if($ganado->tipoAnimal): ?>
                        <li class="mb-1"><i class="fas fa-paw text-success"></i> <span class="small"><?php echo e($ganado->tipoAnimal->nombre); ?></span></li>
                      <?php endif; ?>
                      <?php if($ganado->edad): ?>
                        <li class="mb-1"><i class="fas fa-birthday-cake text-success"></i> <span class="small"><?php echo e($ganado->edad); ?> meses</span></li>
                      <?php endif; ?>
                      <?php if($ganado->fecha_publicacion): ?>
                        <li class="mb-1"><i class="fas fa-calendar-alt text-success"></i> <span class="small">Publicado: <?php echo e(\Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y')); ?></span></li>
                      <?php endif; ?>
                    </ul>
                    <div class="mb-2">
                      <span class="badge badge-success badge-lg px-3 py-2 shadow-sm">
                        <i class="fas fa-tags"></i> <?php echo e($ganado->categoria->nombre ?? 'Animales'); ?>

                      </span>
                    </div>
                    <?php if($ganado->precio): ?>
                      <div class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                        <small class="text-muted d-block mb-0">Precio</small>
                        <h4 class="text-success font-weight-bold mb-0">
                          <i class="fas fa-boliviano-sign"></i> <?php echo e(number_format($ganado->precio, 2)); ?>

                        </h4>
                      </div>
                    <?php else: ?>
                      <div class="bg-light p-2 rounded mb-2 border-left border-secondary border-3">
                        <span class="text-muted small">Precio a consultar</span>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="card-footer d-flex justify-content-between align-items-center bg-white border-top border-success border-2 p-2">
                    <?php if($ganado->precio): ?>
                      <span class="price font-weight-bold text-success">Bs <?php echo e(number_format($ganado->precio, 2)); ?></span>
                    <?php else: ?>
                      <span class="price font-weight-bold text-muted small">Consultar</span>
                    <?php endif; ?>
                    <div class="btn btn-success btn-sm px-3 shadow-sm font-weight-bold">
                      Ver Anuncio <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if(method_exists($ganados, 'links')): ?>
          <div class="mt-3">
            <?php echo e($ganados->appends(request()->except('ganados_page'))->links()); ?>

          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    
    <?php if(isset($maquinarias) && ($maquinarias->count() > 0 || (method_exists($maquinarias, 'total') && $maquinarias->total() > 0))): ?>
      <div class="mb-4">
        <h4 class="text-primary mb-3">
          <i class="fas fa-tractor"></i> Maquinaria 
          <?php if(method_exists($maquinarias, 'total')): ?>
            <span class="badge badge-info">(<?php echo e($maquinarias->total()); ?>)</span>
          <?php else: ?>
            <span class="badge badge-info">(<?php echo e($maquinarias->count()); ?>)</span>
          <?php endif; ?>
        </h4>
        <div class="row">
          <?php $__currentLoopData = $maquinarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maquinaria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg card-ad border-0">
                <div class="ad-img bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                  <i class="fas fa-tractor fa-5x text-success"></i>
                </div>
                <div class="card-body">
                  <h5 class="card-title mb-2"><?php echo e($maquinaria->nombre); ?></h5>
                  <ul class="ad-meta list-unstyled mb-2">
                    <?php if($maquinaria->tipoMaquinaria): ?>
                      <li><i class="fas fa-tag text-muted"></i> <?php echo e($maquinaria->tipoMaquinaria->nombre); ?></li>
                    <?php endif; ?>
                    <?php if($maquinaria->marcaMaquinaria): ?>
                      <li><i class="fas fa-industry text-muted"></i> <?php echo e($maquinaria->marcaMaquinaria->nombre); ?></li>
                    <?php endif; ?>
                    <?php if($maquinaria->modelo): ?>
                      <li><i class="fas fa-cog text-muted"></i> <?php echo e($maquinaria->modelo); ?></li>
                    <?php endif; ?>
                  </ul>
                  <span class="badge badge-info badge-pill px-3">
                    <?php echo e($maquinaria->categoria->nombre ?? 'Maquinaria'); ?>

                  </span>
                  <?php if($maquinaria->estado): ?>
                    <span class="badge badge-<?php echo e($maquinaria->estado == 'disponible' ? 'success' : 'secondary'); ?> badge-pill px-3 ml-1">
                      <?php echo e(ucfirst(str_replace('_', ' ', $maquinaria->estado))); ?>

                    </span>
                  <?php endif; ?>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center bg-white border-top">
                  <?php if($maquinaria->precio_dia): ?>
                    <span class="price font-weight-bold text-success">Bs <?php echo e(number_format($maquinaria->precio_dia, 2)); ?>/día</span>
                  <?php else: ?>
                    <span class="price font-weight-bold text-muted">Precio a consultar</span>
                  <?php endif; ?>
                  <a href="<?php echo e(route('maquinarias.show', $maquinaria->id)); ?>" class="btn btn-success btn-sm px-3">
                    Ver Anuncio <i class="fas fa-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if(method_exists($maquinarias, 'links')): ?>
          <div class="mt-3">
            <?php echo e($maquinarias->appends(request()->except('maquinarias_page'))->links()); ?>

          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    
    <?php if(isset($organicos) && ($organicos->count() > 0 || (method_exists($organicos, 'total') && $organicos->total() > 0))): ?>
      <div class="mb-4">
        <h4 class="text-primary mb-3">
          <i class="fas fa-leaf"></i> Orgánicos 
          <?php if(method_exists($organicos, 'total')): ?>
            <span class="badge badge-info">(<?php echo e($organicos->total()); ?>)</span>
          <?php else: ?>
            <span class="badge badge-info">(<?php echo e($organicos->count()); ?>)</span>
          <?php endif; ?>
        </h4>
        <div class="row">
          <?php $__currentLoopData = $organicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg card-ad border-0">
                <div class="ad-img bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                  <i class="fas fa-leaf fa-5x text-success"></i>
                </div>
                <div class="card-body">
                  <h5 class="card-title mb-2"><?php echo e($organico->nombre); ?></h5>
                  <ul class="ad-meta list-unstyled mb-2">
                    <?php if($organico->fecha_cosecha): ?>
                      <li><i class="fas fa-calendar text-muted"></i> Cosecha: <?php echo e(\Carbon\Carbon::parse($organico->fecha_cosecha)->format('d/m/Y')); ?></li>
                    <?php endif; ?>
                    <?php if($organico->stock): ?>
                      <li><i class="fas fa-box text-muted"></i> Stock: <?php echo e($organico->stock); ?></li>
                    <?php endif; ?>
                  </ul>
                  <span class="badge badge-success badge-pill px-3">
                    <?php echo e($organico->categoria->nombre ?? 'Orgánico'); ?>

                  </span>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center bg-white border-top">
                  <?php if($organico->precio): ?>
                    <span class="price font-weight-bold text-success">Bs <?php echo e(number_format($organico->precio, 2)); ?></span>
                  <?php else: ?>
                    <span class="price font-weight-bold text-muted">Precio a consultar</span>
                  <?php endif; ?>
                  <a href="<?php echo e(route('organicos.show', $organico->id)); ?>" class="btn btn-success btn-sm px-3">
                    Ver Anuncio <i class="fas fa-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if(method_exists($organicos, 'links')): ?>
          <div class="mt-3">
            <?php echo e($organicos->appends(request()->except('organicos_page'))->links()); ?>

          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    
    <?php if($totalResultados == 0 && (request()->has('q') || request()->has('categoria_id') || request()->has('tipo'))): ?>
      <div class="alert alert-info text-center py-5">
        <i class="fas fa-search fa-3x mb-3"></i>
        <h4>No se encontraron resultados</h4>
        <p>Intenta con otros términos de búsqueda o <a href="<?php echo e(route('ads.index')); ?>">ver todos los anuncios</a></p>
      </div>
    <?php endif; ?>
  <?php else: ?>
    
    <div class="alert alert-warning text-center py-5">
      <i class="fas fa-info-circle fa-3x mb-3"></i>
      <h4>No hay anuncios disponibles</h4>
      <p>Los vendedores aún no han publicado productos.</p>
    </div>
  <?php endif; ?>

</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/public/ads/index.blade.php ENDPATH**/ ?>