<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre','apellido', 'email', 'password','tipo','estatus','empresa_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        if ($this->tipo == 0 || $this->tipo == 1) {
            return true;
        }else{
            return false;
        }
    }

    public function Proyectos()
    {
        return $this->belongsToMany('App\Proyecto', 'usuario_proyectos', 'user_id', 'proyecto_id');

    }

    public function ProyectosUsuarios()
    {
        return $this->hasMany('App\UsuarioProyecto');

    }

    public function Comentarios()
    {
        return $this->hasMany('App\Comentario');

    }

    public function Empresa()
    {
        return $this->belongsTo('App\Empresa');
    }
}
