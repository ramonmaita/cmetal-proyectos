<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
	protected $fillable = [
        'fecha_inicio', 'fecha_fin', 'nombre', 'direccion', 'descripcion', 'gastos_generales', 'descuento', 'utilidad', 'gasto_estimado', 'estatus'
    ];
    
    public function Usuarios()
    {
        return $this->belongsToMany('App\User');
    }
    public function UsuarioProyecto()
    {
        return $this->hasMany('App\UsuarioProyecto');
    }
    public function Comentarios()
    {
        return $this->hasMany('App\Comentario');
    }
    public function Sectores()
    {
    	return $this->hasMany('App\Sector');
    }

    public function Gastos()
    {
        return $this->hasMany('App\Gasto');
    }
    public function Facturas()
    {
        return $this->hasMany('App\Factura');
    }
    public function Depositos()
    {
        return $this->hasMany('App\Deposito');
    }
    public function MetradoProyecto()
    {
    	$mr = 0;
    	$mt = 0;
    	$pr = 0;
    	$pt = 0;
    	foreach ($this->Sectores as $sector) {
    		$mr += $sector->porcentajeSector->sum('metrado');
			$mt += $sector->Actividades->sum('metrado');
			$pt += $sector->Actividades->sum('metrado')*$sector->Actividades->sum('precio');
			$pr += $sector->total();
    		// foreach ($sector->Actividades as $actividad) {
    		// 	$mr += $actividad->porcentajeSector->sum('metrado');
    		// }
    	}

    	return ['mt' => $mt, 'mr' => $mr,'pt' => $pt, 'pr' => $pr];
    }
}
