<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $__env->yieldContent('title','AgroVida'); ?></title>

  <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/css/adminlte.min.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
</head>

<body class="hold-transition layout-top-nav <?php echo e(request()->routeIs('login','register') ? 'no-topbar' : ''); ?>">
<div class="wrapper">

  <?php if(!request()->routeIs('login','register')): ?>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light border-0 project-topbar">
    <div class="container">
      <a href="<?php echo e(route('home')); ?>" class="navbar-brand d-flex align-items-center">
        <img src="<?php echo e(asset('img/logo-agrovida.png')); ?>" alt="AgroVida" style="height:34px">
        <span class="brand-text font-weight-bold ml-2 text-white">AgroVida Bolivia</span>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topnav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div id="topnav" class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-white <?php echo e(request()->routeIs('home')?'active':''); ?>" href="<?php echo e(route('home')); ?>">
              <i class="fas fa-home"></i> Inicio
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?php echo e(request()->routeIs('ads.index')?'active':''); ?>" href="<?php echo e(route('ads.index')); ?>">
              <i class="fas fa-bullhorn"></i> Anuncios
            </a>
          </li>
          <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->user()->isVendedor() || auth()->user()->isAdmin()): ?>
              <li class="nav-item">
                <a class="nav-link text-white <?php echo e(request()->routeIs('admin.datos-sanitarios.*')?'active':''); ?>" href="<?php echo e(route('admin.datos-sanitarios.index')); ?>">
                  <i class="fas fa-syringe"></i> Datos Sanitarios
                </a>
              </li>
            <?php endif; ?>
            <?php if(auth()->user()->isCliente()): ?>
              <li class="nav-item">
                <a class="nav-link text-white <?php echo e(request()->routeIs('solicitar-vendedor')?'active':''); ?>" href="<?php echo e(route('solicitar-vendedor')); ?>">
                  <i class="fas fa-user-tie"></i> Ser Vendedor
                </a>
              </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link text-white <?php echo e(request()->routeIs('cart.*')?'active':''); ?>" href="<?php echo e(route('cart.index')); ?>">
                <i class="fas fa-shopping-cart"></i> Carrito
                <?php
                  $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('cantidad');
                ?>
                <?php if($cartCount > 0): ?>
                  <span class="badge badge-danger badge-sm" id="cart-count"><?php echo e($cartCount); ?></span>
                <?php endif; ?>
              </a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link text-white" href="<?php echo e(route('solicitar-vendedor')); ?>">
                <i class="fas fa-user-tie"></i> Ser Vendedor
              </a>
            </li>
          <?php endif; ?>
          <?php if(auth()->guard()->check()): ?>
            <li class="nav-item dropdown">
              <a class="nav-link text-white dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="fas fa-user-circle"></i> <?php echo e(auth()->user()->name); ?>

                <span class="badge badge-light ml-1"><?php echo e(auth()->user()->role_name); ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a href="<?php echo e(route('home')); ?>" class="dropdown-item">
                  <i class="fas fa-home mr-2"></i> Inicio
                </a>
                <?php if(auth()->user()->isCliente()): ?>
                  <a href="<?php echo e(route('solicitar-vendedor')); ?>" class="dropdown-item">
                    <i class="fas fa-user-tie mr-2"></i> Ser Vendedor
                  </a>
                <?php endif; ?>
                <?php if(auth()->user()->isAdmin()): ?>
                  <a href="<?php echo e(route('admin.solicitudes-vendedor.index')); ?>" class="dropdown-item">
                    <i class="fas fa-clipboard-list mr-2"></i> Panel Admin
                  </a>
                <?php endif; ?>
                <div class="dropdown-divider"></div>
                <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                  <?php echo csrf_field(); ?>
                  <button type="submit" class="dropdown-item">
                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                  </button>
                </form>
              </div>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link text-white" href="<?php echo e(route('login')); ?>">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-success text-white px-3 ml-lg-2" href="<?php echo e(route('register')); ?>">
                Registrarse <i class="fas fa-user-plus ml-1"></i>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <?php endif; ?>


  <div class="content-wrapper bg-white">
    <?php echo $__env->yieldContent('content'); ?>
  </div>

  <footer class="main-footer text-sm">
    <div class="container">
      <strong>© <?php echo e(date('Y')); ?> AgroVida.</strong> Tu mercado agrícola.
      <span class="float-right d-none d-sm-inline">Hecho con AdminLTE 3</span>
    </div>
  </footer>
</div>

<script src="<?php echo e(asset('vendor/adminlte/plugins/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/adminlte/dist/js/adminlte.min.js')); ?>"></script>
</body>
</html>

<?php /**PATH C:\Users\Nicole\proy2\ProyectoAgricolaLocal\resources\views/layouts/public.blade.php ENDPATH**/ ?>