<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public function users()
    {
        return $this
            ->belongsToMany('App\User')
            ->withTimestamps();
    }
    // public function asociacion()
    // {
    //     return $this
    //         ->belongsToMany('App\Asociacion')
    //         ->withTimestamps();
    // }
}
