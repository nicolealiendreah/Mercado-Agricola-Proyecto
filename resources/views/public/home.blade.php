@extends('layouts.public')
@section('title','Inicio')

@section('content')
<section class="hero" style="background:url('{{ asset('img/bg-agrovida.jpg') }}') center/cover no-repeat; min-height:400px; position:relative;">
  <div class="container py-5 text-white" style="position:relative; z-index:2;">
    <h5 class="mb-2">Bienvenido a Agrovida</h5>
    <h1 class="display-5 font-weight-bold">
      Tu mercado de animales, maquinaria y<br>orgánicos en un solo lugar
    </h1>

    <div class="bg-white p-4 rounded mt-4 shadow-lg">
      <form method="GET" action="{{ route('home') }}" id="searchForm" class="form-row align-items-end">
  <div class="col-md-3 mb-2">
    <label class="text-dark small font-weight-bold mb-1">Categoría</label>
    <select name="categoria_id"
            class="form-control"
            onchange="this.form.submit()">
      <option value="">Todas las categorías</option>
      @foreach($categorias as $categoria)
        <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
          {{ $categoria->nombre }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-md-3 mb-2">
    <label class="text-dark small font-weight-bold mb-1">Tipo de Animal</label>
    <select name="tipo_animal_id"
            id="tipo_animal_id"
            class="form-control"
            onchange="filtrarRazas(); this.form.submit();">
      <option value="">Todos los tipos</option>
      @foreach($tiposAnimales as $tipoAnimal)
        <option value="{{ $tipoAnimal->id }}" {{ request('tipo_animal_id') == $tipoAnimal->id ? 'selected' : '' }}>
          {{ $tipoAnimal->nombre }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-md-3 mb-2">
    <label class="text-dark small font-weight-bold mb-1">Raza</label>
    <select name="raza_id"
            id="raza_id"
            class="form-control"
            onchange="this.form.submit()">
      <option value="">Todas las razas</option>
      @foreach($razas as $raza)
        <option value="{{ $raza->id }}" 
                data-tipo-animal-id="{{ $raza->tipo_animal_id }}"
                {{ request('raza_id') == $raza->id ? 'selected' : '' }}>
          {{ $raza->nombre }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-md-3 mb-2">
    <label class="text-dark small font-weight-bold mb-1">Buscar</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text bg-success text-white"><i class="fas fa-search"></i></span>
      </div>
      <input type="text" name="q" class="form-control"
             placeholder="Buscar productos, marcas, lugares..."
             value="{{ request('q') }}">
    </div>
  </div>

  <div class="col-md-12 mb-2">
    <button type="submit" class="btn btn-success btn-block">
      <i class="fas fa-search"></i> Buscar
    </button>
  </div>
</form>

      @if(request()->has('q') || request()->has('categoria_id') || request()->has('tipo_animal_id') || request()->has('raza_id'))
        <div class="mt-2">
          <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-times"></i> Limpiar filtros
          </a>
        </div>
      @endif
    </div>
  </div>
  <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.3); z-index:1;"></div>
</section>

@if(request()->has('q') || request()->has('categoria_id') || request()->has('tipo_animal_id') || request()->has('raza_id'))
  {{-- RESULTADOS DE BÚSQUEDA --}}
  <section class="container my-5">
    <h2 class="text-success mb-4">
      <i class="fas fa-search"></i> Resultados de búsqueda
      @if(request('q'))
        <small class="text-muted">para "{{ request('q') }}"</small>
      @endif
    </h2>

    {{-- GANADOS --}}
    @if(isset($ganados) && ($ganados->count() > 0 || (method_exists($ganados, 'total') && $ganados->total() > 0)))
      <div class="mb-5">
        <h4 class="text-primary mb-3">
          <i class="fas fa-cow"></i> Animales ({{ method_exists($ganados, 'total') ? $ganados->total() : $ganados->count() }})
        </h4>
        <div class="row">
          @foreach($ganados as $ganado)
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg border-0">
                @if($ganado->imagen)
                  <img src="{{ asset('storage/'.$ganado->imagen) }}" 
                       class="card-img-top" 
                       style="height:200px; object-fit:cover; cursor:pointer;"
                       onclick="window.open('{{ asset('storage/'.$ganado->imagen) }}', '_blank')"
                       alt="{{ $ganado->nombre }}">
                @else
                  <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                  </div>
                @endif
                <div class="card-body">
                  <h5 class="card-title">{{ $ganado->nombre }}</h5>
                  <p class="card-text text-muted small mb-2">
                    <i class="fas fa-map-marker-alt"></i> {{ $ganado->ubicacion ?? 'Sin ubicación' }}
                  </p>
                  <div class="mb-2">
                    <span class="badge badge-success">{{ $ganado->categoria->nombre ?? 'Sin categoría' }}</span>
                    @if($ganado->tipoAnimal)
                      <span class="badge badge-info">{{ $ganado->tipoAnimal->nombre }}</span>
                    @endif
                  </div>
                  @if($ganado->precio)
                    <p class="h5 text-success mb-0">Bs {{ number_format($ganado->precio, 2) }}</p>
                  @endif
                </div>
                <div class="card-footer bg-white border-top">
                  <a href="{{ route('ganados.show', $ganado->id) }}" class="btn btn-success btn-sm btn-block">
                    <i class="fas fa-eye"></i> Ver Detalles
                  </a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        @if(method_exists($ganados, 'links'))
          <div class="mt-3">
            {{ $ganados->appends(request()->query())->links() }}
          </div>
        @endif
      </div>
    @endif

    {{-- MAQUINARIAS --}}
    @if(isset($maquinarias) && ($maquinarias->count() > 0 || (method_exists($maquinarias, 'total') && $maquinarias->total() > 0)))
      <div class="mb-5">
        <h4 class="text-primary mb-3">
          <i class="fas fa-tractor"></i> Maquinaria ({{ method_exists($maquinarias, 'total') ? $maquinarias->total() : $maquinarias->count() }})
        </h4>
        <div class="row">
          @foreach($maquinarias as $maquinaria)
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg border-0">
                @if($maquinaria->imagenes && $maquinaria->imagenes->count() > 0)
                  <img src="{{ asset('storage/'.$maquinaria->imagenes->first()->ruta) }}" 
                       class="card-img-top" 
                       style="height:200px; object-fit:cover; cursor:pointer;"
                       onclick="window.open('{{ asset('storage/'.$maquinaria->imagenes->first()->ruta) }}', '_blank')"
                       alt="{{ $maquinaria->nombre }}">
                @else
                  <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                    <i class="fas fa-tractor fa-4x text-success"></i>
                  </div>
                @endif
                <div class="card-body">
                  <h5 class="card-title">{{ $maquinaria->nombre }}</h5>
                  <p class="card-text text-muted small mb-2">
                    <i class="fas fa-tag"></i> {{ $maquinaria->tipoMaquinaria->nombre ?? 'N/A' }} | 
                    <i class="fas fa-industry"></i> {{ $maquinaria->marcaMaquinaria->nombre ?? 'N/A' }}
                  </p>
                  <div class="mb-2">
                    <span class="badge badge-success">{{ $maquinaria->categoria->nombre ?? 'Sin categoría' }}</span>
                    <span class="badge badge-{{ $maquinaria->estado == 'disponible' ? 'success' : 'secondary' }}">
                      {{ ucfirst(str_replace('_', ' ', $maquinaria->estado ?? 'N/A')) }}
                    </span>
                  </div>
                  @if($maquinaria->precio_dia)
                    <p class="h5 text-success mb-0">Bs {{ number_format($maquinaria->precio_dia, 2) }}/día</p>
                  @endif
                </div>
                <div class="card-footer bg-white border-top">
                  <a href="{{ route('maquinarias.show', $maquinaria->id) }}" class="btn btn-success btn-sm btn-block">
                    <i class="fas fa-eye"></i> Ver Detalles
                  </a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        @if(method_exists($maquinarias, 'links'))
          <div class="mt-3">
            {{ $maquinarias->appends(request()->query())->links() }}
          </div>
        @endif
      </div>
    @endif

    {{-- ORGÁNICOS --}}
    @if(isset($organicos) && ($organicos->count() > 0 || (method_exists($organicos, 'total') && $organicos->total() > 0)))
      <div class="mb-5">
        <h4 class="text-primary mb-3">
          <i class="fas fa-leaf"></i> Orgánicos ({{ method_exists($organicos, 'total') ? $organicos->total() : $organicos->count() }})
        </h4>
        <div class="row">
          @foreach($organicos as $organico)
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg border-0">
                @if($organico->imagenes && $organico->imagenes->count() > 0)
                  <img src="{{ asset('storage/'.$organico->imagenes->first()->ruta) }}" 
                       class="card-img-top" 
                       style="height:200px; object-fit:cover; cursor:pointer;"
                       onclick="window.open('{{ asset('storage/'.$organico->imagenes->first()->ruta) }}', '_blank')"
                       alt="{{ $organico->nombre }}">
                @else
                  <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                    <i class="fas fa-leaf fa-4x text-success"></i>
                  </div>
                @endif
                <div class="card-body">
                  <h5 class="card-title">{{ $organico->nombre }}</h5>
                  <p class="card-text text-muted small mb-2">
                    <i class="fas fa-tag"></i> {{ $organico->categoria->nombre ?? 'Sin categoría' }}
                    @if($organico->unidad)
                      | <i class="fas fa-balance-scale"></i> {{ $organico->unidad->nombre }}
                    @endif
                  </p>
                  <div class="mb-2">
                    @if($organico->stock)
                      <span class="badge badge-info">Stock: {{ $organico->stock }}</span>
                    @endif
                  </div>
                  @if($organico->precio)
                    <p class="h5 text-success mb-0">Bs {{ number_format($organico->precio, 2) }}</p>
                  @endif
                </div>
                <div class="card-footer bg-white border-top">
                  <a href="{{ route('organicos.show', $organico->id) }}" class="btn btn-success btn-sm btn-block">
                    <i class="fas fa-eye"></i> Ver Detalles
                  </a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        @if(method_exists($organicos, 'links'))
          <div class="mt-3">
            {{ $organicos->appends(request()->query())->links() }}
          </div>
        @endif
      </div>
    @endif

    {{-- SIN RESULTADOS --}}
    @if((!isset($ganados) || ($ganados->count() == 0 && (!method_exists($ganados, 'total') || $ganados->total() == 0))) &&
        (!isset($maquinarias) || ($maquinarias->count() == 0 && (!method_exists($maquinarias, 'total') || $maquinarias->total() == 0))) &&
        (!isset($organicos) || ($organicos->count() == 0 && (!method_exists($organicos, 'total') || $organicos->total() == 0))))
      <div class="alert alert-info text-center py-5">
        <i class="fas fa-search fa-3x mb-3"></i>
        <h4>No se encontraron resultados</h4>
        <p>Intenta con otros términos de búsqueda o <a href="{{ route('home') }}">ver todos los productos</a></p>
      </div>
    @endif
  </section>
@else
  {{-- PÁGINA INICIAL SIN BÚSQUEDA --}}
  <section class="container my-5">
    <div class="row align-items-center mb-5">
      <div class="col-md-5 mb-3">
        <img src="{{ asset('img/hero-agrovida.png') }}" class="img-fluid rounded shadow" alt="AgroVida">
      </div>
      <div class="col-md-7">
        <h3 class="text-success font-weight-bold">
          Miles de productos de nuestra industria a un click
        </h3>
        <p class="text-muted">
          Encuentra anuncios de productos y servicios especializados y a sus proveedores directos.
        </p>
        <div class="d-flex flex-column flex-md-row gap-3">
          <a href="{{ route('ads.index') }}" class="btn btn-success btn-lg px-5 shadow-sm">
            <i class="fas fa-search"></i> Navegar Anuncios
          </a>
          @auth
            @if(auth()->user()->isCliente())
              <a href="{{ route('solicitar-vendedor') }}" class="btn btn-primary btn-lg px-5 shadow-sm">
                <i class="fas fa-user-tie"></i> Ser Vendedor
              </a>
            @endif
          @else
            <a href="{{ route('solicitar-vendedor') }}" class="btn btn-primary btn-lg px-5 shadow-sm">
              <i class="fas fa-user-tie"></i> Ser Vendedor
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-5">
              <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </a>
          @endauth
        </div>
      </div>
    </div>

    {{-- PRODUCTOS DESTACADOS --}}
    @if(isset($ganados) && $ganados->count() > 0)
      <div class="mb-5">
        <h3 class="text-success mb-4">
          <i class="fas fa-cow"></i> Animales Destacados
        </h3>
        <div class="row">
          @foreach($ganados->take(3) as $ganado)
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg border-0">
                @if($ganado->imagen)
                  <img src="{{ asset('storage/'.$ganado->imagen) }}" 
                       class="card-img-top" 
                       style="height:200px; object-fit:cover; cursor:pointer;"
                       onclick="window.open('{{ asset('storage/'.$ganado->imagen) }}', '_blank')"
                       alt="{{ $ganado->nombre }}">
                @else
                  <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                  </div>
                @endif
                <div class="card-body">
                  <h5 class="card-title">{{ $ganado->nombre }}</h5>
                  <p class="card-text text-muted small mb-2">
                    <i class="fas fa-map-marker-alt"></i> {{ $ganado->ubicacion ?? 'Sin ubicación' }}
                  </p>
                  <div class="mb-2">
                    <span class="badge badge-success">{{ $ganado->categoria->nombre ?? 'Sin categoría' }}</span>
                  </div>
                  @if($ganado->precio)
                    <p class="h5 text-success mb-0">Bs {{ number_format($ganado->precio, 2) }}</p>
                  @endif
                </div>
                <div class="card-footer bg-white border-top">
                  <div class="d-flex gap-2">
                    <a href="{{ route('ganados.show', $ganado->id) }}" class="btn btn-outline-success btn-sm flex-fill">
                      <i class="fas fa-eye"></i> Ver
                    </a>
                    @auth
                      @if($ganado->precio && ($ganado->stock ?? 0) > 0)
                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                          @csrf
                          <input type="hidden" name="product_type" value="ganado">
                          <input type="hidden" name="product_id" value="{{ $ganado->id }}">
                          <input type="hidden" name="cantidad" value="1">
                          <button type="submit" class="btn btn-success btn-sm" title="Agregar al carrito">
                            <i class="fas fa-cart-plus"></i>
                          </button>
                        </form>
                      @endif
                    @endauth
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="text-center">
          <a href="{{ route('ganados.index') }}" class="btn btn-outline-success">
            Ver todos los animales <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    @endif

    @if(isset($maquinarias) && $maquinarias->count() > 0)
      <div class="mb-5">
        <h3 class="text-success mb-4">
          <i class="fas fa-tractor"></i> Maquinaria Destacada
        </h3>
        <div class="row">
          @foreach($maquinarias->take(3) as $maquinaria)
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg border-0">
                @if($maquinaria->imagenes && $maquinaria->imagenes->count() > 0)
                  <img src="{{ asset('storage/'.$maquinaria->imagenes->first()->ruta) }}" 
                       class="card-img-top" 
                       style="height:200px; object-fit:cover; cursor:pointer;"
                       onclick="window.open('{{ asset('storage/'.$maquinaria->imagenes->first()->ruta) }}', '_blank')"
                       alt="{{ $maquinaria->nombre }}">
                @else
                  <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                    <i class="fas fa-tractor fa-4x text-success"></i>
                  </div>
                @endif
                <div class="card-body">
                  <h5 class="card-title">{{ $maquinaria->nombre }}</h5>
                  <p class="card-text text-muted small mb-2">
                    <i class="fas fa-tag"></i> {{ $maquinaria->tipoMaquinaria->nombre ?? 'N/A' }}
                  </p>
                  @if($maquinaria->precio_dia)
                    <p class="h5 text-success mb-0">Bs {{ number_format($maquinaria->precio_dia, 2) }}/día</p>
                  @endif
                </div>
                <div class="card-footer bg-white border-top">
                  <div class="d-flex gap-2">
                    <a href="{{ route('maquinarias.show', $maquinaria->id) }}" class="btn btn-outline-success btn-sm flex-fill">
                      <i class="fas fa-eye"></i> Ver
                    </a>
                    @auth
                      @if($maquinaria->precio_dia)
                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                          @csrf
                          <input type="hidden" name="product_type" value="maquinaria">
                          <input type="hidden" name="product_id" value="{{ $maquinaria->id }}">
                          <input type="hidden" name="cantidad" value="1">
                          <input type="hidden" name="dias_alquiler" value="1">
                          <button type="submit" class="btn btn-success btn-sm" title="Agregar al carrito">
                            <i class="fas fa-cart-plus"></i>
                          </button>
                        </form>
                      @endif
                    @endauth
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="text-center">
          <a href="{{ route('maquinarias.index') }}" class="btn btn-outline-success">
            Ver toda la maquinaria <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    @endif

    @if(isset($organicos) && $organicos->count() > 0)
      <div class="mb-5">
        <h3 class="text-success mb-4">
          <i class="fas fa-leaf"></i> Productos Orgánicos Destacados
        </h3>
        <div class="row">
          @foreach($organicos->take(3) as $organico)
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm rounded-lg border-0">
                @if($organico->imagenes && $organico->imagenes->count() > 0)
                  <img src="{{ asset('storage/'.$organico->imagenes->first()->ruta) }}" 
                       class="card-img-top" 
                       style="height:200px; object-fit:cover; cursor:pointer;"
                       onclick="window.open('{{ asset('storage/'.$organico->imagenes->first()->ruta) }}', '_blank')"
                       alt="{{ $organico->nombre }}">
                @else
                  <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                    <i class="fas fa-leaf fa-4x text-success"></i>
                  </div>
                @endif
                <div class="card-body">
                  <h5 class="card-title">{{ $organico->nombre }}</h5>
                  <p class="card-text text-muted small mb-2">
                    <i class="fas fa-tag"></i> {{ $organico->categoria->nombre ?? 'Sin categoría' }}
                  </p>
                  @if($organico->precio)
                    <p class="h5 text-success mb-0">Bs {{ number_format($organico->precio, 2) }}</p>
                  @endif
                </div>
                <div class="card-footer bg-white border-top">
                  <div class="d-flex gap-2">
                    <a href="{{ route('organicos.show', $organico->id) }}" class="btn btn-outline-success btn-sm flex-fill">
                      <i class="fas fa-eye"></i> Ver
                    </a>
                    @auth
                      @if($organico->precio && ($organico->stock ?? 0) > 0)
                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                          @csrf
                          <input type="hidden" name="product_type" value="organico">
                          <input type="hidden" name="product_id" value="{{ $organico->id }}">
                          <input type="hidden" name="cantidad" value="1">
                          <button type="submit" class="btn btn-success btn-sm" title="Agregar al carrito">
                            <i class="fas fa-cart-plus"></i>
                          </button>
                        </form>
                      @endif
                    @endauth
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="text-center">
          <a href="{{ route('organicos.index') }}" class="btn btn-outline-success">
            Ver todos los orgánicos <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    @endif
  </section>
@endif

<script>
// Función para filtrar razas según el tipo de animal seleccionado
function filtrarRazas() {
    const tipoAnimalId = document.getElementById('tipo_animal_id').value;
    const razaSelect = document.getElementById('raza_id');
    const todasLasOpciones = razaSelect.querySelectorAll('option');
    
    // Mostrar/ocultar opciones según el tipo de animal
    todasLasOpciones.forEach(option => {
        if (option.value === '') {
            // Siempre mostrar la opción "Todas las razas"
            option.style.display = '';
        } else {
            const tipoAnimalIdRaza = option.getAttribute('data-tipo-animal-id');
            if (tipoAnimalId === '' || tipoAnimalIdRaza === tipoAnimalId) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
    });
    
    // Si se cambió el tipo de animal y la raza seleccionada no corresponde, limpiar la selección
    const razaSeleccionada = razaSelect.value;
    if (razaSeleccionada) {
        const opcionSeleccionada = razaSelect.querySelector(`option[value="${razaSeleccionada}"]`);
        if (opcionSeleccionada && opcionSeleccionada.style.display === 'none') {
            razaSelect.value = '';
        }
    }
}

// Ejecutar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    filtrarRazas();
});
</script>
@endsection
