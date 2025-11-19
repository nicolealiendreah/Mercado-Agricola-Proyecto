<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ganado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'user_id',
        'tipo_animal_id',
        'raza_id',
        'edad',
        'tipo_peso_id',
        'sexo',
        'precio',
        'stock',
        'imagen',
        'descripcion',
        'categoria_id',
        'dato_sanitario_id',
        'fecha_publicacion',
        'ubicacion',
        'latitud',
        'longitud'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tipoAnimal()
    {
        return $this->belongsTo(\App\Models\TipoAnimal::class);
    }

    public function tipoPeso()
    {
        return $this->belongsTo(\App\Models\TipoPeso::class, 'tipo_peso_id');
    }

    public function raza()
    {
        return $this->belongsTo(Raza::class);
    }

    // ✅ RELACIÓN CORRECTA (uno a uno)
    public function datoSanitario()
    {
        return $this->belongsTo(DatoSanitario::class, 'dato_sanitario_id');
    }

    /**
     * Relación: un ganado pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
