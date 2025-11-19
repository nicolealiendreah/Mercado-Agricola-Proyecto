<?php

namespace App\Http\Controllers;

use App\Models\Ganado;
use App\Models\Categoria;
use App\Models\TipoAnimal;
use App\Models\TipoPeso;
use App\Models\Raza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GanadoController extends Controller
{
    /**
     * Muestra la lista de ganado.
     */
    public function index()
    {
        $ganados = Ganado::with(['categoria','raza','tipoAnimal','tipoPeso'])
                        ->orderBy('id', 'desc')
                        ->paginate(10);

        return view('ganados.index', compact('ganados'));
    }

    /**
     * Muestra el detalle de un ganado.
     */
    public function show(Ganado $ganado)
    {
        $ganado->load(['categoria', 'tipoAnimal', 'tipoPeso', 'raza', 'datoSanitario']);
        return view('ganados.show', compact('ganado'));
    }

    /**
     * Muestra el formulario de creación.
     */
   public function create()
{
    $tipo_animals = TipoAnimal::orderBy('nombre')->get();
    $categorias   = Categoria::orderBy('nombre')->get();
    $tipoPesos    = TipoPeso::orderBy('nombre')->get();
    $razas        = Raza::orderBy('nombre')->get();
    $datosSanitarios = \App\Models\DatoSanitario::orderBy('id')->get();

    return view('ganados.create', compact(
        'tipo_animals',
        'categorias',
        'tipoPesos',
        'razas',
        'datosSanitarios'
    ));
}


    /**
     * Guarda un nuevo registro.
     */
    public function store(Request $request)
{
    $request->validate([
        'nombre'          => 'required|string|max:255',
        'tipo_animal_id'  => 'required|exists:tipo_animals,id',
        'raza_id'         => 'nullable|exists:razas,id',
        'edad_anos'       => 'required|integer|min:0|max:25',
        'edad_meses'      => 'required|integer|min:0|max:11',
        'tipo_peso_id'    => 'required|exists:tipo_pesos,id',
        'sexo'            => 'nullable|string',
        'descripcion'     => 'nullable|string',
        'precio'          => 'nullable|numeric|min:0',
        'stock'            => 'required|integer|min:0',
        'imagen'          => 'nullable|image|max:2048',
        'categoria_id'    => 'required|exists:categorias,id',
        'fecha_publicacion' => 'nullable|date',
        'ubicacion' => 'nullable|string|max:255',
        'latitud' => 'nullable|numeric',
        'longitud' => 'nullable|numeric',
    ]);

    $data = [
        'nombre' => $request->nombre,
        'tipo_animal_id' => $request->tipo_animal_id,
        'raza_id' => $request->raza_id,
        'edad' => ($request->edad_anos * 12) + $request->edad_meses,
        'tipo_peso_id' => $request->tipo_peso_id,
        'sexo' => $request->sexo,
        'descripcion' => $request->descripcion,
        'precio' => $request->precio,
        'stock' => $request->stock,
        'categoria_id' => $request->categoria_id,
        'fecha_publicacion' => $request->fecha_publicacion,
        'ubicacion' => $request->ubicacion,
        'latitud' => $request->latitud,
        'longitud' => $request->longitud,
    ];

    if ($request->hasFile('imagen')) {
        $data['imagen'] = $request->file('imagen')->store('ganados', 'public');
    }

    // Asignar el usuario autenticado
    $data['user_id'] = auth()->id();

    Ganado::create($data);

    return redirect()->route('ganados.index')
        ->with('success', 'Ganado registrado correctamente.');
}


    /**
     * Muestra el formulario de edición.
     */
    public function edit(Ganado $ganado)
{
    // Verificar permisos: solo el dueño o admin puede editar
    if (!auth()->user()->isAdmin() && $ganado->user_id !== auth()->id()) {
        return redirect()->route('ganados.index')
            ->with('error', 'No tienes permisos para editar este anuncio.');
    }

    $tipo_animals = TipoAnimal::orderBy('nombre')->get();
    $categorias   = Categoria::orderBy('nombre')->get();
    $tipoPesos    = TipoPeso::orderBy('nombre')->get();
    $razas        = Raza::where('tipo_animal_id', $ganado->tipo_animal_id)->get();
    $datosSanitarios = \App\Models\DatoSanitario::orderBy('id')->get();

    return view('ganados.edit', compact(
        'ganado',
        'tipo_animals',
        'categorias',
        'tipoPesos',
        'razas',
        'datosSanitarios'
    ));
}


    /**
     * Actualiza un registro existente.
     */
 public function update(Request $request, Ganado $ganado)
{
    // Verificar permisos: solo el dueño o admin puede actualizar
    if (!auth()->user()->isAdmin() && $ganado->user_id !== auth()->id()) {
        return redirect()->route('ganados.index')
            ->with('error', 'No tienes permisos para editar este anuncio.');
    }

    $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo_animal_id' => 'required|exists:tipo_animals,id',
        'raza_id' => 'nullable|exists:razas,id',
        'edad_anos' => 'required|integer|min:0|max:25',
        'edad_meses' => 'required|integer|min:0|max:11',
        'sexo' => 'nullable|string',
        'descripcion' => 'nullable|string',
        'precio' => 'nullable|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'tipo_peso_id' => 'required|exists:tipo_pesos,id',
        'imagen' => 'nullable|image|max:2048',
        'categoria_id' => 'required|exists:categorias,id',
        'ubicacion' => 'nullable|string|max:255',
        'latitud' => 'nullable|numeric',
        'longitud' => 'nullable|numeric',
        'fecha_publicacion' => 'nullable|date',
        // ❌ ESTA LÍNEA DEBE ELIMINARSE:
        // 'dato_sanitario_id' => 'nullable|exists:datos_sanitarios,id',
    ]);

    // Construimos el array SIN dato_sanitario_id
    $data = [
        'nombre' => $request->nombre,
        'tipo_animal_id' => $request->tipo_animal_id,
        'raza_id' => $request->raza_id,
        'edad' => ($request->edad_anos * 12) + $request->edad_meses,
        'tipo_peso_id' => $request->tipo_peso_id,
        'sexo' => $request->sexo,
        'descripcion' => $request->descripcion,
        'precio' => $request->precio,
        'stock' => $request->stock,
        'categoria_id' => $request->categoria_id,
        'ubicacion' => $request->ubicacion,
        'latitud' => $request->latitud,
        'longitud' => $request->longitud,
        'fecha_publicacion' => $request->fecha_publicacion,
    ];

    // Imagen
    if ($request->hasFile('imagen')) {

        if ($ganado->imagen && Storage::disk('public')->exists($ganado->imagen)) {
            Storage::disk('public')->delete($ganado->imagen);
        }

        $data['imagen'] = $request->file('imagen')->store('ganados', 'public');
    }

    $ganado->update($data);

    return redirect()->route('ganados.index')
        ->with('success', 'Registro actualizado correctamente.');
}


    /**
     * Elimina un registro.
     */
    public function destroy(Ganado $ganado)
    {
        // Verificar permisos: solo el dueño o admin puede eliminar
        if (!auth()->user()->isAdmin() && $ganado->user_id !== auth()->id()) {
            return redirect()->route('ganados.index')
                ->with('error', 'No tienes permisos para eliminar este anuncio.');
        }

        if ($ganado->imagen && Storage::disk('public')->exists($ganado->imagen)) {
            Storage::disk('public')->delete($ganado->imagen);
        }

        $ganado->delete();
        return redirect()->route('ganados.index')
            ->with('success', 'Ganado eliminado correctamente.');
    }
}
