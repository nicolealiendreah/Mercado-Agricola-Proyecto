<?php

namespace App\Http\Controllers;

use App\Models\Ganado;
use App\Models\Maquinaria;
use App\Models\Organico;
use App\Models\Categoria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Mostrar página de inicio con búsqueda y filtros
     */
    public function index(Request $request)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        
        // Parámetros de búsqueda
        $q = $request->get('q', '');
        $categoria_id = $request->get('categoria_id', '');
        $tipo = $request->get('tipo', ''); // ganados, maquinarias, organicos
        
        // Inicializar resultados
        $ganados = collect();
        $maquinarias = collect();
        $organicos = collect();
        
        // Si hay búsqueda o filtros, buscar (siempre mostrar todos los tipos)
        if ($q || $categoria_id) {
            // Búsqueda en Ganados (siempre mostrar)
            $ganadosQuery = Ganado::with(['categoria', 'tipoAnimal', 'raza'])
                ->where(function($query) use ($q) {
                    if ($q) {
                        $query->where('nombre', 'ilike', "%{$q}%")
                              ->orWhere('descripcion', 'ilike', "%{$q}%")
                              ->orWhere('ubicacion', 'ilike', "%{$q}%");
                    }
                });
            
            if ($categoria_id) {
                $ganadosQuery->where('categoria_id', $categoria_id);
            }
            
            $ganados = $ganadosQuery->orderBy('created_at', 'desc')->paginate(12);
            
            // Búsqueda en Maquinarias (siempre mostrar)
            $maquinariasQuery = Maquinaria::with(['categoria', 'tipoMaquinaria', 'marcaMaquinaria'])
                ->where(function($query) use ($q) {
                    if ($q) {
                        $query->where('nombre', 'ilike', "%{$q}%")
                              ->orWhere('descripcion', 'ilike', "%{$q}%")
                              ->orWhereHas('tipoMaquinaria', function($subQuery) use ($q) {
                                  $subQuery->where('nombre', 'ilike', "%{$q}%");
                              })
                              ->orWhereHas('marcaMaquinaria', function($subQuery) use ($q) {
                                  $subQuery->where('nombre', 'ilike', "%{$q}%");
                              });
                    }
                });
            
            if ($categoria_id) {
                $maquinariasQuery->where('categoria_id', $categoria_id);
            }
            
            $maquinarias = $maquinariasQuery->orderBy('created_at', 'desc')->paginate(12);
            
            // Búsqueda en Orgánicos (siempre mostrar)
            $organicosQuery = Organico::with('categoria')
                ->where(function($query) use ($q) {
                    if ($q) {
                        $query->where('nombre', 'ilike', "%{$q}%")
                              ->orWhere('descripcion', 'ilike', "%{$q}%");
                    }
                });
            
            if ($categoria_id) {
                $organicosQuery->where('categoria_id', $categoria_id);
            }
            
            $organicos = $organicosQuery->orderBy('created_at', 'desc')->paginate(12);
        } else {
            // Sin búsqueda: mostrar productos destacados/recientes (últimos 6 de cada tipo)
            $ganados = Ganado::with(['categoria', 'tipoAnimal', 'raza'])
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
            
            $maquinarias = Maquinaria::with(['categoria', 'tipoMaquinaria', 'marcaMaquinaria'])
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
            
            $organicos = Organico::with('categoria')
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
        }
        
        return view('public.home', compact(
            'categorias',
            'ganados',
            'maquinarias',
            'organicos',
            'q',
            'categoria_id',
            'tipo'
        ));
    }

    /**
     * Mostrar página de anuncios con búsqueda y filtros
     */
    public function anuncios(Request $request)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        
        // Parámetros de búsqueda
        $q = $request->get('q', '');
        $categoria_id = $request->get('categoria_id', '');
        $tipo = $request->get('tipo', ''); // ganados, maquinarias, organicos
        
        // Inicializar resultados con paginación
        $ganados = collect();
        $maquinarias = collect();
        $organicos = collect();
        
        // Búsqueda en Ganados (siempre mostrar, sin filtro de tipo)
        $ganadosQuery = Ganado::with(['categoria', 'tipoAnimal', 'raza'])
            ->where(function($query) use ($q) {
                if ($q) {
                    $query->where('nombre', 'ilike', "%{$q}%")
                          ->orWhere('descripcion', 'ilike', "%{$q}%")
                          ->orWhere('ubicacion', 'ilike', "%{$q}%");
                }
            });
        
        if ($categoria_id) {
            $ganadosQuery->where('categoria_id', $categoria_id);
        }
        
        $ganados = $ganadosQuery->orderBy('created_at', 'desc')->paginate(12, ['*'], 'ganados_page');
        
        // Búsqueda en Maquinarias (siempre mostrar, sin filtro de tipo)
        $maquinariasQuery = Maquinaria::with(['categoria', 'tipoMaquinaria', 'marcaMaquinaria'])
            ->where(function($query) use ($q) {
                if ($q) {
                    $query->where('nombre', 'ilike', "%{$q}%")
                          ->orWhere('descripcion', 'ilike', "%{$q}%")
                          ->orWhereHas('tipoMaquinaria', function($subQuery) use ($q) {
                              $subQuery->where('nombre', 'ilike', "%{$q}%");
                          })
                          ->orWhereHas('marcaMaquinaria', function($subQuery) use ($q) {
                              $subQuery->where('nombre', 'ilike', "%{$q}%");
                          });
                }
            });
        
        if ($categoria_id) {
            $maquinariasQuery->where('categoria_id', $categoria_id);
        }
        
        $maquinarias = $maquinariasQuery->orderBy('created_at', 'desc')->paginate(12, ['*'], 'maquinarias_page');
        
        // Búsqueda en Orgánicos (siempre mostrar, sin filtro de tipo)
        $organicosQuery = Organico::with('categoria')
            ->where(function($query) use ($q) {
                if ($q) {
                    $query->where('nombre', 'ilike', "%{$q}%")
                          ->orWhere('descripcion', 'ilike', "%{$q}%");
                }
            });
        
        if ($categoria_id) {
            $organicosQuery->where('categoria_id', $categoria_id);
        }
        
        $organicos = $organicosQuery->orderBy('created_at', 'desc')->paginate(12, ['*'], 'organicos_page');
        
        // Obtener publicaciones del vendedor autenticado (si está logueado)
        $misGanados = collect();
        $misMaquinarias = collect();
        $misOrganicos = collect();
        
        if (auth()->check() && (auth()->user()->isVendedor() || auth()->user()->isAdmin())) {
            $misGanados = Ganado::with(['categoria', 'tipoAnimal', 'raza'])
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
            
            $misMaquinarias = Maquinaria::with(['categoria', 'tipoMaquinaria', 'marcaMaquinaria'])
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
            
            $misOrganicos = Organico::with('categoria')
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('public.ads.index', compact(
            'categorias',
            'ganados',
            'maquinarias',
            'organicos',
            'misGanados',
            'misMaquinarias',
            'misOrganicos',
            'q',
            'categoria_id',
            'tipo'
        ));
    }
}
