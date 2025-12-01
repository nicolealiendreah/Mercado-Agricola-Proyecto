<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?php echo $__env->yieldContent('title','Mercado Agrícola'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="<?php echo e(asset('gentelella/vendors/bootstrap/dist/css/bootstrap.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('gentelella/vendors/font-awesome/css/font-awesome.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('gentelella/vendors/nprogress/nprogress.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('gentelella/build/css/custom.min.css')); ?>">
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <!-- 🔵 Quitamos sidebar totalmente -->
      <!-- 🔵 Quitamos left_col -->
      <!-- 🔵 Quitamos menú negro -->

      <!-- Navbar superior -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="<?php echo e(url('/')); ?>">Inicio</a></li>
            </ul>
          </nav>
        </div>
      </div>

      <!-- Contenido principal FULL WIDTH -->
      <div class="right_col" role="main" style="margin-left:0 !important;">
        <?php echo $__env->yieldContent('content'); ?>
      </div>

      <!-- Footer -->
      <footer>
        <div class="pull-right">Laravel + PostgreSQL + Gentelella</div>
        <div class="clearfix"></div>
      </footer>

    </div>
  </div>

  <script src="<?php echo e(asset('gentelella/vendors/jquery/dist/jquery.min.js')); ?>"></script>
  <script src="<?php echo e(asset('gentelella/vendors/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
  <script src="<?php echo e(asset('gentelella/vendors/fastclick/lib/fastclick.js')); ?>"></script>
  <script src="<?php echo e(asset('gentelella/vendors/nprogress/nprogress.js')); ?>"></script>
  <script src="<?php echo e(asset('gentelella/build/js/custom.min.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\Users\Nicole\proy2\ProyectoAgricolaLocal\resources\views/layouts/gentelella.blade.php ENDPATH**/ ?>