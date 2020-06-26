<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

use App\Sector;

use App\Actividad;

use App\Reporte;

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

    public function total($tipo)
    {
        $t =  0;
        foreach ($this->Actividades as $actividad) {
            foreach ($actividad->Reportes as $reporte) {
                if ($reporte->tipo  == $tipo) {
                    $t += $reporte->metrado*$actividad->precio;
                }
            }
        }
        return $t;
        // $a = DB::table('actividades')->where('sector_id',$this->id);
        // $b =  DB::table('reportes')->where('actividad',$this->id)->get();
        // return DB::select(DB::raw('SELECT reportes.metrado * actividades.precio AS monto FROM reportes, actividades WHERE actividades.id = reportes.actividad_id AND actividades.sector_id = :id'),['id' => $this->id]);
        // return Sector::join('actividad','sector.id','=',$this->id)
        //     ->join('reportes','actividad.id', '=', 'reportes.actividad_id')
        //     ->select('*')
        //     ->get();
        // return Actividad::join('reportes','actividad.id','=','reportes.actividad_id')
        //     ->join('sectores','actividad.sector_id', '=', $this->id)
        //     ->select('*')
        //     ->get();
    }
}
