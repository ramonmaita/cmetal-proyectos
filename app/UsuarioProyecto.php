<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioProyecto extends Model
{
    protected $fillable = [
    	'user_id','proyecto_id'
    ];
}
