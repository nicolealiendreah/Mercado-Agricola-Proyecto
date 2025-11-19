<?php $__env->startSection('title','Inicio'); ?>

<?php $__env->startSection('content'); ?>
<section class="hero" style="background:url('<?php echo e(asset('img/bg-agrovida.jpg')); ?>') center/cover no-repeat; min-height:400px; position:relative;">
  <div class="container py-5 text-white" style="position:relative; z-index:2;">
    <h5 class="mb-2">Bienvenido a Agrovida</h5>
    <h1 class="display-5 font-weight-bold">
      Tu mercado de animales, maquinaria y<br>orgánicos en un solo lugar
    </h1>

    <div class="bg-white p-4 rounded mt-4 shadow-lg">
      <form method="GET" action="<?php echo e(route('home')); ?>" class="form-row align-items-end">
        <div class="col-md-4 mb-2">
          <label class="text-dark small font-weight-bold mb-1">Categoría</label>
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
          <label class="text-dark small font-weight-bold mb-1">Buscar</label>
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
          <a href="<?php echo e(route('home')); ?>" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-times"></i> Limpiar filtros
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.3); z-index:1;"></div>
</section>

<?php if(request()->has('q') || request()->has('categoria_id')): ?>
  
  <section class="container my-5">
    <h2 class="text-success mb-4">
      <i class="fas fa-search"></i> Resultados de búsqueda
      <?php if(request('q')): ?>
        <small class="text-muted">para "<?php echo e(request('q')); ?>"</small>
      <?php endif; ?>
    </h2>

    
    <?php if(isset($ganados) && ($ganados->count() > 0 || (method_exists($ganados, 'total') && $ganados->total() > 0))): ?>
      <div class="mb-5">
        <h4 class="text-primary mb-3">
          <i class="fas fa-cow"></i> Animales (<?php echo e(method_exists($ganados, 'total') ? $ganados->total() : $ganados->count()); ?>)
        </h4>
        <div class="row">
          <?php $__currentLoopData = $ganados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ganado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg border-0">
                <?php if($ganado->imagen): ?>
                  <img src="<?php echo e(asset('storage/'.$ganado->imagen)); ?>" 
                       class="card-img-top" 
                       style="height:200px; object-fit:cover; cursor:pointer;"
                       onclick="window.open('<?php echo e(asset('storage/'.$ganado->imagen)); ?>', '_blank')"
                       alt="<?php echo e($ganado->nombre); ?>">
                <?php else: ?>
                  <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                  </div>
                <?php endif; ?>
                <div class="card-body">
                  <h5 class="card-title"><?php echo e($ganado->nombre); ?></h5>
                  <p class="card-text text-muted small mb-2">
                    <i class="fas fa-map-marker-alt"></i> <?php echo e($ganado->ubicacion ?? 'Sin ubicación'); ?>

                  </p>
                  <div class="mb-2">
                    <span class="badge badge-success"><?php echo e($ganado->categoria->nombre ?? 'Sin categoría'); ?></span>
                    <?php if($ganado->tipoAnimal): ?>
                      <span class="badge badge-info"><?php echo e($ganado->tipoAnimal->nombre); ?></span>
                    <?php endif; ?>
                  </div>
                  <?php if($ganado->precio): ?>
                    <p class="h5 text-success mb-0">Bs <?php echo e(number_format($ganado->precio, 2)); ?></p>
                  <?php endif; ?>
                </div>
                <div class="card-footer bg-white border-top">
                  <a href="<?php echo e(route('ganados.show', $ganado->id)); ?>" class="btn btn-success btn-sm btn-block">
                    <i class="fas fa-eye"></i> Ver Detalles
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if(method_exists($ganados, 'links')): ?>
          <div class="mt-3">
            <?php echo e($ganados->appends(request()->query())->links()); ?>

          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    
    <?php if(isset($maquinarias) && ($maquinarias->count() > 0 || (method_exists($maquinarias, 'total') && $maquinarias->total() > 0))): ?>
      <div class="mb-5">
        <h4 class="text-primary mb-3">
          <i class="fas fa-tractor"></i> Maquinaria (<?php echo e(method_exists($maquinarias, 'total') ? $maquinarias->total() : $maquinarias->count()); ?>)
        </h4>
        <div class="row">
          <?php $__currentLoopData = $maquinarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maquinaria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg border-0">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                  <i class="fas fa-tractor fa-4x text-success"></i>
                </div>
                <div class="card-body">
                  <h5 class="card-title"><?php echo e($maquinaria->nombre); ?></h5>
                  <p class="card-text text-muted small mb-2">
                    <i class="fas fa-tag"></i> <?php echo e($maquinaria->tipoMaquinaria->nombre ?? 'N/A'); ?> | 
                    <i class="fas fa-industry"></i> <?php echo e($maquinaria->marcaMaquinaria->nombre ?? 'N/A'); ?>

                  </p>
                  <div class="mb-2">
                    <span class="badge badge-success"><?php echo e($maquinaria->categoria->nombre ?? 'Sin categoría'); ?></span>
                    <span class="badge badge-<?php echo e($maquinaria->estado == 'disponible' ? 'success' : 'secondary'); ?>">
                      <?php echo e(ucfirst(str_replace('_', ' ', $maquinaria->estado ?? 'N/A'))); ?>

                    </span>
                  </div>
                  <?php if($maquinaria->precio_dia): ?>
                    <p class="h5 text-success mb-0">Bs <?php echo e(number_format($maquinaria->precio_dia, 2)); ?>/día</p>
                  <?php endif; ?>
                </div>
                <div class="card-footer bg-white border-top">
                  <a href="<?php echo e(route('maquinarias.show', $maquinaria->id)); ?>" class="btn btn-success btn-sm btn-block">
                    <i class="fas fa-eye"></i> Ver Detalles
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if(method_exists($maquinarias, 'links')): ?>
          <div class="mt-3">
            <?php echo e($maquinarias->appends(request()->query())->links()); ?>

          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    
    <?php if(isset($organicos) && ($organicos->count() > 0 || (method_exists($organicos, 'total') && $organicos->total() > 0))): ?>
      <div class="mb-5">
        <h4 class="text-primary mb-3">
          <i class="fas fa-leaf"></i> Orgánicos (<?php echo e(method_exists($organicos, 'total') ? $organicos->total() : $organicos->count()); ?>)
        </h4>
        <div class="row">
          <?php $__currentLoopData = $organicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg border-0">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                  <i class="fas fa-leaf fa-4x text-success"></i>
                </div>
                <div class="card-body">
                  <h5 class="card-title"><?php echo e($organico->nombre); ?></h5>
                  <p class="card-text text-muted small mb-2">
                    <i class="fas fa-tag"></i> <?php echo e($organico->categoria->nombre ?? 'Sin categoría'); ?>

                  </p>
                  <div class="mb-2">
                    <span class="badge badge-success">Stock: <?php echo e($organico->stock ?? 0); ?></span>
                  </div>
                  <?php if($organico->precio): ?>
                    <p class="h5 text-success mb-0">Bs <?php echo e(number_format($organico->precio, 2)); ?></p>
                  <?php endif; ?>
                </div>
                <div class="card-footer bg-white border-top">
                  <a href="<?php echo e(route('organicos.show', $organico->id)); ?>" class="btn btn-success btn-sm btn-block">
                    <i class="fas fa-eye"></i> Ver Detalles
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if(method_exists($organicos, 'links')): ?>
          <div class="mt-3">
            <?php echo e($organicos->appends(request()->query())->links()); ?>

          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    
    <?php if((!isset($ganados) || ($ganados->count() == 0 && (!method_exists($ganados, 'total') || $ganados->total() == 0))) &&
        (!isset($maquinarias) || ($maquinarias->count() == 0 && (!method_exists($maquinarias, 'total') || $maquinarias->total() == 0))) &&
        (!isset($organicos) || ($organicos->count() == 0 && (!method_exists($organicos, 'total') || $organicos->total() == 0)))): ?>
      <div class="alert alert-info text-center py-5">
        <i class="fas fa-search fa-3x mb-3"></i>
        <h4>No se encontraron resultados</h4>
        <p>Intenta con otros términos de búsqueda o <a href="<?php echo e(route('home')); ?>">ver todos los productos</a></p>
      </div>
    <?php endif; ?>
  </section>
<?php else: ?>
  
  <section class="container my-5">
    <div class="row align-items-center mb-5">
      <div class="col-md-5 mb-3">
        <img src="<?php echo e(asset('img/hero-agrovida.png')); ?>" class="img-fluid rounded shadow" alt="AgroVida">
      </div>
      <div class="col-md-7">
        <h3 class="text-success font-weight-bold">
          Miles de productos de nuestra industria a un click
        </h3>
        <p class="text-muted">
          Encuentra anuncios de productos y servicios especializados y a sus proveedores directos.
        </p>
        <div class="d-flex flex-column flex-md-row gap-3">
          <a href="<?php echo e(route('ads.index')); ?>" class="btn btn-success btn-lg px-5">
            <i class="fas fa-search"></i> Navega
          </a>
          <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->user()->isCliente()): ?>
              <a href="<?php echo e(route('solicitar-vendedor')); ?>" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-user-tie"></i> Ser Vendedor
              </a>
            <?php endif; ?>
          <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary btn-lg px-5">
              <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    
    <?php if(isset($ganados) && $ganados->count() > 0): ?>
      <div class="mb-5">
        <h3 class="text-success mb-4">
          <i class="fas fa-cow"></i> Animales Destacados
        </h3>
        <div class="row">
          <?php $__currentLoopData = $ganados->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ganado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg border-0">
                <?php if($ganado->imagen): ?>
                  <img src="<?php echo e(asset('storage/'.$ganado->imagen)); ?>" 
                       class="card-img-top" 
                       style="height:200px; object-fit:cover; cursor:pointer;"
                       onclick="window.open('<?php echo e(asset('storage/'.$ganado->imagen)); ?>', '_blank')"
                       alt="<?php echo e($ganado->nombre); ?>">
                <?php else: ?>
                  <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                  </div>
                <?php endif; ?>
                <div class="card-body">
                  <h5 class="card-title"><?php echo e($ganado->nombre); ?></h5>
                  <p class="card-text text-muted small mb-2">
                    <i class="fas fa-map-marker-alt"></i> <?php echo e($ganado->ubicacion ?? 'Sin ubicación'); ?>

                  </p>
                  <div class="mb-2">
                    <span class="badge badge-success"><?php echo e($ganado->categoria->nombre ?? 'Sin categoría'); ?></span>
                  </div>
                  <?php if($ganado->precio): ?>
                    <p class="h5 text-success mb-0">Bs <?php echo e(number_format($ganado->precio, 2)); ?></p>
                  <?php endif; ?>
                </div>
                <div class="card-footer bg-white border-top">
                  <a href="<?php echo e(route('ganados.show', $ganado->id)); ?>" class="btn btn-success btn-sm btn-block">
                    <i class="fas fa-eye"></i> Ver Detalles
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center">
          <a href="<?php echo e(route('ganados.index')); ?>" class="btn btn-outline-success">
            Ver todos los animales <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    <?php endif; ?>

    <?php if(isset($maquinarias) && $maquinarias->count() > 0): ?>
      <div class="mb-5">
        <h3 class="text-success mb-4">
          <i class="fas fa-tractor"></i> Maquinaria Destacada
        </h3>
        <div class="row">
          <?php $__currentLoopData = $maquinarias->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maquinaria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg border-0">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                  <i class="fas fa-tractor fa-4x text-success"></i>
                </div>
                <div class="card-body">
                  <h5 class="card-title"><?php echo e($maquinaria->nombre); ?></h5>
                  <p class="card-text text-muted small mb-2">
                    <i class="fas fa-tag"></i> <?php echo e($maquinaria->tipoMaquinaria->nombre ?? 'N/A'); ?>

                  </p>
                  <?php if($maquinaria->precio_dia): ?>
                    <p class="h5 text-success mb-0">Bs <?php echo e(number_format($maquinaria->precio_dia, 2)); ?>/día</p>
                  <?php endif; ?>
                </div>
                <div class="card-footer bg-white border-top">
                  <a href="<?php echo e(route('maquinarias.show', $maquinaria->id)); ?>" class="btn btn-success btn-sm btn-block">
                    <i class="fas fa-eye"></i> Ver Detalles
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center">
          <a href="<?php echo e(route('maquinarias.index')); ?>" class="btn btn-outline-success">
            Ver toda la maquinaria <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    <?php endif; ?>

    <?php if(isset($organicos) && $organicos->count() > 0): ?>
      <div class="mb-5">
        <h3 class="text-success mb-4">
          <i class="fas fa-leaf"></i> Productos Orgánicos Destacados
        </h3>
        <div class="row">
          <?php $__currentLoopData = $organicos->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg border-0">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                  <i class="fas fa-leaf fa-4x text-success"></i>
                </div>
                <div class="card-body">
                  <h5 class="card-title"><?php echo e($organico->nombre); ?></h5>
                  <p class="card-text text-muted small mb-2">
                    <i class="fas fa-tag"></i> <?php echo e($organico->categoria->nombre ?? 'Sin categoría'); ?>

                  </p>
                  <?php if($organico->precio): ?>
                    <p class="h5 text-success mb-0">Bs <?php echo e(number_format($organico->precio, 2)); ?></p>
                  <?php endif; ?>
                </div>
                <div class="card-footer bg-white border-top">
                  <a href="<?php echo e(route('organicos.show', $organico->id)); ?>" class="btn btn-success btn-sm btn-block">
                    <i class="fas fa-eye"></i> Ver Detalles
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center">
          <a href="<?php echo e(route('organicos.index')); ?>" class="btn btn-outline-success">
            Ver todos los orgánicos <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    <?php endif; ?>
  </section>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/public/home.blade.php ENDPATH**/ ?>