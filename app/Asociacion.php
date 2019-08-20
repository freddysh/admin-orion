<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class Asociacion extends Model

class Asociacion extends Authenticatable
{
    //
    use Notifiable;
    protected $table = "asociacion";

    protected $fillable = [
        'email', 'password',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function fotos()
    {
        return $this->hasMany(AsociacionFoto::class, 'asociacion_id');
    }
    public function comunidad()
    {
        return $this->belongsTo(Comunidad::class, 'comunidad_id');
    }
    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'asociacion_id');
    }
    public function reserva_actividad()
    {
        return $this->hasMany(ReservaActividad::class, 'asociacion_id');
    }
    public function reserva_comida()
    {
        return $this->hasMany(ReservaComida::class, 'asociacion_id');
    }
    public function reserva_hospedaje()
    {
        return $this->hasMany(ReservaHospedaje::class, 'asociacion_id');
    }
    public function reserva_transporte()
    {
        return $this->hasMany(ReservaTransporte::class, 'asociacion_id');
    }
    public function reserva_servicio()
    {
        return $this->hasMany(ReservaServicio::class, 'asociacion_id');
    }


    // METODOS PARA LOS ROLES DE LA ASOCIACION
    // public function roles()
    // {
    //     return $this
    //         ->belongsToMany('App\Role')
    //         ->withTimestamps();
    // }

    // public function authorizeRoles($roles)
    // {
    //     if ($this->hasAnyRole($roles)) {
    //         return true;
    //     }
    //     abort(401, 'Esta acción no está autorizada.');
    // }
    // public function hasAnyRole($roles)
    // {
    //     if (is_array($roles)) {
    //         foreach ($roles as $role) {
    //             if ($this->hasRole($role)) {
    //                 return true;
    //             }
    //         }
    //     } else {
    //         if ($this->hasRole($roles)) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }
    // public function hasRole($role)
    // {
    //     if ($this->roles()->where('name', $role)->first()) {
    //         return true;
    //     }
    //     return false;
    // }
}
