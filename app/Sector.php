<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
	protected $table ="sectores";

	protected $fillable = [
		'proyecto_id', 'nombre', 'descripcion'
	];
    
    public function Proyecto()
    {
    	return $this->belongsTo('App\Proyecto');
    }

    public function Actividades()
    {
    	return $this->hasMany('App\Actividad');
    }
}
