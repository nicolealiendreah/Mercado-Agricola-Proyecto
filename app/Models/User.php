<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación: un usuario pertenece a un rol
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Relación: un usuario puede tener múltiples solicitudes de vendedor
     */
    public function solicitudesVendedor()
    {
        return $this->hasMany(SolicitudVendedor::class);
    }

    /**
     * Obtener el nombre del rol
     */
    public function getRoleNameAttribute()
    {
        // Si tiene role_id, obtener el nombre del rol desde la relación
        if ($this->role_id) {
            // Intentar obtener la relación (si está cargada)
            $roleRelation = $this->getRelationValue('role');
            
            // Si la relación está cargada y es un objeto Role
            if ($roleRelation instanceof Role) {
                return $roleRelation->nombre;
            }
            
            // Si no está cargada, obtenerla directamente
            $role = Role::find($this->role_id);
            if ($role) {
                return $role->nombre;
            }
        }
        
        // Fallback: si existe el campo 'role' antiguo (string) y no es la relación
        if (isset($this->attributes['role']) && 
            is_string($this->attributes['role']) && 
            !$this->relationLoaded('role')) {
            return $this->attributes['role'];
        }
        
        return 'cliente'; // Por defecto
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin(): bool
    {
        return $this->role_name === Role::ADMIN;
    }

    /**
     * Verificar si el usuario es vendedor
     */
    public function isVendedor(): bool
    {
        return $this->role_name === Role::VENDEDOR;
    }

    /**
     * Verificar si el usuario es cliente
     */
    public function isCliente(): bool
    {
        $roleName = $this->role_name;
        return $roleName === Role::CLIENTE || $roleName === null || $roleName === '';
    }

    /**
     * Obtener solicitud pendiente del usuario
     */
    public function solicitudPendiente()
    {
        return $this->solicitudesVendedor()->where('estado', 'pendiente')->first();
    }
}
