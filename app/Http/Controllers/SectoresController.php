<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\SectorStoreRequest;

use App\Proyecto;

use App\Sector;

use DB;

class SectoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $proyecto = Proyecto::find($id);
        $sectores = $proyecto->Sectores;
        return view('panel.sectores.index',['sectores' => $sectores, 'proyecto' => $proyecto]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $proyecto = Proyecto::find($id);
        return view('panel.sectores.create',['proyecto' => $proyecto]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectorStoreRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            Sector::create([
                'proyecto_id' => $id,
                'nombre' => $request->nombre_sector,
                'descripcion' => $request->descripcion,
            ]);
            DB::commit();
            return redirect()->route('sectores',['id'=>$id])->with([
                'success' => __('messages.operacionExitosa')
            ]);
        } catch (\Exception $e) {
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sector = Sector::find($id);
        if ($sector) {
            return view('panel.sectores.edit',['sector' => $sector, 'proyecto' => $sector->Proyecto]);
        } else {
            return abort(404);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SectorStoreRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $sector = Sector::find($id);
            $sector->update([
                'nombre' => $request->nombre_sector,
                'descripcion' => $request->descripcion,
            ]);
            DB::commit();
            return redirect()->route('sectores',['id'=>$sector->proyecto_id])->with([
                'success' => __('messages.operacionExitosa')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with([
                'error'     => $e->getMessage()
            ]);
        }
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
