<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\User;
use App\Models\TipoCultivo;
use App\Exports\VentasExport;
use App\Exports\VendedoresExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    /**
     * Reporte de Análisis de Ventas y Rentabilidad
     */
    public function ventas(Request $request)
    {
        // Filtros
        $desde = $request->desde ? Carbon::parse($request->desde) : Carbon::now()->subMonths(6);
        $hasta = $request->hasta ? Carbon::parse($request->hasta) : Carbon::now();
        $categoria = $request->categoria; // ganado, maquinaria, organico
        $estado = $request->estado; // pendiente, completado, cancelado
        $vendedor_id = $request->vendedor_id;

        // Query base de pedidos
        $pedidosQuery = Pedido::with(['user', 'detalles'])
            ->whereBetween('created_at', [$desde, $hasta]);

        if ($estado) {
            $pedidosQuery->where('estado', $estado);
        }

        if ($vendedor_id) {
            $pedidosQuery->where('user_id', $vendedor_id);
        }

        $pedidos = $pedidosQuery->get();

        // 1. VENTAS TOTALES POR CATEGORÍA
        $ventasPorCategoria = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
            ->whereBetween('pedidos.created_at', [$desde, $hasta])
            ->when($estado, function ($q) use ($estado) {
                return $q->where('pedidos.estado', $estado);
            })
            ->when($vendedor_id, function ($q) use ($vendedor_id) {
                return $q->where('pedidos.user_id', $vendedor_id);
            })
            ->when($categoria, function ($q) use ($categoria) {
                return $q->where('pedido_detalles.product_type', $categoria);
            })
            ->select(
                'pedido_detalles.product_type as categoria',
                DB::raw('COUNT(DISTINCT pedidos.id) as total_pedidos'),
                DB::raw('SUM(pedido_detalles.cantidad) as total_cantidad'),
                DB::raw('SUM(pedido_detalles.subtotal) as ingresos_totales'),
                DB::raw('AVG(pedido_detalles.precio_unitario) as precio_promedio')
            )
            ->groupBy('pedido_detalles.product_type')
            ->get();

        // 2. COMPARATIVA MENSUAL (últimos 6 meses)
        $labelsMeses = [];
        $ventasGanado = [];
        $ventasMaquinaria = [];
        $ventasOrganico = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $mesInicio = $fecha->copy()->startOfMonth();
            $mesFin = $fecha->copy()->endOfMonth();

            $labelsMeses[] = $fecha->translatedFormat('M Y');

            $ventasGanado[] = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
                ->where('pedido_detalles.product_type', 'ganado')
                ->whereBetween('pedidos.created_at', [$mesInicio, $mesFin])
                ->when($estado, fn($q) => $q->where('pedidos.estado', $estado))
                ->when($vendedor_id, fn($q) => $q->where('pedidos.user_id', $vendedor_id))
                ->sum('pedido_detalles.subtotal');

            $ventasMaquinaria[] = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
                ->where('pedido_detalles.product_type', 'maquinaria')
                ->whereBetween('pedidos.created_at', [$mesInicio, $mesFin])
                ->when($estado, fn($q) => $q->where('pedidos.estado', $estado))
                ->when($vendedor_id, fn($q) => $q->where('pedidos.user_id', $vendedor_id))
                ->sum('pedido_detalles.subtotal');

            $ventasOrganico[] = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
                ->where('pedido_detalles.product_type', 'organico')
                ->whereBetween('pedidos.created_at', [$mesInicio, $mesFin])
                ->when($estado, fn($q) => $q->where('pedidos.estado', $estado))
                ->when($vendedor_id, fn($q) => $q->where('pedidos.user_id', $vendedor_id))
                ->sum('pedido_detalles.subtotal');
        }

        // 3. TOP 10 VENDEDORES POR VOLUMEN DE VENTAS (basado en productos vendidos)
        $ventasPorVendedor = [];
        
        // Obtener ventas de ganado por vendedor
        $ventasGanado = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
            ->join('ganados', 'pedido_detalles.product_id', '=', 'ganados.id')
            ->where('pedido_detalles.product_type', 'ganado')
            ->whereBetween('pedidos.created_at', [$desde, $hasta])
            ->when($estado, fn($q) => $q->where('pedidos.estado', $estado))
            ->select(
                'ganados.user_id as vendedor_id',
                DB::raw('COUNT(DISTINCT pedidos.id) as total_pedidos'),
                DB::raw('SUM(pedido_detalles.subtotal) as ingresos_totales'),
                DB::raw('SUM(pedido_detalles.cantidad) as total_cantidad')
            )
            ->groupBy('ganados.user_id')
            ->get();
        
        foreach ($ventasGanado as $venta) {
            $vendedorId = $venta->vendedor_id;
            if (!isset($ventasPorVendedor[$vendedorId])) {
                $ventasPorVendedor[$vendedorId] = [
                    'total_pedidos' => 0,
                    'ingresos_totales' => 0,
                    'total_cantidad' => 0,
                ];
            }
            $ventasPorVendedor[$vendedorId]['total_pedidos'] += $venta->total_pedidos;
            $ventasPorVendedor[$vendedorId]['ingresos_totales'] += $venta->ingresos_totales;
            $ventasPorVendedor[$vendedorId]['total_cantidad'] += $venta->total_cantidad;
        }
        
        // Obtener ventas de maquinaria por vendedor
        $ventasMaquinaria = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
            ->join('maquinarias', 'pedido_detalles.product_id', '=', 'maquinarias.id')
            ->where('pedido_detalles.product_type', 'maquinaria')
            ->whereBetween('pedidos.created_at', [$desde, $hasta])
            ->when($estado, fn($q) => $q->where('pedidos.estado', $estado))
            ->select(
                'maquinarias.user_id as vendedor_id',
                DB::raw('COUNT(DISTINCT pedidos.id) as total_pedidos'),
                DB::raw('SUM(pedido_detalles.subtotal) as ingresos_totales'),
                DB::raw('SUM(pedido_detalles.cantidad) as total_cantidad')
            )
            ->groupBy('maquinarias.user_id')
            ->get();
        
        foreach ($ventasMaquinaria as $venta) {
            $vendedorId = $venta->vendedor_id;
            if (!isset($ventasPorVendedor[$vendedorId])) {
                $ventasPorVendedor[$vendedorId] = [
                    'total_pedidos' => 0,
                    'ingresos_totales' => 0,
                    'total_cantidad' => 0,
                ];
            }
            $ventasPorVendedor[$vendedorId]['total_pedidos'] += $venta->total_pedidos;
            $ventasPorVendedor[$vendedorId]['ingresos_totales'] += $venta->ingresos_totales;
            $ventasPorVendedor[$vendedorId]['total_cantidad'] += $venta->total_cantidad;
        }
        
        // Obtener ventas de orgánicos por vendedor
        $ventasOrganico = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
            ->join('organicos', 'pedido_detalles.product_id', '=', 'organicos.id')
            ->where('pedido_detalles.product_type', 'organico')
            ->whereBetween('pedidos.created_at', [$desde, $hasta])
            ->when($estado, fn($q) => $q->where('pedidos.estado', $estado))
            ->select(
                'organicos.user_id as vendedor_id',
                DB::raw('COUNT(DISTINCT pedidos.id) as total_pedidos'),
                DB::raw('SUM(pedido_detalles.subtotal) as ingresos_totales'),
                DB::raw('SUM(pedido_detalles.cantidad) as total_cantidad')
            )
            ->groupBy('organicos.user_id')
            ->get();
        
        foreach ($ventasOrganico as $venta) {
            $vendedorId = $venta->vendedor_id;
            if (!isset($ventasPorVendedor[$vendedorId])) {
                $ventasPorVendedor[$vendedorId] = [
                    'total_pedidos' => 0,
                    'ingresos_totales' => 0,
                    'total_cantidad' => 0,
                ];
            }
            $ventasPorVendedor[$vendedorId]['total_pedidos'] += $venta->total_pedidos;
            $ventasPorVendedor[$vendedorId]['ingresos_totales'] += $venta->ingresos_totales;
            $ventasPorVendedor[$vendedorId]['total_cantidad'] += $venta->total_cantidad;
        }
        
        // Convertir a colección y ordenar
        $topVendedores = collect($ventasPorVendedor)
            ->map(function ($ventas, $vendedorId) {
                $user = User::find($vendedorId);
                $ticketPromedio = $ventas['total_pedidos'] > 0 
                    ? $ventas['ingresos_totales'] / $ventas['total_pedidos'] 
                    : 0;
                
                return [
                    'vendedor_id' => $vendedorId,
                    'nombre' => $user ? $user->name : 'Usuario eliminado',
                    'email' => $user ? $user->email : '-',
                    'total_pedidos' => $ventas['total_pedidos'],
                    'ingresos_totales' => $ventas['ingresos_totales'],
                    'total_cantidad' => $ventas['total_cantidad'],
                    'ticket_promedio' => round($ticketPromedio, 2),
                ];
            })
            ->sortByDesc('ingresos_totales')
            ->take(10)
            ->values();

        // 4. PRODUCTOS MÁS VENDIDOS POR CATEGORÍA
        $productosMasVendidos = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
            ->whereBetween('pedidos.created_at', [$desde, $hasta])
            ->when($estado, fn($q) => $q->where('pedidos.estado', $estado))
            ->when($vendedor_id, fn($q) => $q->where('pedidos.user_id', $vendedor_id))
            ->when($categoria, fn($q) => $q->where('pedido_detalles.product_type', $categoria))
            ->select(
                'pedido_detalles.product_type',
                'pedido_detalles.nombre_producto',
                DB::raw('SUM(pedido_detalles.cantidad) as total_vendido'),
                DB::raw('SUM(pedido_detalles.subtotal) as ingresos'),
                DB::raw('AVG(pedido_detalles.precio_unitario) as precio_promedio')
            )
            ->groupBy('pedido_detalles.product_type', 'pedido_detalles.nombre_producto')
            ->orderBy('total_vendido', 'desc')
            ->limit(15)
            ->get();

        // 5. MÉTRICAS GENERALES
        $totalPedidos = $pedidos->count();
        $totalIngresos = $pedidos->sum('total');
        $ticketPromedio = $totalPedidos > 0 ? round($totalIngresos / $totalPedidos, 2) : 0;

        // Tasa de conversión: pedidos entregados vs total de pedidos (usar TODOS los pedidos del período, sin filtro de estado)
        $pedidosTotalesQuery = Pedido::whereBetween('created_at', [$desde, $hasta]);
        if ($vendedor_id) {
            $pedidosTotalesQuery->where('user_id', $vendedor_id);
        }
        $pedidosTotales = $pedidosTotalesQuery->get();
        $totalPedidosParaConversion = $pedidosTotales->count();
        $pedidosEntregados = $pedidosTotales->where('estado', 'entregado')->count();
        $tasaConversion = $totalPedidosParaConversion > 0 ? round(($pedidosEntregados / $totalPedidosParaConversion) * 100, 2) : 0;

        // Distribución por estado
        $distribucionEstado = $pedidos->groupBy('estado')->map(function ($grupo) {
            return $grupo->count();
        });

        // Lista de vendedores para el filtro (vendedores que tienen productos vendidos)
        $vendedoresIds = collect();
        
        // Obtener IDs de vendedores desde ganados vendidos
        $ganadosVendidos = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
            ->where('pedido_detalles.product_type', 'ganado')
            ->whereBetween('pedidos.created_at', [$desde, $hasta])
            ->pluck('pedido_detalles.product_id')
            ->unique();
        $vendedoresGanado = \App\Models\Ganado::whereIn('id', $ganadosVendidos)->pluck('user_id')->unique();
        
        // Obtener IDs de vendedores desde maquinarias vendidas
        $maquinariasVendidas = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
            ->where('pedido_detalles.product_type', 'maquinaria')
            ->whereBetween('pedidos.created_at', [$desde, $hasta])
            ->pluck('pedido_detalles.product_id')
            ->unique();
        $vendedoresMaquinaria = \App\Models\Maquinaria::whereIn('id', $maquinariasVendidas)->pluck('user_id')->unique();
        
        // Obtener IDs de vendedores desde orgánicos vendidos
        $organicosVendidos = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
            ->where('pedido_detalles.product_type', 'organico')
            ->whereBetween('pedidos.created_at', [$desde, $hasta])
            ->pluck('pedido_detalles.product_id')
            ->unique();
        $vendedoresOrganico = \App\Models\Organico::whereIn('id', $organicosVendidos)->pluck('user_id')->unique();
        
        $vendedoresIds = $vendedoresIds->merge($vendedoresGanado)
            ->merge($vendedoresMaquinaria)
            ->merge($vendedoresOrganico)
            ->unique();
        
        $vendedores = User::whereIn('id', $vendedoresIds)->get(['id', 'name', 'email']);

        return view('admin.reportes.ventas', compact(
            'ventasPorCategoria',
            'labelsMeses',
            'ventasGanado',
            'ventasMaquinaria',
            'ventasOrganico',
            'topVendedores',
            'productosMasVendidos',
            'totalPedidos',
            'totalIngresos',
            'ticketPromedio',
            'tasaConversion',
            'distribucionEstado',
            'vendedores',
            'desde',
            'hasta',
            'categoria',
            'estado',
            'vendedor_id'
        ));
    }

    /**
     * Exportar reporte de ventas a Excel
     */
    public function exportarVentasExcel(Request $request)
    {
        // Usar los mismos filtros que el método ventas()
        $desde = $request->desde ? Carbon::parse($request->desde) : Carbon::now()->subMonths(6);
        $hasta = $request->hasta ? Carbon::parse($request->hasta) : Carbon::now();
        $categoria = $request->categoria;
        $estado = $request->estado;
        $vendedor_id = $request->vendedor_id;

        // Obtener datos de ventas por categoría (misma lógica que ventas())
        $ventasPorCategoria = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
            ->whereBetween('pedidos.created_at', [$desde, $hasta])
            ->when($estado, function ($q) use ($estado) {
                return $q->where('pedidos.estado', $estado);
            })
            ->when($vendedor_id, function ($q) use ($vendedor_id) {
                return $q->where('pedidos.user_id', $vendedor_id);
            })
            ->when($categoria, function ($q) use ($categoria) {
                return $q->where('pedido_detalles.product_type', $categoria);
            })
            ->select(
                'pedido_detalles.product_type as categoria',
                DB::raw('COUNT(DISTINCT pedidos.id) as total_pedidos'),
                DB::raw('SUM(pedido_detalles.cantidad) as total_cantidad'),
                DB::raw('SUM(pedido_detalles.subtotal) as ingresos_totales'),
                DB::raw('AVG(pedido_detalles.precio_unitario) as precio_promedio')
            )
            ->groupBy('pedido_detalles.product_type')
            ->get();

        $export = new VentasExport($ventasPorCategoria);
        return $export->export();
    }

    /**
     * Reporte de Rendimiento de Vendedores
     */
    public function vendedores(Request $request)
    {
        // Filtros
        $desde = $request->desde ? Carbon::parse($request->desde) : Carbon::now()->subMonths(6);
        $hasta = $request->hasta ? Carbon::parse($request->hasta) : Carbon::now();
        $vendedor_id = $request->vendedor_id;

        // 1. RENDIMIENTO GENERAL DE VENDEDORES
        $vendedoresQuery = User::whereHas('ganados')
            ->orWhereHas('maquinarias')
            ->orWhereHas('organicos');

        if ($vendedor_id) {
            $vendedoresQuery->where('id', $vendedor_id);
        }

        $vendedores = $vendedoresQuery->get();

        $rendimientoVendedores = [];

        foreach ($vendedores as $vendedor) {
            // Productos publicados
            $totalGanados = $vendedor->ganados()->count();
            $totalMaquinarias = $vendedor->maquinarias()->count();
            $totalOrganicos = $vendedor->organicos()->count();
            $totalProductos = $totalGanados + $totalMaquinarias + $totalOrganicos;

            // Ventas (productos vendidos por este vendedor)
            $ventasGanado = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
                ->join('ganados', 'pedido_detalles.product_id', '=', 'ganados.id')
                ->where('pedido_detalles.product_type', 'ganado')
                ->where('ganados.user_id', $vendedor->id)
                ->whereBetween('pedidos.created_at', [$desde, $hasta])
                ->sum('pedido_detalles.subtotal');

            $ventasMaquinaria = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
                ->join('maquinarias', 'pedido_detalles.product_id', '=', 'maquinarias.id')
                ->where('pedido_detalles.product_type', 'maquinaria')
                ->where('maquinarias.user_id', $vendedor->id)
                ->whereBetween('pedidos.created_at', [$desde, $hasta])
                ->sum('pedido_detalles.subtotal');

            $ventasOrganico = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
                ->join('organicos', 'pedido_detalles.product_id', '=', 'organicos.id')
                ->where('pedido_detalles.product_type', 'organico')
                ->where('organicos.user_id', $vendedor->id)
                ->whereBetween('pedidos.created_at', [$desde, $hasta])
                ->sum('pedido_detalles.subtotal');

            $totalVentas = $ventasGanado + $ventasMaquinaria + $ventasOrganico;

            // Tasa de conversión
            $tasaConversion = $totalProductos > 0 
                ? round((($totalGanados > 0 && $ventasGanado > 0 ? 1 : 0) + 
                         ($totalMaquinarias > 0 && $ventasMaquinaria > 0 ? 1 : 0) + 
                         ($totalOrganicos > 0 && $ventasOrganico > 0 ? 1 : 0)) / 3 * 100, 2)
                : 0;

            // Precio promedio de productos
            $preciosGanado = $vendedor->ganados()->avg('precio') ?? 0;
            $preciosMaquinaria = $vendedor->maquinarias()->avg('precio_dia') ?? 0;
            $preciosOrganico = $vendedor->organicos()->avg('precio') ?? 0;
            $precioPromedio = ($preciosGanado + $preciosMaquinaria + $preciosOrganico) / 3;

            $rendimientoVendedores[] = [
                'id' => $vendedor->id,
                'nombre' => $vendedor->name,
                'email' => $vendedor->email,
                'total_productos' => $totalProductos,
                'total_ganados' => $totalGanados,
                'total_maquinarias' => $totalMaquinarias,
                'total_organicos' => $totalOrganicos,
                'total_ventas' => $totalVentas,
                'ventas_ganado' => $ventasGanado,
                'ventas_maquinaria' => $ventasMaquinaria,
                'ventas_organico' => $ventasOrganico,
                'tasa_conversion' => $tasaConversion,
                'precio_promedio' => round($precioPromedio, 2),
            ];
        }

        // Ordenar por total de ventas
        usort($rendimientoVendedores, function($a, $b) {
            return $b['total_ventas'] <=> $a['total_ventas'];
        });

        // 2. COMPARATIVA ENTRE VENDEDORES
        $promedioVentas = count($rendimientoVendedores) > 0 
            ? array_sum(array_column($rendimientoVendedores, 'total_ventas')) / count($rendimientoVendedores)
            : 0;

        $topVendedores = array_slice($rendimientoVendedores, 0, 5);
        $restoVendedores = array_slice($rendimientoVendedores, 5);

        return view('admin.reportes.vendedores', compact(
            'rendimientoVendedores',
            'topVendedores',
            'restoVendedores',
            'promedioVentas',
            'vendedores',
            'desde',
            'hasta',
            'vendedor_id'
        ));
    }

    /**
     * Exportar reporte de vendedores a Excel
     */
    public function exportarVendedoresExcel(Request $request)
    {
        // Usar los mismos filtros que el método vendedores()
        $desde = $request->desde ? Carbon::parse($request->desde) : Carbon::now()->subMonths(6);
        $hasta = $request->hasta ? Carbon::parse($request->hasta) : Carbon::now();
        $vendedor_id = $request->vendedor_id;

        // Obtener datos de rendimiento (misma lógica que vendedores())
        $vendedoresQuery = User::whereHas('ganados')
            ->orWhereHas('maquinarias')
            ->orWhereHas('organicos');

        if ($vendedor_id) {
            $vendedoresQuery->where('id', $vendedor_id);
        }

        $vendedores = $vendedoresQuery->get();
        $rendimientoVendedores = [];

        foreach ($vendedores as $vendedor) {
            $totalGanados = $vendedor->ganados()->count();
            $totalMaquinarias = $vendedor->maquinarias()->count();
            $totalOrganicos = $vendedor->organicos()->count();
            $totalProductos = $totalGanados + $totalMaquinarias + $totalOrganicos;

            $ventasGanado = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
                ->join('ganados', 'pedido_detalles.product_id', '=', 'ganados.id')
                ->where('pedido_detalles.product_type', 'ganado')
                ->where('ganados.user_id', $vendedor->id)
                ->whereBetween('pedidos.created_at', [$desde, $hasta])
                ->sum('pedido_detalles.subtotal');

            $ventasMaquinaria = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
                ->join('maquinarias', 'pedido_detalles.product_id', '=', 'maquinarias.id')
                ->where('pedido_detalles.product_type', 'maquinaria')
                ->where('maquinarias.user_id', $vendedor->id)
                ->whereBetween('pedidos.created_at', [$desde, $hasta])
                ->sum('pedido_detalles.subtotal');

            $ventasOrganico = PedidoDetalle::join('pedidos', 'pedido_detalles.pedido_id', '=', 'pedidos.id')
                ->join('organicos', 'pedido_detalles.product_id', '=', 'organicos.id')
                ->where('pedido_detalles.product_type', 'organico')
                ->where('organicos.user_id', $vendedor->id)
                ->whereBetween('pedidos.created_at', [$desde, $hasta])
                ->sum('pedido_detalles.subtotal');

            $totalVentas = $ventasGanado + $ventasMaquinaria + $ventasOrganico;

            $rendimientoVendedores[] = [
                'nombre' => $vendedor->name,
                'email' => $vendedor->email,
                'total_productos' => $totalProductos,
                'total_ganados' => $totalGanados,
                'total_maquinarias' => $totalMaquinarias,
                'total_organicos' => $totalOrganicos,
                'total_ventas' => $totalVentas,
            ];
        }

        // Ordenar por total de ventas
        usort($rendimientoVendedores, function($a, $b) {
            return $b['total_ventas'] <=> $a['total_ventas'];
        });

        $export = new VendedoresExport($rendimientoVendedores);
        return $export->export();
    }
}

