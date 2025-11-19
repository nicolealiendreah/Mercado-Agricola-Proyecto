<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maquinaria extends Model
{
    protected $fillable = [
    'nombre',
    'user_id',
    'tipo_maquinaria_id',
    'marca_maquinaria_id',
    'modelo',
    'precio_dia',
    'estado',
    'descripcion',
    'categoria_id', 
];

    /**
     * Relación: una maquinaria pertenece a una categoría
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Relación: una maquinaria pertenece a un tipo de maquinaria
     */
    public function tipoMaquinaria()
    {
        return $this->belongsTo(TipoMaquinaria::class, 'tipo_maquinaria_id');
    }

    /**
     * Relación: una maquinaria pertenece a una marca de maquinaria
     */
    public function marcaMaquinaria()
    {
        return $this->belongsTo(MarcaMaquinaria::class, 'marca_maquinaria_id');
    }

    /**
     * Relación: una maquinaria pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

