<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
	protected $table = 'actividades';

	protected $fillable = [
		'sector_id', 'unidad_id', 'nombre', 'descripcion', 'metrado', 'precio', 'estatus'
	];

	public function Sector()
	{
		return $this->belongsTo('App\Sector');
	}

	public function Unidad()
	{
		return $this->belongsTo('App\Metrado','unidad_id','id');
	}

	public function Reportes()
	{
		return $this->hasMany('App\Reporte');
	}

	public function avance($tipo)
	{
		return round(($this->hasMany('App\Reporte')->where('tipo',$tipo)->sum('metrado')/$this->metrado)*100,2);
		
	}
    //
}
