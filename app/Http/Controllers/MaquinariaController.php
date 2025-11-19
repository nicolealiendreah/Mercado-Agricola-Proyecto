<?php

namespace App\Http\Controllers;

use App\Models\Maquinaria;
use App\Http\Requests\StoreMaquinariaRequest;
use App\Http\Requests\UpdateMaquinariaRequest;

class MaquinariaController extends Controller
{
    public function index()
    {
        $q = request('q');
        $maquinarias = Maquinaria::with(['tipoMaquinaria', 'marcaMaquinaria', 'categoria', 'user'])
            ->when($q, fn($qb) =>
                $qb->where('nombre','ilike',"%$q%")
                   ->orWhereHas('tipoMaquinaria', function($query) use ($q) {
                       $query->where('nombre', 'ilike', "%$q%");
                   })
                   ->orWhereHas('marcaMaquinaria', function($query) use ($q) {
                       $query->where('nombre', 'ilike', "%$q%");
                   }))
            ->orderBy('id','desc')
            ->paginate(10)
            ->withQueryString();

        return view('maquinarias.index', compact('maquinarias','q'));
    }

    public function create()
    {
        $categorias = \App\Models\Categoria::orderBy('nombre')->get();
        $tipo_maquinarias = \App\Models\TipoMaquinaria::orderBy('nombre')->get();
        $marcas_maquinarias = \App\Models\MarcaMaquinaria::orderBy('nombre')->get();
        return view('maquinarias.create', compact('categorias', 'tipo_maquinarias', 'marcas_maquinarias'));
    }

    public function store(StoreMaquinariaRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        Maquinaria::create($data);
        return redirect()->route('maquinarias.index')->with('ok','Maquinaria creada');
    }

    public function show(Maquinaria $maquinaria)
    {
        $maquinaria->load(['tipoMaquinaria', 'marcaMaquinaria', 'categoria', 'user']);
        return view('maquinarias.show', compact('maquinaria'));
    }

    public function edit(Maquinaria $maquinaria)
    {
        // Verificar permisos: solo el dueño o admin puede editar
        if (!auth()->user()->isAdmin() && $maquinaria->user_id !== auth()->id()) {
            return redirect()->route('maquinarias.index')
                ->with('error', 'No tienes permisos para editar este anuncio.');
        }

        $categorias = \App\Models\Categoria::orderBy('nombre')->get();
        $tipo_maquinarias = \App\Models\TipoMaquinaria::orderBy('nombre')->get();
        $marcas_maquinarias = \App\Models\MarcaMaquinaria::orderBy('nombre')->get();
        return view('maquinarias.edit', compact('maquinaria', 'categorias', 'tipo_maquinarias', 'marcas_maquinarias'));
    }


    public function update(UpdateMaquinariaRequest $request, Maquinaria $maquinaria)
    {
        // Verificar permisos: solo el dueño o admin puede actualizar
        if (!auth()->user()->isAdmin() && $maquinaria->user_id !== auth()->id()) {
            return redirect()->route('maquinarias.index')
                ->with('error', 'No tienes permisos para editar este anuncio.');
        }

        $maquinaria->update($request->validated());
        return redirect()->route('maquinarias.index')->with('ok','Maquinaria actualizada');
    }

    public function destroy(Maquinaria $maquinaria)
    {
        // Verificar permisos: solo el dueño o admin puede eliminar
        if (!auth()->user()->isAdmin() && $maquinaria->user_id !== auth()->id()) {
            return redirect()->route('maquinarias.index')
                ->with('error', 'No tienes permisos para eliminar este anuncio.');
        }

        $maquinaria->delete();
        return redirect()->route('maquinarias.index')->with('ok','Maquinaria eliminada');
    }
}
