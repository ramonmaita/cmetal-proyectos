<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
	protected $fillable = [
		'actividad_id','metrado','fecha'
	];
    //

    public function Actividad()
    {
    	return $this->belongsTo('App\Actividad','actividad_id','id');
    }
}
