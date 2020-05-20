<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

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

    public function porcentajeSector()
    {
        return $this->hasManyThrough('App\Reporte', 'App\Actividad');
       // $this->hasMany('App\Actividad')->sum('metrado');
       // $ida = $this->hasMany('App\Actividad')->pluck('id');
       // return 
    }
}
