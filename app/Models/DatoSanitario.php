<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatoSanitario extends Model
{
    protected $table = 'datos_sanitarios';

    protected $fillable = [
        'user_id',
        'ganado_id',
        'vacuna',
        'vacunado_fiebre_aftosa',
        'vacunado_antirabica',
        'tratamiento',
        'medicamento',
        'fecha_aplicacion',
        'proxima_fecha',
        'veterinario',
        'observaciones',
        'certificado_imagen',
        'destino_matadero_campo',
        'hoja_ruta_foto',
        'marca_ganado',
        'marca_ganado_foto',
        'senal_numero',
        'nombre_dueño',
        'carnet_dueño_foto'
    ];

    protected $casts = [
        'vacunado_fiebre_aftosa' => 'boolean',
        'vacunado_antirabica' => 'boolean',
    ];

    public function ganado()
    {
        return $this->belongsTo(Ganado::class);
    }
}
