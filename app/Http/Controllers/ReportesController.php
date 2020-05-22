<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reporte;

use App\Soporte;

use App\Actividad;

use DB;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        try {
            DB::beginTransaction();

            $reporte = Reporte::create([
                'actividad_id' => $id,
                'fecha' => $request->fecha,
                'metrado' => $request->metrado,
            ]);

            $archivos = $request->file('archivo');
            if ($request->hasFile('archivo')) {
                foreach ($archivos as $archivo) {
                    $nombre = $archivo->getClientOriginalName();
                    $extension = $archivo->getClientOriginalExtension();
                    // $file->store('');
                    \Storage::disk('public')->put($nombre,  \File::get($archivo));

                    Soporte::create([
                        'reporte_id' => $reporte->id,
                        'archivo' => $nombre,
                        'tipo' => $extension
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with([
                'success' => __('messages.operacionExitosa')
            ]);
        } catch (Exception $e) {
            DB::rollback();
             return redirect()->back()->with([
                'error'     => $e->getMessage(),
                // 'error' => true
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
