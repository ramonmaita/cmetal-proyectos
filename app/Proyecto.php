<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
	protected $fillable = [
        'fecha_inicio', 'fecha_fin', 'nombre', 'direccion', 'descripcion', 'estatus'
    ];
    

    public function Sectores()
    {
    	return $this->hasMany('App\Sector');
    }
}
