<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','AgroVida')</title>

  <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body class="hold-transition layout-top-nav {{ request()->routeIs('login','register') ? 'no-topbar' : '' }}">
<div class="wrapper">

  @if (!request()->routeIs('login','register'))
  <nav class="main-header navbar navbar-expand navbar-white navbar-light border-0 project-topbar">
    <div class="container">
      <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">
        <img src="{{ asset('img/logo-agrovida.png') }}" alt="AgroVida" style="height:34px">
        <span class="brand-text font-weight-bold ml-2 text-white">AgroVida Bolivia</span>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topnav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div id="topnav" class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('home')?'active':'' }}" href="{{ route('home') }}">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('ads.index') }}">Anuncios</a>
          </li>
          @auth
            <li class="nav-item dropdown">
              <a class="nav-link text-white dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                <span class="badge badge-light ml-1">{{ auth()->user()->role_name }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('home') }}" class="dropdown-item">
                  <i class="fas fa-home mr-2"></i> Inicio
                </a>
                @if(auth()->user()->isCliente())
                  <a href="{{ route('solicitar-vendedor') }}" class="dropdown-item">
                    <i class="fas fa-user-tie mr-2"></i> Ser Vendedor
                  </a>
                @endif
                @if(auth()->user()->isAdmin())
                  <a href="{{ route('admin.solicitudes-vendedor.index') }}" class="dropdown-item">
                    <i class="fas fa-clipboard-list mr-2"></i> Panel Admin
                  </a>
                @endif
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item">
                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                  </button>
                </form>
              </div>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link text-white" href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-success text-white px-3 ml-lg-2" href="{{ route('register') }}">
                Registrarse <i class="fas fa-user-plus ml-1"></i>
              </a>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>
  @endif


  <div class="content-wrapper bg-white">
    @yield('content')
  </div>

  <footer class="main-footer text-sm">
    <div class="container">
      <strong>© {{ date('Y') }} AgroVida.</strong> Tu mercado agrícola.
      <span class="float-right d-none d-sm-inline">Hecho con AdminLTE 3</span>
    </div>
  </footer>
</div>

<script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
