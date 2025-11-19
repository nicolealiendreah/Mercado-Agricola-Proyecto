<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaquinariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_maquinaria_id' => 'required|exists:tipo_maquinarias,id',
            'marca_maquinaria_id' => 'required|exists:marcas_maquinarias,id',
            'modelo' => 'nullable|string|max:255',
            'precio_dia' => 'required|numeric|min:0',
            'estado' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:5000',
        ];
    }

    public function messages(): array
    {
        return [
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists'   => 'La categoría seleccionada no es válida.',
            'tipo_maquinaria_id.required' => 'El tipo de maquinaria es obligatorio.',
            'tipo_maquinaria_id.exists'   => 'El tipo de maquinaria seleccionado no es válido.',
            'marca_maquinaria_id.required' => 'La marca de maquinaria es obligatoria.',
            'marca_maquinaria_id.exists'   => 'La marca de maquinaria seleccionada no es válida.',
        ];
    }
}
