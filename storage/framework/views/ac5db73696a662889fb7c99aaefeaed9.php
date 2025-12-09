<?php $__env->startSection('title', 'Inicio'); ?>

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

        /* Evitar zoom y recorte en maquinaria y orgánicos */
        .card-maquinaria-img,
        .card-organico-img {
            height: 220px !important;
            width: 100% !important;
            object-fit: contain !important;
            background: #ffffff !important;
            transform: none !important;
        }

        /* Evitar que el hover del ganado afecte maquinaria y orgánicos */
        .ganado-card:hover .card-maquinaria-img,
        .ganado-card:hover .card-organico-img {
            transform: none !important;
        }
    </style>

    <section class="hero"
        style="background:url('<?php echo e(asset('img/bg-agrovida.jpg')); ?>') center/cover no-repeat; min-height:400px; position:relative;">
        <div class="container py-5 text-white" style="position:relative; z-index:2;">
            <h5 class="mb-2">Bienvenido a Agrovida</h5>
            <h1 class="display-5 font-weight-bold">
                Tu mercado de animales, maquinaria y<br>orgánicos en un solo lugar
            </h1>

            <div class="bg-white p-4 rounded mt-4 shadow-lg">
                <form method="GET" action="<?php echo e(route('home')); ?>" id="searchForm" class="form-row align-items-end">
                    <div class="col-md-3 mb-2">
                        <label class="text-dark small font-weight-bold mb-1">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="form-control"
                            onchange="onCategoriaChange(this)">
                            <option value="">Todas las categorías</option>
                            <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($categoria->id); ?>"
                                    <?php echo e(request('categoria_id') == $categoria->id ? 'selected' : ''); ?>>
                                    <?php echo e($categoria->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2 filtros-animales">
                        <label class="text-dark small font-weight-bold mb-1">Tipo de Animal</label>
                        <select name="tipo_animal_id" id="tipo_animal_id" class="form-control"
                            onchange="filtrarRazas(); this.form.submit();">
                            <option value="">Todos los tipos</option>
                            <?php $__currentLoopData = $tiposAnimales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipoAnimal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tipoAnimal->id); ?>"
                                    <?php echo e(request('tipo_animal_id') == $tipoAnimal->id ? 'selected' : ''); ?>>
                                    <?php echo e($tipoAnimal->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2 filtros-animales">
                        <label class="text-dark small font-weight-bold mb-1">Raza</label>
                        <select name="raza_id" id="raza_id" class="form-control" onchange="this.form.submit()">
                            <option value="">Todas las razas</option>
                            <?php $__currentLoopData = $razas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $raza): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($raza->id); ?>" data-tipo-animal-id="<?php echo e($raza->tipo_animal_id); ?>"
                                    <?php echo e(request('raza_id') == $raza->id ? 'selected' : ''); ?>>
                                    <?php echo e($raza->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2 filtros-maquinaria">
                        <label class="text-dark small font-weight-bold mb-1">Tipo de Maquinaria</label>
                        <select name="tipo_maquinaria_id" id="tipo_maquinaria_id" class="form-control"
                            onchange="this.form.submit()">
                            <option value="">Todos los tipos</option>
                            <?php $__currentLoopData = $tiposMaquinaria ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipoMaq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tipoMaq->id); ?>"
                                    <?php echo e(request('tipo_maquinaria_id') == $tipoMaq->id ? 'selected' : ''); ?>>
                                    <?php echo e($tipoMaq->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2 filtros-maquinaria">
                        <label class="text-dark small font-weight-bold mb-1">Marca de Maquinaria</label>
                        <select name="marca_maquinaria_id" id="marca_maquinaria_id" class="form-control"
                            onchange="this.form.submit()">
                            <option value="">Todas las marcas</option>
                            <?php $__currentLoopData = $marcasMaquinaria ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($marca->id); ?>"
                                    <?php echo e(request('marca_maquinaria_id') == $marca->id ? 'selected' : ''); ?>>
                                    <?php echo e($marca->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2 filtros-organicos">
                        <label class="text-dark small font-weight-bold mb-1">Tipo de Cultivo</label>
                        <select name="tipo_cultivo_id" id="tipo_cultivo_id" class="form-control"
                            onchange="this.form.submit()">
                            <option value="">Todos los tipos</option>
                            <?php $__currentLoopData = $tiposCultivo ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipoCultivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tipoCultivo->id); ?>"
                                    <?php echo e(request('tipo_cultivo_id') == $tipoCultivo->id ? 'selected' : ''); ?>>
                                    <?php echo e($tipoCultivo->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>



                    <div class="col-md-4 mb-2">
                        <label class="text-dark small font-weight-bold mb-1">Buscar</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-white"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" name="q" class="form-control"
                                placeholder="Buscar animales, maquinaria u orgánicos..." value="<?php echo e(request('q')); ?>">
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </form>

                <?php if(request()->has('q') ||
                        request()->has('categoria_id') ||
                        request()->has('tipo_animal_id') ||
                        request()->has('raza_id')): ?>
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

    <?php if(request()->has('q') ||
            request()->has('categoria_id') ||
            request()->has('tipo_animal_id') ||
            request()->has('raza_id')): ?>
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
                        <i class="fas fa-cow"></i> Animales
                        (<?php echo e(method_exists($ganados, 'total') ? $ganados->total() : $ganados->count()); ?>)
                    </h4>
                    <div class="row">
                        <?php $__currentLoopData = $ganados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ganado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <a href="<?php echo e(route('ganados.show', $ganado->id)); ?>" class="text-decoration-none"
                                    style="color: inherit;">
                                    <div class="card h-100 ganado-card shadow-lg rounded-lg border-success border-3 overflow-hidden"
                                        style="cursor: pointer;">
                                        <?php
                                            $imagenPrincipal =
                                                $ganado->imagenes->first()->ruta ?? ($ganado->imagen ?? null);
                                        ?>
                                        <?php if($imagenPrincipal): ?>
                                            <div class="card-img-wrapper position-relative overflow-hidden">
                                                <img src="<?php echo e(asset('storage/' . $imagenPrincipal)); ?>"
                                                    class="card-img-top ganado-img"
                                                    style="height:220px; object-fit:cover; transition: transform 0.3s ease;"
                                                    alt="<?php echo e($ganado->nombre); ?>">
                                                <div class="position-absolute top-0 right-0 m-2">
                                                    <span class="badge badge-success badge-lg shadow-sm">
                                                        <i class="fas fa-star"></i> Destacado
                                                    </span>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                style="height:220px; border-bottom: 3px solid #28a745;">
                                                <i class="fas fa-image fa-4x text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body p-3">
                                            <h5 class="card-title font-weight-bold text-dark mb-2"
                                                style="font-size: 1.1rem; line-height: 1.3;">
                                                <i class="fas fa-tag text-success mr-1"></i><?php echo e($ganado->nombre); ?>

                                            </h5>
                                            <div class="mb-2">
                                                <p class="card-text text-muted small mb-1">
                                                    <i class="fas fa-map-marker-alt text-success"></i>
                                                    <span
                                                        class="ml-1"><?php echo e(Str::limit($ganado->ubicacion ?? 'Sin ubicación', 40)); ?></span>
                                                </p>
                                                <?php if($ganado->fecha_publicacion): ?>
                                                    <p class="card-text text-muted small mb-1">
                                                        <i class="fas fa-calendar-alt text-success"></i>
                                                        <span class="ml-1">Publicado:
                                                            <?php echo e(\Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y')); ?></span>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <span class="badge badge-success badge-lg px-3 py-2 mr-1 shadow-sm">
                                                    <i class="fas fa-tags"></i>
                                                    <?php echo e($ganado->categoria->nombre ?? 'Sin categoría'); ?>

                                                </span>
                                                <?php if($ganado->tipoAnimal): ?>
                                                    <span class="badge badge-info badge-lg px-3 py-2 shadow-sm">
                                                        <i class="fas fa-paw"></i> <?php echo e($ganado->tipoAnimal->nombre); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if($ganado->precio): ?>
                                                <div
                                                    class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                                                    <small class="text-muted d-block mb-0">Precio</small>
                                                    <h4 class="text-success font-weight-bold mb-0">
                                                        <i class="fas fa-boliviano-sign"></i>
                                                        <?php echo e(number_format($ganado->precio, 2)); ?>

                                                    </h4>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer bg-white border-top border-success border-2 p-2">
                                            <div class="btn btn-success btn-block btn-lg shadow-sm font-weight-bold">
                                                <i class="fas fa-eye mr-2"></i> Ver Detalles
                                            </div>
                                        </div>
                                    </div>
                                </a>
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

            
            <?php if(isset($maquinarias) &&
                    ($maquinarias->count() > 0 || (method_exists($maquinarias, 'total') && $maquinarias->total() > 0))): ?>
                <div class="mb-5">
                    <h4 class="text-primary mb-3">
                        <i class="fas fa-tractor"></i> Maquinaria
                        (<?php echo e(method_exists($maquinarias, 'total') ? $maquinarias->total() : $maquinarias->count()); ?>)
                    </h4>
                    <div class="row">
                        <?php $__currentLoopData = $maquinarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maquinaria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <a href="<?php echo e(route('maquinarias.show', $maquinaria->id)); ?>" class="text-decoration-none"
                                    style="color: inherit;">
                                    <div class="card h-100 ganado-card shadow-lg rounded-lg border-success border-3 overflow-hidden"
                                        style="cursor: pointer;">
                                        <?php
                                            $imagenPrincipal = $maquinaria->imagenes->first()->ruta ?? null;
                                        ?>
                                        <?php if($imagenPrincipal): ?>
                                            <div class="card-img-wrapper position-relative overflow-hidden">
                                                <img src="<?php echo e(asset('storage/' . $imagenPrincipal)); ?>"
                                                    class="card-img-top card-maquinaria-img"
                                                    alt="<?php echo e($maquinaria->nombre); ?>">

                                                <div class="position-absolute top-0 right-0 m-2">
                                                    <span class="badge badge-success badge-lg shadow-sm">
                                                        <i class="fas fa-star"></i> Destacado
                                                    </span>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                style="height:220px; border-bottom: 3px solid #28a745;">
                                                <i class="fas fa-tractor fa-4x text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body p-3">
                                            <h5 class="card-title font-weight-bold text-dark mb-2"
                                                style="font-size: 1.1rem; line-height: 1.3;">
                                                <i class="fas fa-tag text-success mr-1"></i><?php echo e($maquinaria->nombre); ?>

                                            </h5>
                                            <ul class="ad-meta list-unstyled mb-2">
                                                <?php if($maquinaria->ubicacion): ?>
                                                    <li class="mb-1"><i class="fas fa-map-marker-alt text-success"></i>
                                                        <span
                                                            class="small"><?php echo e(Str::limit($maquinaria->ubicacion, 40)); ?></span>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if($maquinaria->tipoMaquinaria): ?>
                                                    <li class="mb-1"><i class="fas fa-cog text-success"></i> <span
                                                            class="small"><?php echo e($maquinaria->tipoMaquinaria->nombre); ?></span>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if($maquinaria->fecha_publicacion ?? $maquinaria->created_at): ?>
                                                    <li class="mb-1"><i class="fas fa-calendar-alt text-success"></i>
                                                        <span class="small">Publicado:
                                                            <?php echo e(\Carbon\Carbon::parse($maquinaria->fecha_publicacion ?? $maquinaria->created_at)->format('d/m/Y')); ?></span>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                            <div class="mb-2">
                                                <span class="badge badge-success badge-lg px-3 py-2 shadow-sm">
                                                    <i class="fas fa-tags"></i>
                                                    <?php echo e($maquinaria->categoria->nombre ?? 'Maquinaria'); ?>

                                                </span>
                                            </div>
                                            <?php if($maquinaria->precio_dia): ?>
                                                <div
                                                    class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                                                    <small class="text-muted d-block mb-0">Precio</small>
                                                    <h4 class="text-success font-weight-bold mb-0">
                                                        <i class="fas fa-boliviano-sign"></i>
                                                        <?php echo e(number_format($maquinaria->precio_dia, 2)); ?>/día
                                                    </h4>
                                                </div>
                                            <?php else: ?>
                                                <div
                                                    class="bg-light p-2 rounded mb-2 border-left border-secondary border-3">
                                                    <span class="text-muted small">Precio a consultar</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div
                                            class="card-footer d-flex justify-content-between align-items-center bg-white border-top border-success border-2 p-2">
                                            <?php if($maquinaria->precio_dia): ?>
                                                <span class="price font-weight-bold text-success">Bs
                                                    <?php echo e(number_format($maquinaria->precio_dia, 2)); ?>/día</span>
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
                        <i class="fas fa-leaf"></i> Orgánicos
                        (<?php echo e(method_exists($organicos, 'total') ? $organicos->total() : $organicos->count()); ?>)
                    </h4>
                    <div class="row">
                        <?php $__currentLoopData = $organicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <a href="<?php echo e(route('organicos.show', $organico->id)); ?>" class="text-decoration-none"
                                    style="color: inherit;">
                                    <div class="card h-100 ganado-card shadow-lg rounded-lg border-success border-3 overflow-hidden"
                                        style="cursor: pointer;">
                                        <?php
                                            $imagenPrincipal = $organico->imagenes->first()->ruta ?? null;
                                        ?>
                                        <?php if($imagenPrincipal): ?>
                                            <div class="card-img-wrapper position-relative overflow-hidden">
                                                <img src="<?php echo e(asset('storage/' . $imagenPrincipal)); ?>"
                                                    class="card-img-top card-organico-img" alt="<?php echo e($organico->nombre); ?>">

                                                <div class="position-absolute top-0 right-0 m-2">
                                                    <span class="badge badge-success badge-lg shadow-sm">
                                                        <i class="fas fa-star"></i> Destacado
                                                    </span>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                style="height:220px; border-bottom: 3px solid #28a745;">
                                                <i class="fas fa-leaf fa-4x text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body p-3">
                                            <h5 class="card-title font-weight-bold text-dark mb-2"
                                                style="font-size: 1.1rem; line-height: 1.3;">
                                                <i class="fas fa-tag text-success mr-1"></i><?php echo e($organico->nombre); ?>

                                            </h5>
                                            <ul class="ad-meta list-unstyled mb-2">
                                                <?php if($organico->origen): ?>
                                                    <li class="mb-1"><i class="fas fa-map-marker-alt text-success"></i>
                                                        <span
                                                            class="small"><?php echo e(Str::limit($organico->origen, 40)); ?></span>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if($organico->fecha_cosecha): ?>
                                                    <li class="mb-1"><i class="fas fa-calendar-alt text-success"></i>
                                                        <span class="small">Cosecha:
                                                            <?php echo e(\Carbon\Carbon::parse($organico->fecha_cosecha)->format('d/m/Y')); ?></span>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if($organico->created_at): ?>
                                                    <li class="mb-1"><i class="fas fa-calendar-alt text-success"></i>
                                                        <span class="small">Publicado:
                                                            <?php echo e(\Carbon\Carbon::parse($organico->created_at)->format('d/m/Y')); ?></span>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                            <div class="mb-2">
                                                <span class="badge badge-success badge-lg px-3 py-2 shadow-sm">
                                                    <i class="fas fa-tags"></i>
                                                    <?php echo e($organico->categoria->nombre ?? 'Orgánico'); ?>

                                                </span>
                                            </div>
                                            <?php if($organico->precio): ?>
                                                <div
                                                    class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                                                    <small class="text-muted d-block mb-0">Precio</small>
                                                    <h4 class="text-success font-weight-bold mb-0">
                                                        <i class="fas fa-boliviano-sign"></i>
                                                        <?php echo e(number_format($organico->precio, 2)); ?>

                                                    </h4>
                                                </div>
                                            <?php else: ?>
                                                <div
                                                    class="bg-light p-2 rounded mb-2 border-left border-secondary border-3">
                                                    <span class="text-muted small">Precio a consultar</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div
                                            class="card-footer d-flex justify-content-between align-items-center bg-white border-top border-success border-2 p-2">
                                            <?php if($organico->precio): ?>
                                                <span class="price font-weight-bold text-success">Bs
                                                    <?php echo e(number_format($organico->precio, 2)); ?></span>
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
                    <?php if(method_exists($organicos, 'links')): ?>
                        <div class="mt-3">
                            <?php echo e($organicos->appends(request()->query())->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            
            <?php if(
                (!isset($ganados) || ($ganados->count() == 0 && (!method_exists($ganados, 'total') || $ganados->total() == 0))) &&
                    (!isset($maquinarias) ||
                        ($maquinarias->count() == 0 && (!method_exists($maquinarias, 'total') || $maquinarias->total() == 0))) &&
                    (!isset($organicos) ||
                        ($organicos->count() == 0 && (!method_exists($organicos, 'total') || $organicos->total() == 0)))): ?>
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-search fa-3x mb-3"></i>
                    <h4>No se encontraron resultados</h4>
                    <p>Intenta con otros términos de búsqueda o <a href="<?php echo e(route('home')); ?>">ver todos los productos</a>
                    </p>
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
                        <a href="<?php echo e(route('ads.index')); ?>" class="btn btn-success btn-lg px-5 shadow-sm">
                            <i class="fas fa-search"></i> Navegar Anuncios
                        </a>
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->user()->isCliente()): ?>
                                <a href="<?php echo e(route('solicitar-vendedor')); ?>" class="btn btn-primary btn-lg px-5 shadow-sm">
                                    <i class="fas fa-user-tie"></i> Ser Vendedor
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?php echo e(route('solicitar-vendedor')); ?>" class="btn btn-primary btn-lg px-5 shadow-sm">
                                <i class="fas fa-user-tie"></i> Ser Vendedor
                            </a>
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
                        <?php $__currentLoopData = $ganados->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ganado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <a href="<?php echo e(route('ganados.show', $ganado->id)); ?>" class="text-decoration-none"
                                    style="color: inherit;">
                                    <div class="card h-100 ganado-card shadow-lg rounded-lg border-success border-3 overflow-hidden"
                                        style="cursor: pointer;">
                                        <?php
                                            $imagenPrincipal =
                                                $ganado->imagenes->first()->ruta ?? ($ganado->imagen ?? null);
                                        ?>
                                        <?php if($imagenPrincipal): ?>
                                            <div class="card-img-wrapper position-relative overflow-hidden">
                                                <img src="<?php echo e(asset('storage/' . $imagenPrincipal)); ?>"
                                                    class="card-img-top ganado-img"
                                                    style="height:220px; object-fit:cover; transition: transform 0.3s ease;"
                                                    alt="<?php echo e($ganado->nombre); ?>">
                                                <div class="position-absolute top-0 right-0 m-2">
                                                    <span class="badge badge-success badge-lg shadow-sm">
                                                        <i class="fas fa-star"></i> Destacado
                                                    </span>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                style="height:220px; border-bottom: 3px solid #28a745;">
                                                <i class="fas fa-image fa-4x text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body p-3">
                                            <h5 class="card-title font-weight-bold text-dark mb-2"
                                                style="font-size: 1.1rem; line-height: 1.3;">
                                                <i class="fas fa-tag text-success mr-1"></i><?php echo e($ganado->nombre); ?>

                                            </h5>
                                            <div class="mb-2">
                                                <p class="card-text text-muted small mb-1">
                                                    <i class="fas fa-map-marker-alt text-success"></i>
                                                    <span
                                                        class="ml-1"><?php echo e(Str::limit($ganado->ubicacion ?? 'Sin ubicación', 40)); ?></span>
                                                </p>
                                                <?php if($ganado->fecha_publicacion): ?>
                                                    <p class="card-text text-muted small mb-1">
                                                        <i class="fas fa-calendar-alt text-success"></i>
                                                        <span class="ml-1">Publicado:
                                                            <?php echo e(\Carbon\Carbon::parse($ganado->fecha_publicacion)->format('d/m/Y')); ?></span>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <span class="badge badge-success badge-lg px-3 py-2 shadow-sm">
                                                    <i class="fas fa-tags"></i>
                                                    <?php echo e($ganado->categoria->nombre ?? 'Sin categoría'); ?>

                                                </span>
                                            </div>
                                            <?php if($ganado->precio): ?>
                                                <div
                                                    class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                                                    <small class="text-muted d-block mb-0">Precio</small>
                                                    <h4 class="text-success font-weight-bold mb-0">
                                                        <i class="fas fa-boliviano-sign"></i>
                                                        <?php echo e(number_format($ganado->precio, 2)); ?>

                                                    </h4>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer bg-white border-top border-success border-2 p-2">
                                            <div class="d-flex gap-2">
                                                <div class="btn btn-success btn-sm flex-fill shadow-sm font-weight-bold">
                                                    <i class="fas fa-eye mr-1"></i> Ver
                                                </div>
                                                <?php if(auth()->guard()->check()): ?>
                                                    <?php if($ganado->precio && ($ganado->stock ?? 0) > 0): ?>
                                                        <form action="<?php echo e(route('cart.add')); ?>" method="POST"
                                                            class="d-inline" onclick="event.stopPropagation();">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="product_type" value="ganado">
                                                            <input type="hidden" name="product_id"
                                                                value="<?php echo e($ganado->id); ?>">
                                                            <input type="hidden" name="cantidad" value="1">
                                                            <button type="submit" class="btn btn-success btn-sm shadow-sm"
                                                                title="Agregar al carrito" onclick="event.stopPropagation();">
                                                                <i class="fas fa-cart-plus"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
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
                        <?php $__currentLoopData = $maquinarias->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maquinaria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <a href="<?php echo e(route('maquinarias.show', $maquinaria->id)); ?>" class="text-decoration-none"
                                    style="color: inherit;">
                                    <div class="card h-100 ganado-card shadow-lg rounded-lg border-success border-3 overflow-hidden"
                                        style="cursor: pointer;">
                                        <?php
                                            $imagenPrincipal = $maquinaria->imagenes->first()->ruta ?? null;
                                        ?>
                                        <?php if($imagenPrincipal): ?>
                                            <div class="card-img-wrapper position-relative overflow-hidden">
                                                <img src="<?php echo e(asset('storage/' . $imagenPrincipal)); ?>"
                                                    class="card-img-top card-maquinaria-img"
                                                    alt="<?php echo e($maquinaria->nombre); ?>">

                                                <div class="position-absolute top-0 right-0 m-2">
                                                    <span class="badge badge-success badge-lg shadow-sm">
                                                        <i class="fas fa-star"></i> Destacado
                                                    </span>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                style="height:220px; border-bottom: 3px solid #28a745;">
                                                <i class="fas fa-tractor fa-4x text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body p-3">
                                            <h5 class="card-title font-weight-bold text-dark mb-2"
                                                style="font-size: 1.1rem; line-height: 1.3;">
                                                <i class="fas fa-tag text-success mr-1"></i><?php echo e($maquinaria->nombre); ?>

                                            </h5>
                                            <div class="mb-2">
                                                <p class="card-text text-muted small mb-1">
                                                    <i class="fas fa-map-marker-alt text-success"></i>
                                                    <span
                                                        class="ml-1"><?php echo e(Str::limit($maquinaria->ubicacion ?? 'Sin ubicación', 40)); ?></span>
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <span class="badge badge-success badge-lg px-3 py-2 shadow-sm">
                                                    <i class="fas fa-tags"></i>
                                                    <?php echo e($maquinaria->categoria->nombre ?? 'Sin categoría'); ?>

                                                </span>
                                            </div>
                                            <?php if($maquinaria->precio_dia): ?>
                                                <div
                                                    class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                                                    <small class="text-muted d-block mb-0">Precio</small>
                                                    <h4 class="text-success font-weight-bold mb-0">
                                                        <i class="fas fa-boliviano-sign"></i>
                                                        <?php echo e(number_format($maquinaria->precio_dia, 2)); ?>/día
                                                    </h4>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer bg-white border-top border-success border-2 p-2">
                                            <div class="d-flex gap-2">
                                                <div class="btn btn-success btn-sm flex-fill shadow-sm font-weight-bold">
                                                    <i class="fas fa-eye mr-1"></i> Ver
                                                </div>
                                                <?php if(auth()->guard()->check()): ?>
                                                    <?php if($maquinaria->precio_dia): ?>
                                                        <form action="<?php echo e(route('cart.add')); ?>" method="POST"
                                                            class="d-inline" onclick="event.stopPropagation();">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="product_type" value="maquinaria">
                                                            <input type="hidden" name="product_id"
                                                                value="<?php echo e($maquinaria->id); ?>">
                                                            <input type="hidden" name="cantidad" value="1">
                                                            <input type="hidden" name="dias_alquiler" value="1">
                                                            <button type="submit" class="btn btn-success btn-sm shadow-sm"
                                                                title="Agregar al carrito" onclick="event.stopPropagation();">
                                                                <i class="fas fa-cart-plus"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
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
                        <?php $__currentLoopData = $organicos->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <a href="<?php echo e(route('organicos.show', $organico->id)); ?>" class="text-decoration-none"
                                    style="color: inherit;">
                                    <div class="card h-100 ganado-card shadow-lg rounded-lg border-success border-3 overflow-hidden"
                                        style="cursor: pointer;">
                                        <?php
                                            $imagenPrincipal = $organico->imagenes->first()->ruta ?? null;
                                        ?>
                                        <?php if($imagenPrincipal): ?>
                                            <div class="card-img-wrapper position-relative overflow-hidden">
                                                <img src="<?php echo e(asset('storage/' . $imagenPrincipal)); ?>"
                                                    class="card-img-top card-organico-img" alt="<?php echo e($organico->nombre); ?>">

                                                <div class="position-absolute top-0 right-0 m-2">
                                                    <span class="badge badge-success badge-lg shadow-sm">
                                                        <i class="fas fa-star"></i> Destacado
                                                    </span>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                style="height:220px; border-bottom: 3px solid #28a745;">
                                                <i class="fas fa-leaf fa-4x text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body p-3">
                                            <h5 class="card-title font-weight-bold text-dark mb-2"
                                                style="font-size: 1.1rem; line-height: 1.3;">
                                                <i class="fas fa-tag text-success mr-1"></i><?php echo e($organico->nombre); ?>

                                            </h5>
                                            <div class="mb-2">
                                                <p class="card-text text-muted small mb-1">
                                                    <i class="fas fa-map-marker-alt text-success"></i>
                                                    <span
                                                        class="ml-1"><?php echo e(Str::limit($organico->origen ?? 'Sin ubicación', 40)); ?></span>
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <span class="badge badge-success badge-lg px-3 py-2 shadow-sm">
                                                    <i class="fas fa-tags"></i>
                                                    <?php echo e($organico->categoria->nombre ?? 'Sin categoría'); ?>

                                                </span>
                                            </div>
                                            <?php if($organico->precio): ?>
                                                <div
                                                    class="bg-success-light p-2 rounded mb-2 border-left border-success border-3">
                                                    <small class="text-muted d-block mb-0">Precio</small>
                                                    <h4 class="text-success font-weight-bold mb-0">
                                                        <i class="fas fa-boliviano-sign"></i>
                                                        <?php echo e(number_format($organico->precio, 2)); ?>

                                                    </h4>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer bg-white border-top border-success border-2 p-2">
                                            <div class="d-flex gap-2">
                                                <div class="btn btn-success btn-sm flex-fill shadow-sm font-weight-bold">
                                                    <i class="fas fa-eye mr-1"></i> Ver
                                                </div>
                                                <?php if(auth()->guard()->check()): ?>
                                                    <?php if($organico->precio && ($organico->stock ?? 0) > 0): ?>
                                                        <form action="<?php echo e(route('cart.add')); ?>" method="POST"
                                                            class="d-inline" onclick="event.stopPropagation();">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="product_type" value="organico">
                                                            <input type="hidden" name="product_id"
                                                                value="<?php echo e($organico->id); ?>">
                                                            <input type="hidden" name="cantidad" value="1">
                                                            <button type="submit" class="btn btn-success btn-sm shadow-sm"
                                                                title="Agregar al carrito" onclick="event.stopPropagation();">
                                                                <i class="fas fa-cart-plus"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
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

    <script>
        // Función para filtrar razas según el tipo de animal seleccionado
        function filtrarRazas() {
            const tipoAnimalId = document.getElementById('tipo_animal_id')?.value;
            const razaSelect = document.getElementById('raza_id');
            if (!razaSelect) return;

            const todasLasOpciones = razaSelect.querySelectorAll('option');

            // Mostrar/ocultar opciones según el tipo de animal
            todasLasOpciones.forEach(option => {
                if (option.value === '') {
                    // Siempre mostrar la opción "Todas las razas"
                    option.style.display = '';
                } else {
                    const tipoAnimalIdRaza = option.getAttribute('data-tipo-animal-id');
                    if (!tipoAnimalId || tipoAnimalIdRaza === tipoAnimalId) {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                }
            });

            // Si la raza seleccionada ya no aplica, limpiarla
            const razaSeleccionada = razaSelect.value;
            if (razaSeleccionada) {
                const opcionSeleccionada = razaSelect.querySelector(`option[value="${razaSeleccionada}"]`);
                if (opcionSeleccionada && opcionSeleccionada.style.display === 'none') {
                    razaSelect.value = '';
                }
            }
        }

        // ===== NUEVO: mostrar/ocultar grupos de filtros según categoría =====
        function actualizarFiltrosPorCategoria() {
            const categoriaSelect = document.getElementById('categoria_id');
            if (!categoriaSelect) return;

            const filtrosAnimales = document.querySelectorAll('.filtros-animales');
            const filtrosMaquinaria = document.querySelectorAll('.filtros-maquinaria');
            const filtrosOrganicos = document.querySelectorAll('.filtros-organicos');

            const option = categoriaSelect.options[categoriaSelect.selectedIndex];
            const texto = option ? option.text.toLowerCase() : '';
            const valor = categoriaSelect.value;

            let mostrarAnimales = false;
            let mostrarMaquinaria = false;
            let mostrarOrganicos = false;

            if (!valor) {
                // Sin categoría: puedes decidir qué mostrar.
                // Aquí muestro TODOS:
                mostrarAnimales = true;
                mostrarMaquinaria = true;
                mostrarOrganicos = true;
            } else if (texto.includes('animal')) {
                mostrarAnimales = true;
            } else if (texto.includes('maquinaria')) {
                mostrarMaquinaria = true;
            } else if (texto.includes('orgánico') || texto.includes('organico')) {
                mostrarOrganicos = true;
            }

            // Helper para mostrar/ocultar grupos
            function toggleGroup(nodes, visible) {
                nodes.forEach(el => {
                    el.style.display = visible ? '' : 'none';
                });
            }

            toggleGroup(filtrosAnimales, mostrarAnimales);
            toggleGroup(filtrosMaquinaria, mostrarMaquinaria);
            toggleGroup(filtrosOrganicos, mostrarOrganicos);

            // Limpiar valores de los grupos ocultos para que no filtren
            if (!mostrarAnimales) {
                const tipoAnimal = document.getElementById('tipo_animal_id');
                const raza = document.getElementById('raza_id');
                if (tipoAnimal) tipoAnimal.value = '';
                if (raza) raza.value = '';
            }

            if (!mostrarMaquinaria) {
                const tipoM = document.getElementById('tipo_maquinaria_id');
                const marca = document.getElementById('marca_maquinaria_id');
                if (tipoM) tipoM.value = '';
                if (marca) marca.value = '';
            }

            if (!mostrarOrganicos) {
                const tipoC = document.getElementById('tipo_cultivo_id');
                if (tipoC) tipoC.value = '';
            }
        }

        function onCategoriaChange(select) {
            actualizarFiltrosPorCategoria();
            // Auto-submit al cambiar categoría
            select.form.submit();
        }

        // Ejecutar al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            actualizarFiltrosPorCategoria();
            filtrarRazas();
        });


        // Ejecutar al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            filtrarRazas();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/public/home.blade.php ENDPATH**/ ?>