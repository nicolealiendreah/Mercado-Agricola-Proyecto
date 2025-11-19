<?php

namespace App\Http\Controllers;

use App\Models\Organico;
use App\Models\Categoria; // 👈 Agregamos el modelo de Categoría
use App\Http\Requests\StoreOrganicoRequest;
use App\Http\Requests\UpdateOrganicoRequest;

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
    return view('organicos.create', compact('categorias'));
}



    public function store(StoreOrganicoRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        Organico::create($data);
        return redirect()->route('organicos.index')->with('ok', 'Orgánico creado');
    }

    public function show(Organico $organico)
    {
        return view('organicos.show', compact('organico'));
    }

    public function edit(\App\Models\Organico $organico)
{
    // Verificar permisos: solo el dueño o admin puede editar
    if (!auth()->user()->isAdmin() && $organico->user_id !== auth()->id()) {
        return redirect()->route('organicos.index')
            ->with('error', 'No tienes permisos para editar este anuncio.');
    }

    $categorias = \App\Models\Categoria::orderBy('nombre')->get();
    return view('organicos.edit', compact('organico', 'categorias'));
}


    public function update(UpdateOrganicoRequest $request, Organico $organico)
    {
        // Verificar permisos: solo el dueño o admin puede actualizar
        if (!auth()->user()->isAdmin() && $organico->user_id !== auth()->id()) {
            return redirect()->route('organicos.index')
                ->with('error', 'No tienes permisos para editar este anuncio.');
        }

        $organico->update($request->validated());
        return redirect()->route('organicos.index')->with('ok', 'Orgánico actualizado');
    }

    public function destroy(Organico $organico)
    {
        // Verificar permisos: solo el dueño o admin puede eliminar
        if (!auth()->user()->isAdmin() && $organico->user_id !== auth()->id()) {
            return redirect()->route('organicos.index')
                ->with('error', 'No tienes permisos para eliminar este anuncio.');
        }

        $organico->delete();
        return redirect()->route('organicos.index')->with('ok', 'Orgánico eliminado');
    }
}
