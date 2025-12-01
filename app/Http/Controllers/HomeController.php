<?php

namespace App\Http\Controllers;

use App\Models\Ganado;
use App\Models\Maquinaria;
use App\Models\Organico;
use App\Models\Categoria;
use App\Models\TipoAnimal;
use App\Models\Raza;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Mostrar página de inicio con búsqueda y filtros
     */
    public function index(Request $request)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $tiposAnimales = TipoAnimal::orderBy('nombre')->get();
        $razas = Raza::orderBy('nombre')->get();
        
        // Parámetros de búsqueda
        $q = $request->get('q', '');
        $categoria_id = $request->get('categoria_id', '');
        $tipo_animal_id = $request->get('tipo_animal_id', '');
        $raza_id = $request->get('raza_id', '');
        $tipo = $request->get('tipo', ''); // ganados, maquinarias, organicos
        
        // Inicializar resultados
        $ganados = collect();
        $maquinarias = collect();
        $organicos = collect();
        
        // Si hay búsqueda o filtros, buscar (siempre mostrar todos los tipos)
        if ($q || $categoria_id || $tipo_animal_id || $raza_id) {
            // Búsqueda en Ganados (siempre mostrar)
            $ganadosQuery = Ganado::with(['categoria', 'tipoAnimal', 'raza', 'datoSanitario'])
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
            
            if ($tipo_animal_id) {
                $ganadosQuery->where('tipo_animal_id', $tipo_animal_id);
            }
            
            if ($raza_id) {
                $ganadosQuery->where('raza_id', $raza_id);
            }
            
            $ganados = $ganadosQuery->orderBy('created_at', 'desc')->paginate(12);
            
            // Búsqueda en Maquinarias (siempre mostrar)
            $maquinariasQuery = Maquinaria::with(['categoria', 'tipoMaquinaria', 'marcaMaquinaria', 'imagenes'])
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
            $organicosQuery = Organico::with(['categoria', 'imagenes', 'unidad'])
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
            // Sin búsqueda: mostrar productos destacados/recientes (últimos 3 de cada tipo)
            $ganados = Ganado::with(['categoria', 'tipoAnimal', 'raza', 'datoSanitario'])
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
            
            $maquinarias = Maquinaria::with(['categoria', 'tipoMaquinaria', 'marcaMaquinaria', 'imagenes'])
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
            
            $organicos = Organico::with(['categoria', 'imagenes', 'unidad'])
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
        }
        
        return view('public.home', compact(
            'categorias',
            'tiposAnimales',
            'razas',
            'ganados',
            'maquinarias',
            'organicos',
            'q',
            'categoria_id',
            'tipo_animal_id',
            'raza_id',
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
        $ganadosQuery = Ganado::with(['categoria', 'tipoAnimal', 'raza', 'datoSanitario'])
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
        $maquinariasQuery = Maquinaria::with(['categoria', 'tipoMaquinaria', 'marcaMaquinaria', 'imagenes'])
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
        $organicosQuery = Organico::with(['categoria', 'imagenes', 'unidad'])
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
            $misGanados = Ganado::with(['categoria', 'tipoAnimal', 'raza', 'datoSanitario'])
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
            
            $misMaquinarias = Maquinaria::with(['categoria', 'tipoMaquinaria', 'marcaMaquinaria', 'imagenes'])
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
            
            $misOrganicos = Organico::with(['categoria', 'imagenes', 'unidad'])
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
