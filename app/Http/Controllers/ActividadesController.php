<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ActividadStoreRequest;

use App\Sector;

use App\Actividad;

use App\Metrado;

use DB;

use Illuminate\Support\Facades\Storage;

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
                'precio' => $request->precio,
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
        $imagen =  array('png','jpg','jpeg');
        $doc =  array('doc','docs');
        $xls =  array('xl','xls',);
        $actividad = Actividad::find($id);
        $r = '';
        foreach ($actividad->Reportes as $key => $reporte) {
            # code... Storage::url($filename)
            $r .= '
            <div class="accordion" id="accordionWrapa2" data-toggle-hover="true">
                <div class="card collapse-header">
                    <div id="heading-reporte-'.$reporte->id.'" class="card-header collapsed" role="tablist" data-toggle="collapse" data-target="#accordion-reporte-'.$reporte->id.'" aria-expanded="false" aria-controls="accordion-reporte-'.$reporte->id.'">
                        <span class="collapse-title mb-1">
                            '. $reporte->fecha .'
                        </span>
                    </div>
                    <div id="accordion-reporte-'.$reporte->id.'" role="tabpanel" data-parent="#accordionWrapa2" aria-labelledby="heading-reporte-'.$reporte->id.'" class="collapse" style="">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>N°</th>
                                                <th>'. __('messages.fecha') .'</th>
                                                <th>'. __('messages.metradoRealizado') .'</th>
                                            </tr>

                                            <tr>
                                                <td>'.($key+1).'</td>
                                                <td>'.$reporte->fecha.'</td>
                                                <td>'.$reporte->metrado.' '.$reporte->Actividad->Unidad->nombre.'</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>    
                                <div class="row">
                                    <div class="col-12">    
                                        <div class="row app-file-recent-access">
                                            ';

                                              foreach ($reporte->Soportes as $soporte) {

                                                if (in_array($soporte->tipo, $imagen, TRUE )) {
                                                 $r .='
                                                  <div class="col-md-3 col-6">
                                                    <div class="card border shadow-none mb-1 app-file-info ">
                                                        <div class="card-content">
                                                          <div class="app-file-content-logo card-img-top cursor-pointer" style="padding: 10px 6px;    border-bottom: 1px solid #dfe3e7; background-color: #f2f4f4; width: 100%">
                                                            <i class="bx bx-dots-vertical-rounded app-file-edit-icon d-block float-right"></i>
                                                            <img class="d-block mx-auto" src="'.asset(\Storage::url($soporte->archivo)).'" alt="Card image cap" width="50" height="100%" style="min-height: 89px !important;max-height: 89px !important;">
                                                          </div>
                                                          <div class="card-body p-50">
                                                            <div class="app-file-recent-details">
                                                              <div class="app-file-name font-size-small font-weight-bold"><a href="'.asset(\Storage::url($soporte->archivo)).'" target="_blank">'.$soporte->archivo.'</a></div>
                                                              <div class="app-file-last-access font-size-small text-muted"><a href=""> <i class="bx bxs-download"></i> Descargar</a></div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                    </div>
                                                  </div>
                                                  ';
                                                }else if ($soporte->tipo == 'pdf') {
                                                   $r .='<div class="col-md-3 col-6">
                                                      <div class="card border shadow-none mb-1 app-file-info ">
                                                        <div class="card-content">
                                                          <div class="app-file-content-logo card-img-top cursor-pointer" style="padding: 10px 6px;    border-bottom: 1px solid #dfe3e7; background-color: #f2f4f4;">
                                                            <i class="bx bx-dots-vertical-rounded app-file-edit-icon d-block float-right"></i>
                                                            <img class="d-block mx-auto" src="'.asset('images/icon/pdf.png').'" alt="Card image cap" width="30" height="38" style="margin: 25px 0;">
                                                          </div>
                                                          <div class="card-body p-50">
                                                            <div class="app-file-recent-details">
                                                              <div class="app-file-name font-size-small font-weight-bold"><a href="'.asset(\Storage::url($soporte->archivo)).'" target="_blank">'.$soporte->archivo.'</a></div>
                                                              <div class="app-file-last-access font-size-small text-muted"><a href=""> <i class="bx bxs-download"></i> Descargar</a></div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                  </div>
                                                  ';
                                                } else{
                                                  $r .='<div class="col-md-3 col-6">
                                                      <div class="card border shadow-none mb-1 app-file-info ">
                                                        <div class="card-content">
                                                          <div class="app-file-content-logo card-img-top cursor-pointer" style="padding: 10px 6px;    border-bottom: 1px solid #dfe3e7; background-color: #f2f4f4;">
                                                            <i class="bx bx-dots-vertical-rounded app-file-edit-icon d-block float-right"></i>
                                                            <img class="d-block mx-auto" src="'.asset('images/icon/doc.png').'" alt="Card image cap" width="30" height="38" style="margin: 25px 0;">
                                                          </div>
                                                          <div class="card-body p-50">
                                                            <div class="app-file-recent-details">
                                                              <div class="app-file-name font-size-small font-weight-bold"><a href="'.asset(\Storage::url($soporte->archivo)).'" target="_blank">'.$soporte->archivo.'</a></div>
                                                              <div class="app-file-last-access font-size-small text-muted"><a href=""> <i class="bx bxs-download"></i> Descargar</a></div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                  </div>
                                                  ';
                                                }
                                              }

                                            $r.='
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
        return response()->json([
            'actividad' => $actividad,
            'reportes' => $actividad->Reportes->sum('metrado'),
            'r' => $r,
            'success' => true
        ]);

        // <div class="col-md-3 col-6">
        //     <div class="card border shadow-none mb-1 app-file-info ">
        //       <div class="card-content">
        //         <div class="app-file-content-logo card-img-top cursor-pointer" style="padding: 10px 6px;    border-bottom: 1px solid #dfe3e7; background-color: #f2f4f4;">
        //           <i class="bx bx-dots-vertical-rounded app-file-edit-icon d-block float-right"></i>
        //           <img class="d-block mx-auto" src="'.asset('images/icon/pdf.png').'" alt="Card image cap" width="30" height="38" style="margin: 25px 0;">
        //         </div>
        //         <div class="card-body p-50">
        //           <div class="app-file-recent-details">
        //             <div class="app-file-name font-size-small font-weight-bold"><a href="">Felecia Resume.pdf</a></div>
        //             <div class="app-file-size font-size-small text-muted mb-25">12.85kb</div>
        //             <div class="app-file-last-access font-size-small text-muted">Last accessed : 3 hours ago</div>
        //           </div>
        //         </div>
        //       </div>
        //     </div>
        // </div>
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $metrado = Metrado::all();
        $actividad = Actividad::find($id);
        if ($actividad) {
            return view('panel.actividades.edit',['actividad' => $actividad, 'unidades' => $metrado]);
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
    public function update(ActividadStoreRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $metrado = Metrado::find($request->unidad_id);
            $actividad = Actividad::find($id);
            $actividad->update([
                'unidad_id' => $request->unidad_id,
                'nombre' => $request->nombre_actividad,
                'descripcion' => $request->descripcion,
                'metrado' => $request->metrado,
                'precio' => $request->precio,
                'estatus' => $request->estatus,
            ]);

            DB::commit();

            return redirect()->route('sectores.actividades.index',['id' => $actividad->sector_id])->with([
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
