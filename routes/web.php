<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganicoController;
use App\Http\Controllers\MaquinariaController;
use App\Http\Controllers\GanadoController;
use App\Http\Controllers\TipoAnimalController;
use App\Http\Controllers\TipoPesoController;
use App\Http\Controllers\DatoSanitarioController;
use App\Http\Controllers\RazaController;
use App\Http\Controllers\EstadoMaquinariaController;
use App\Http\Controllers\SolicitudVendedorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\AdminPedidoController;

// 1) Raíz -> login (pantalla principal)
Route::redirect('/', '/login');

// 2) Autenticación
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    
    // Registro
    Route::get('/registro', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/registro', [RegisterController::class, 'register'])->name('register.post');
});

// Logout (solo para usuarios autenticados)
Route::middleware('auth')->post('/logout', [LoginController::class, 'logout'])->name('logout');

// 3) Home público (portada con hero)
Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 4) Páginas públicas
Route::get('/anuncios', [App\Http\Controllers\HomeController::class, 'anuncios'])->name('ads.index');
Route::view('/publicar', 'public.ads.create')->name('ads.create');

// ============================================
// RUTAS POR ROLES
// ============================================

// ===== ADMINISTRADOR =====
// Solo ADMIN puede acceder a configuración y parámetros
Route::middleware(['auth', 'role.admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Gestión de solicitudes de vendedor
    Route::get('/solicitudes-vendedor', [SolicitudVendedorController::class, 'index'])->name('solicitudes-vendedor.index');
    Route::get('/solicitudes-vendedor/{solicitudVendedor}', [SolicitudVendedorController::class, 'show'])->name('solicitudes-vendedor.show');
    Route::post('/solicitudes-vendedor/{id}/aprobar', [SolicitudVendedorController::class, 'aprobar'])->name('solicitudes-vendedor.aprobar');
    Route::post('/solicitudes-vendedor/{id}/rechazar', [SolicitudVendedorController::class, 'rechazar'])->name('solicitudes-vendedor.rechazar');
    
    // Parámetros del sistema (solo ADMIN)
    Route::resource('categorias', App\Http\Controllers\CategoriaController::class);
    Route::resource('tipo_animals', TipoAnimalController::class);
    Route::resource('tipo-pesos', TipoPesoController::class);
    Route::resource('razas', RazaController::class);
    Route::resource('tipo_maquinarias', App\Http\Controllers\TipoMaquinariaController::class);
    Route::resource('marcas_maquinarias', App\Http\Controllers\MarcaMaquinariaController::class);
    Route::resource('estado_maquinarias', EstadoMaquinariaController::class);
    Route::resource('unidades_organicos', App\Http\Controllers\UnidadOrganicoController::class);

    Route::get('/pedidos', [AdminPedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{pedido}', [AdminPedidoController::class, 'show'])->name('pedidos.show');
    Route::put('/pedidos/{pedido}/estado', [AdminPedidoController::class, 'updateEstado'])->name('pedidos.updateEstado');

});

// ===== VENDEDOR Y ADMINISTRADOR =====
// Datos sanitarios (VENDEDOR y ADMIN pueden acceder)
Route::middleware(['auth', 'role.vendedor'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('datos-sanitarios', DatoSanitarioController::class);
});

// ===== VENDEDOR Y ADMINISTRADOR =====
// VENDEDOR y ADMIN pueden publicar productos
Route::middleware(['auth', 'role.vendedor'])->group(function () {
    // Publicación de productos (crear, editar, eliminar)
    Route::resource('ganados', GanadoController::class)->except(['index', 'show']);
    Route::resource('maquinarias', MaquinariaController::class)->except(['index', 'show'])->names('maquinarias');
    Route::resource('organicos', OrganicoController::class)->except(['index', 'show'])->names('organicos');
});

// ===== TODOS LOS USUARIOS AUTENTICADOS =====
// Rutas de visualización que todos pueden ver (solo lectura)
Route::middleware('auth')->group(function () {
    Route::get('ganados', [GanadoController::class, 'index'])->name('ganados.index');
    Route::get('ganados/{ganado}', [GanadoController::class, 'show'])->name('ganados.show');
    Route::get('maquinarias', [MaquinariaController::class, 'index'])->name('maquinarias.index');
    Route::get('maquinarias/{maquinaria}', [MaquinariaController::class, 'show'])->name('maquinarias.show');
    Route::get('organicos', [OrganicoController::class, 'index'])->name('organicos.index');
    Route::get('organicos/{organico}', [OrganicoController::class, 'show'])->name('organicos.show');
    
    // Carrito de compras
    Route::get('carrito', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('carrito/agregar', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::put('carrito/{cartItem}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('carrito/{cartItem}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('carrito', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    Route::get('carrito/count', [App\Http\Controllers\CartController::class, 'getCount'])->name('cart.count');
    
    // API para obtener información geográfica desde coordenadas
    Route::get('/api/geocodificacion', [GanadoController::class, 'obtenerGeocodificacion'])->name('api.geocodificacion');

        // Pedidos (historial del usuario)
    Route::get('/mis-pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/mis-pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');

});

// ===== CLIENTE =====
// CLIENTE puede solicitar ser vendedor
Route::middleware(['auth', 'role.cliente'])->group(function () {
    Route::get('/solicitar-vendedor', [SolicitudVendedorController::class, 'create'])->name('solicitar-vendedor');
    Route::post('/solicitar-vendedor', [SolicitudVendedorController::class, 'store'])->name('solicitar-vendedor.store');
});
