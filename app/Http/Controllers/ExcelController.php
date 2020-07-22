<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Excel;

use App\ProyetoTemp;

class ExcelController extends Controller
{
	public function index()
	{
		return view('panel.archivo.index');
	}
	public function model(array $row)
    {
        return new ProyetoTemp([
            'empresa_id' => ($row->empresa_id == '') ? Auth::user()->empresa_id : $request->empresa,
            'fecha_inicio' => $row->fecha_inicio,
            'fecha_fin' => $row->fecha_fin,
            'nombre' => $row->nombre,
            'direccion' => $row->direccion,
            'descripcion' => $row->descripcion,
            'gastos_generales' => $row->gastos_generales,
            'utilidad' => $row->utilidad,
            'descuento' => $row->descuento,
            'gasto_estimado' => $row->gasto_estimado,
            'estatus' => $row->estatus,
        ]);
    }
    public function subir_archivo(Request $request)
    {
        /** El método load permite cargar el archivo definido como primer parámetro */
        ini_set('max_execution_time', 3600);
        Excel::import(new UsersImport, request()->file('excel'));
        // Excel::load($request->excel, function ($reader) {
        //     $excel = $reader->get();
        //     $reader->each(function($row){
        //         $proyecto = Proyecto::create([
        //         'empresa_id' => ($row->empresa_id == '') ? Auth::user()->empresa_id : $request->empresa,
        //         'fecha_inicio' => $row->fecha_inicio,
        //         'fecha_fin' => $row->fecha_fin,
        //         'nombre' => $row->nombre,
        //         'direccion' => $row->direccion,
        //         'descripcion' => $row->descripcion,
        //         'gastos_generales' => $row->gastos_generales,
        //         'utilidad' => $row->utilidad,
        //         'descuento' => $row->descuento,
        //         'gasto_estimado' => $row->gasto_estimado,
        //         'estatus' => $row->estatus,
        //     ]);

                

        //     });

        // });

            return redirect()->back()->with('mensaje', 'Los datos han sido importados exitosamente');

    }
}
