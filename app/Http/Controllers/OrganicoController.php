<?php

namespace App\Http\Controllers;

use App\Models\Organico;
use App\Models\OrganicoImagen;
use App\Models\Categoria; // 👈 Agregamos el modelo de Categoría
use App\Http\Requests\StoreOrganicoRequest;
use App\Http\Requests\UpdateOrganicoRequest;
use Illuminate\Support\Facades\Storage;

class OrganicoController extends Controller
{
    public function index()
    {
        $q = request('q');
        $organicos = Organico::when($q, fn($qb) =>
                $qb->where('nombre', 'ilike', "%$q%")
                   ->orWhereHas('categoria', fn($q2) => $q2->where('nombre', 'ilike', "%$q%"))
            )
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('organicos.index', compact('organicos', 'q'));
    }

public function create()
{
    $categorias = \App\Models\Categoria::orderBy('nombre')->get();
    $unidades = \App\Models\UnidadOrganico::orderBy('nombre')->get();
    return view('organicos.create', compact('categorias', 'unidades'));
}



    public function store(StoreOrganicoRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        
        // Crear el orgánico
        $organico = Organico::create($data);
        
        // Guardar las imágenes si existen (máximo 4)
        if ($request->hasFile('imagenes')) {
            $orden = 0;
            $imagenes = array_slice($request->file('imagenes'), 0, 3); // Limitar a 3 imágenes
            foreach ($imagenes as $imagen) {
                if ($imagen && $imagen->isValid()) {
                    $ruta = $imagen->store('organicos', 'public');
                    OrganicoImagen::create([
                        'organico_id' => $organico->id,
                        'ruta' => $ruta,
                        'orden' => $orden++,
                    ]);
                }
            }
        }
        
        return redirect()->route('organicos.index')->with('ok', 'Orgánico creado');
    }

    public function show(Organico $organico)
    {
        $organico->load(['categoria', 'unidad', 'user', 'imagenes']);
        return view('organicos.show', compact('organico'));
    }

    public function edit(\App\Models\Organico $organico)
{
    // Verificar permisos: solo el dueño o admin puede editar
    if (!auth()->user()->isAdmin() && $organico->user_id !== auth()->id()) {
        return redirect()->route('organicos.index')
            ->with('error', 'No tienes permisos para editar este anuncio.');
    }

    $organico->load('imagenes');
    $categorias = \App\Models\Categoria::orderBy('nombre')->get();
    $unidades = \App\Models\UnidadOrganico::orderBy('nombre')->get();
    return view('organicos.edit', compact('organico', 'categorias', 'unidades'));
}


    public function update(UpdateOrganicoRequest $request, Organico $organico)
    {
        // Verificar permisos: solo el dueño o admin puede actualizar
        if (!auth()->user()->isAdmin() && $organico->user_id !== auth()->id()) {
            return redirect()->route('organicos.index')
                ->with('error', 'No tienes permisos para editar este anuncio.');
        }

        $data = $request->validated();
        $organico->update($data);
        
        // Eliminar imágenes marcadas para eliminar
        if ($request->has('imagenes_eliminar')) {
            foreach ($request->imagenes_eliminar as $imagenId) {
                $imagen = OrganicoImagen::find($imagenId);
                if ($imagen && $imagen->organico_id === $organico->id) {
                    if (Storage::disk('public')->exists($imagen->ruta)) {
                        Storage::disk('public')->delete($imagen->ruta);
                    }
                    $imagen->delete();
                }
            }
        }
        
        // Agregar nuevas imágenes
        if ($request->hasFile('imagenes')) {
            $totalImagenesActuales = $organico->imagenes()->count();
            $maxOrden = $organico->imagenes()->max('orden') ?? -1;
            $orden = $maxOrden + 1;
            $espaciosDisponibles = 3 - $totalImagenesActuales;
            
            if ($espaciosDisponibles > 0) {
                $imagenes = array_slice($request->file('imagenes'), 0, $espaciosDisponibles);
                foreach ($imagenes as $imagen) {
                    if ($imagen && $imagen->isValid()) {
                        $ruta = $imagen->store('organicos', 'public');
                        OrganicoImagen::create([
                            'organico_id' => $organico->id,
                            'ruta' => $ruta,
                            'orden' => $orden++,
                        ]);
                    }
                }
            }
        }
        
        return redirect()->route('organicos.index')->with('ok', 'Orgánico actualizado');
    }

    public function destroy(Organico $organico)
    {
        // Verificar permisos: solo el dueño o admin puede eliminar
        if (!auth()->user()->isAdmin() && $organico->user_id !== auth()->id()) {
            return redirect()->route('organicos.index')
                ->with('error', 'No tienes permisos para eliminar este anuncio.');
        }

        // Eliminar las imágenes físicas
        foreach ($organico->imagenes as $imagen) {
            if (Storage::disk('public')->exists($imagen->ruta)) {
                Storage::disk('public')->delete($imagen->ruta);
            }
        }
        
        $organico->delete();
        return redirect()->route('organicos.index')->with('ok', 'Orgánico eliminado');
    }
}
