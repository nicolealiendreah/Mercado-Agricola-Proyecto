<?php $__env->startSection('title','Crear cuenta'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card shadow-sm rounded-lg">
        <div class="card-body p-4 p-md-5">
          <div class="text-center mb-3">
            <img src="<?php echo e(asset('img/logo-agrovida.png')); ?>" alt="AgroVida" style="height:64px">
          </div>
          <h5 class="text-center mb-1">Crear cuenta</h5>
          <p class="text-center text-muted mb-4">Completa tus datos para comenzar</p>

          <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

          <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

          <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <h6 class="alert-heading">
                <i class="fas fa-exclamation-triangle"></i> Por favor, corrige los siguientes errores:
              </h6>
              <ul class="mb-0 small">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

          <form action="<?php echo e(route('register.post')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="form-group">
              <label class="mb-1">Nombre Completo *</label>
              <input type="text" 
                     name="name" 
                     class="form-control form-control-lg login-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                     placeholder="Escribir Nombre"
                     value="<?php echo e(old('name')); ?>"
                     required
                     autofocus>
              <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
              <label class="mb-1">Correo Electrónico *</label>
              <input type="email" 
                     name="email" 
                     class="form-control form-control-lg login-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                     placeholder="Correo Electrónico"
                     value="<?php echo e(old('email')); ?>"
                     required>
              <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
              <label class="mb-1">Contraseña *</label>
              <input type="password" 
                     name="password" 
                     class="form-control form-control-lg login-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                     placeholder="Contraseña"
                     required
                     minlength="8">
              <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              <small class="form-text text-muted">Mínimo 8 caracteres.</small>
            </div>

            <div class="form-group">
              <label class="mb-1">Confirmar Contraseña *</label>
              <input type="password" 
                     name="password_confirmation" 
                     class="form-control form-control-lg login-input" 
                     placeholder="Confirmar Contraseña"
                     required
                     minlength="8">
            </div>

            <button type="submit" class="btn btn-success btn-lg btn-block">
              <i class="fas fa-user-plus"></i> Crear Cuenta
            </button>

            <p class="text-center mt-3 mb-0">
              ¿Ya tienes cuenta?
              <a href="<?php echo e(route('login')); ?>" class="font-weight-bold">Inicia sesión</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nicole\proyecto\Proyecto-Agricola\resources\views/public/auth/register.blade.php ENDPATH**/ ?>