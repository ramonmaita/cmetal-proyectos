<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ActividadStoreRequest;

use App\Sector;

use App\Actividad;

use App\Metrado;

use DB;

class ActividadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $sector = Sector::find($id);
        return view('panel.actividades.index',['sector' => $sector, 'proyecto' => $sector->Proyecto,'actividades' => $sector->Actividades]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $sector = Sector::find($id);
        $metrados = Metrado::all();
        if ($sector) {
            return view('panel.actividades.create',['sector' => $sector, 'unidades' => $metrados]);
        } else {
            return abort(404);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActividadStoreRequest $request,$id)
    {
        try {
            DB::beginTransaction();
            $metrado = Metrado::find($request->unidad_id);
            Actividad::create([
                'sector_id' => $id,
                'unidad_id' => $request->unidad_id,
                'nombre' => $request->nombre_actividad,
                'descripcion' => $request->descripcion,
                'metrado' => $request->metrado,
                'precio' => $metrado->precio,
                'estatus' => $request->estatus,
            ]);

            DB::commit();

            return redirect()->route('sectores.actividades.index',['id' => $id])->with([
                'success' => __('messages.operacionExitosa')
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with([
                'error'     => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actividad = Actividad::find($id);
        return response()->json([
            'actividad' => $actividad,
            'reportes' => $actividad->Reportes,
            'success' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActividadStoreRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
