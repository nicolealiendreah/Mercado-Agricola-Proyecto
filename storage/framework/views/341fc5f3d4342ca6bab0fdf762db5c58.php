<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $__env->yieldContent('title','Mercado Agrícola'); ?></title>

  <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/css/adminlte.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
</head>

<body class="hold-transition sidebar-mini layout-fixed theme-agro">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo e(route('home')); ?>" class="nav-link">Inicio</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <?php if(auth()->guard()->check()): ?>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-user-circle"></i>
            <span class="d-none d-md-inline ml-1"><?php echo e(auth()->user()->name); ?></span>
            <span class="badge badge-info ml-1"><?php echo e(auth()->user()->role_name); ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">
              <?php echo e(auth()->user()->name); ?>

              <br>
              <small><?php echo e(auth()->user()->email); ?></small>
            </span>
            <div class="dropdown-divider"></div>
            <a href="<?php echo e(route('home')); ?>" class="dropdown-item">
              <i class="fas fa-home mr-2"></i> Ir al Inicio
            </a>
            <?php if(auth()->user()->isCliente()): ?>
              <a href="<?php echo e(route('solicitar-vendedor')); ?>" class="dropdown-item">
                <i class="fas fa-user-tie mr-2"></i> Ser Vendedor
              </a>
            <?php endif; ?>
            <?php if(auth()->user()->isAdmin()): ?>
              <a href="<?php echo e(route('admin.solicitudes-vendedor.index')); ?>" class="dropdown-item">
                <i class="fas fa-clipboard-list mr-2"></i> Solicitudes de Vendedor
              </a>
            <?php endif; ?>
            <div class="dropdown-divider"></div>
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
              <?php echo csrf_field(); ?>
              <button type="submit" class="dropdown-item dropdown-footer">
                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
              </button>
            </form>
          </div>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a href="<?php echo e(route('login')); ?>" class="nav-link">
            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo e(route('register')); ?>" class="nav-link">
            <i class="fas fa-user-plus"></i> Registrarse
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="<?php echo e(url('/')); ?>" class="brand-link">
      <span class="brand-text font-weight-light">Mercado Agrícola</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column">

          <?php if(auth()->guard()->check()): ?>
            
            <?php if(auth()->user()->isVendedor() || auth()->user()->isAdmin()): ?>
              <!-- GANADO -->
              <li class="nav-item">
                <a href="<?php echo e(route('ganados.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('ganados.*') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-cow"></i>
                  <p>Animales</p>
                </a>
              </li>

              <!-- MAQUINARIA -->
              <li class="nav-item">
                <a href="<?php echo e(route('maquinarias.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('maquinarias.*') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-tractor"></i>
                  <p>Maquinaria</p>
                </a>
              </li>

              <!-- ORGÁNICOS -->
              <li class="nav-item">
                <a href="<?php echo e(route('organicos.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('organicos.*') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-leaf"></i>
                  <p>Orgánicos</p>
                </a>
              </li>
            <?php endif; ?>

            
            <?php if(auth()->user()->isAdmin()): ?>
              <li class="nav-header">CONFIGURACIÓN</li>
              
              <!-- CATEGORÍAS -->
              <li class="nav-item">
                <a href="<?php echo e(route('admin.categorias.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.categorias.*') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-tags"></i>
                  <p>Categorías</p>
                </a>
              </li>

              <!-- TIPOS DE ANIMAL -->
              <li class="nav-item">
                <a href="<?php echo e(route('admin.tipo_animals.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.tipo_animals.*') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-paw"></i>
                  <p>Tipos de Animal</p>
                </a>
              </li>

              <!-- TIPO DE PESO -->
              <li class="nav-item">
                <a href="<?php echo e(route('admin.tipo-pesos.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.tipo-pesos.*') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-weight-hanging"></i>
                  <p>Tipo de Peso</p>
                </a>
              </li>

              <!-- DATOS SANITARIOS -->
              <li class="nav-item">
                <a href="<?php echo e(route('admin.datos-sanitarios.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.datos-sanitarios.*') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-syringe"></i>
                  <p>Datos Sanitarios</p>
                </a>
              </li>

              <!-- RAZAS -->
              <li class="nav-item">
                <a href="<?php echo e(route('admin.razas.index')); ?>" 
                   class="nav-link <?php echo e(request()->routeIs('admin.razas.*') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-dna"></i>
                  <p>Razas</p>
                </a>
              </li>

              <li class="nav-header">GESTIÓN</li>

              <!-- SOLICITUDES DE VENDEDOR -->
              <li class="nav-item">
                <a href="<?php echo e(route('admin.solicitudes-vendedor.index')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('admin.solicitudes-vendedor.*') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-clipboard-list"></i>
                  <p>Solicitudes de Vendedor</p>
                </a>
              </li>
            <?php endif; ?>

            
            <?php if(auth()->user()->isCliente()): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('solicitar-vendedor')); ?>"
                   class="nav-link <?php echo e(request()->routeIs('solicitar-vendedor*') ? 'active' : ''); ?>">
                  <i class="nav-icon fas fa-user-tie"></i>
                  <p>Solicitar ser Vendedor</p>
                </a>
              </li>
            <?php endif; ?>
          <?php endif; ?>

        </ul>

      </nav>
    </div>

  </aside>
  <!-- /.sidebar -->

  <!-- Content -->
  <div class="content-wrapper">

    <section class="content-header">
      <div class="container-fluid">
        <h1><?php echo $__env->yieldContent('page_title','Panel'); ?></h1>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <?php echo $__env->yieldContent('content'); ?>
      </div>
    </section>

  </div>

  <!-- Footer -->
  <footer class="main-footer text-sm text-center">
    © <?php echo e(date('Y')); ?> Mercado Agrícola
  </footer>

</div>

<script src="<?php echo e(asset('vendor/adminlte/plugins/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/adminlte/dist/js/adminlte.min.js')); ?>"></script>

</body>
</html>
<?php /**PATH C:\dev\Proyecto-Mercado-Agricola-main\Proyecto-Mercado-Agricola-main\resources\views/layouts/adminlte.blade.php ENDPATH**/ ?>