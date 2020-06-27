<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ProyectoStoreRequest;

use Yajra\DataTables\Facades\DataTables;

use App\Proyecto;

use App\User;

use App\Empresa;

use App\UsuarioProyecto;

use DB;

use Dompdf\Dompdf;

use Auth;

use Carbon\Carbon;

class ProyectosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');

        // $this->middleware('log')->only('index');

        $this->middleware('proyectos', ['only' => ['create','store', 'edit', 'update', 'destroy']]);

        // $this->middleware('proyectos', ['only' => ['store', 'edit', 'update', 'destroy']]);
    }
    public function index()
    {
        if (request()->ajax()) {
            return $this->getData();
        }
        return view('panel.proyectos.index');
    }

    public function getData()
    {
        // $model =  Proyecto::where('estatus',1)->get();
        if (Auth::user()->isAdmin() == true) {
            $model =  Proyecto::all();
        }else{
            $model =  Auth::user()->Proyectos;
        }

        return DataTables::of($model)
            ->editColumn('estatus',function ($model)
            {
                switch ($model->estatus) {
                    case 1:
                        return '<span class="badge badge-pill badge-info">'.__('messages.activo').'</span>';
                        break;
                    case 2:
                        return '<span class="badge badge-pill badge-warning">'.__('messages.pausado').'</span>';
                        break;
                    case 3:
                        return '<span class="badge badge-pill badge-success">'.__('messages.terminado').'</span>';
                        break;
                    default:
                        return '<span class="badge badge-pill badge-primary">'.__('messages.espera').'</span>';
                        break;
                }
            })
            ->addColumn('acciones',function ($model)
            {
                if (Auth::user()->isAdmin() == true) {
                    return '
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="'.route('sectores',['id' => $model->id]).'" class="btn btn-icon  btn-light-cmetal "><i class="bx bxs-plus-circle"></i></a>
                        <a href="'.route('proyectos.show',['id' => $model->id]).'" class="btn  btn-icon btn-cmetal "><i class="bx bxs-show"></i></a>
                        <a href="'.route('proyectos.edit',['id' => $model->id]).'" class="btn  btn-icon btn-light-secondary "><i class="bx bxs-pencil"></i></a>
                
                    </div>
                    ';
                }else{
                     return '
                    <a href="'.route('proyectos.show',['id' => $model->id]).'" class="btn  btn-icon btn-cmetal "><i class="bx bxs-show"></i></a>
                
                    ';
                }
            }) 
            ->rawColumns(['action'])
            ->escapeColumns([])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.proyectos.create',['supervisores' => User::where('tipo',2)->where('estatus',1)->get(), 'clientes' => User::where('tipo',3)->where('estatus',1)->get(),'proveedores' => User::where('tipo',4)->where('estatus',1)->get(),'empresas' => Empresa::where('estatus',1)->get() ]);
    }

    public function pdf($id)    
    {
        $proyecto = Proyecto::find($id);
        $dompdf = new Dompdf();

        $html = view('panel.proyectos.pdf',['proyecto' => $proyecto]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter');
        $dompdf->render();
        $font = $dompdf->getFontMetrics()->get_font("helvetica");
                                        //ancho alto 
        $dompdf->getCanvas()->page_text(500, 740, "Pág. {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
        return $dompdf->stream("Proyecto", array("Attachment" => false));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProyectoStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $proyecto = Proyecto::create([
                'empresa_id' => ($request->empresa == '') ? Auth::user()->empresa_id : $request->empresa,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'nombre' => $request->nombre_proyecto,
                'direccion' => $request->direccion,
                'descripcion' => $request->descripcion,
                'gastos_generales' => $request->gastos,
                'utilidad' => $request->utilidad,
                'descuento' => $request->descuento,
                'gasto_estimado' => $request->gastosE,
                'estatus' => $request->estatus,
            ]);

            if (isset($request->supervisor) && $request->supervisor != '') {
                UsuarioProyecto::create([
                    'user_id' => $request->supervisor,
                    'proyecto_id' => $proyecto->id,
                    'tipo' => 1,
                ]);
            }
            if (isset($request->cliente) && $request->cliente != '') {
                UsuarioProyecto::create([
                    'user_id' => $request->cliente,
                    'proyecto_id' => $proyecto->id,
                    'tipo' => 2,
                ]);
            }
            if (isset($request->proveedor) && $request->proveedor != '') {
                UsuarioProyecto::create([
                    'user_id' => $request->proveedor,
                    'proyecto_id' => $proyecto->id,
                    'tipo' => 3,
                ]);
            }
            DB::commit();
            return redirect()->route('proyectos.index')->with([
                'success' => __('messages.operacionExitosa')
            ]);
        } catch (\Exception $e) {
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
        $proyecto = Proyecto::find($id);
        // $autorizado =  UsuarioProyecto::where('user_id',Auth::user()->id)->where('proyecto_id',$id)->count();
        $autorizado =  Auth::user()->ProyectosUsuarios->where('proyecto_id',$id)->count();
        if ($autorizado <=  0 && Auth::user()->isAdmin() == false) {
            return abort(403);
        }
        if ($proyecto) {
            // echo dd($proyecto->reports);
            // $pr = $proyecto->with(['sectores', 'sectores.actividades', 
            //                                 'sectores.actividades.reportes'])
            //                         ->get();

            //                         echo dd($pr);
            // return '';
            // ratio de compras p8/p7
            $metrados = $proyecto->MetradoProyecto()['mr'];//7
            $fechaA = Carbon::parse($proyecto->fecha_inicio);
            $fechaB = Carbon::parse($fechaA)->addDays(7)->format('Y-m-d');
            $dataratio = array();
            $dataavance = array();
            $datagasto = array();
            $labels = array();

            // ratio de compras p8/p7
            foreach ($proyecto->Sectores as $sector) {
                    if ($sector->porcentajeSector->where('tipo',3)->max('fecha') == null) {
                        $f1 = Carbon::createFromFormat('Y-m-d',$proyecto->fecha_inicio);
                    } else {
                        $f1 = Carbon::createFromFormat('Y-m-d',@$sector->porcentajeSector->where('tipo',3)->max('fecha'));
                    }
                    if ($proyecto->Gastos->max('fecha') == null) {
                        $f2 = Carbon::createFromFormat('Y-m-d',$proyecto->fecha_fin);
                    } else {
                        $f2 = Carbon::createFromFormat('Y-m-d',@$proyecto->Gastos->max('fecha'));
                    }
                    
                    
                    $c = ceil($f1->max($f2)->diffInDays($fechaA)/7);
                    // dd($metrado);
                    $precio = 0;
                    for ($i=0; $i < $c; $i++) { 
                        $fechaB = Carbon::parse($fechaA)->addDays(7)->format('Y-m-d');
                        $metrados = $sector->porcentajeSector->where('tipo',3)->whereBetween('fecha', array($fechaA,  $fechaB));
                            $gastos = $proyecto->Gastos->whereBetween('fecha', array($fechaA,  $fechaB))->sum('monto');//8
                        foreach ($sector->porcentajeSector->where('tipo',3)->whereBetween('fecha', array($fechaA,  $fechaB)) as $metrado) {
                            $precio = $metrado->metrado*$metrado->Actividad->precio ;
                        }
                        $ratio=  ($precio == 0) ? 0 : round( $gastos/$precio,2);
                        $label =  Carbon::parse($fechaA)->format('d-m-y')." - ".Carbon::parse($fechaB)->format('d-m-y') ;
                         array_push($dataratio, $ratio);
                         array_push($dataavance, $precio);
                         array_push($datagasto, $gastos);
                         array_push($labels, $label);
                         $precio = 0;
                         $fechaA =  $fechaB;
                    }
                    // return '';
                    

                //  return '';
                // foreach ($sector->porcentajeSector->where('tipo',3) as $metrado)
                // {
                //     $fechaB = Carbon::parse($fechaA)->addDays(7)->format('Y-m-d');
                //     $gastos = $proyecto->Gastos->whereBetween('fecha', array($fechaA,  $fechaB))->sum('monto');//8
                //     $precio = $metrado->metrado*$metrado->Actividad->precio;
                //     $ratio=  round($gastos/$precio,2);
                //     $label =  Carbon::parse($fechaA)->format('d-m-y')." - ".Carbon::parse($fechaB)->format('d-m-y') ;
                //      array_push($dataratio, $ratio);
                //      array_push($dataavance, $precio);
                //      array_push($datagasto, $gastos);
                //      array_push($labels, $label);
                //      $fechaA =  $fechaB;
                // }
            }

            // ratio de facturacion
            // $dataratiof = array();
            // $dataavanceR = array();
            // $datafacturado = array();
            // $labelsf = array();
            $fechaA = $proyecto->fecha_inicio;
            $dataratiof = '';
            $dataavanceR = '';
            $datafacturado = '';
            $labelsf = '';

            foreach ($proyecto->Sectores as $sector) {
                $sector->porcentajeSector->where('tipo',3);
                if ($sector->porcentajeSector->where('tipo',3)->max('fecha') == null) {
                    $f1 = Carbon::createFromFormat('Y-m-d',$proyecto->fecha_inicio);
                } else {
                    $f1 = Carbon::createFromFormat('Y-m-d',@$sector->porcentajeSector->where('tipo',3)->max('fecha'));
                }
                if ($proyecto->Facturas->max('fecha') == null) {
                    $f2 = Carbon::createFromFormat('Y-m-d',$proyecto->fecha_fin);
                } else {
                    $f2 = Carbon::createFromFormat('Y-m-d',@$proyecto->Facturas->max('fecha'));
                }
                // $f1 = Carbon::createFromFormat('Y-m-d',$sector->porcentajeSector->where('tipo',3)->max('fecha'));
                // $f2 = Carbon::createFromFormat('Y-m-d',$proyecto->Facturas->max('fecha'));
                $c = ceil($f1->max($f2)->diffInDays($fechaA)/7);
                $metrado = $sector->porcentajeSector->where('tipo',3);
                $precio = 0;
                for ($i=0; $i < $c; $i++) {
                    $fechaB = Carbon::parse($fechaA)->addDays(7)->format('Y-m-d');

                    $facturado = $proyecto->Facturas->whereBetween('fecha', array($fechaA,  $fechaB))->sum('monto');//8
                    foreach ($sector->porcentajeSector->where('tipo',3)->whereBetween('fecha', array($fechaA,  $fechaB)) as $metrado) {
                        $precio = $metrado->metrado*$metrado->Actividad->precio ;
                    }
                    $ratio=  ($precio == 0) ? 0 : round( $facturado/$precio,2);
                    // $ratio=  $facturado/$precio;
                    $label =  Carbon::parse($fechaA)->format('d-m-y')." - ".Carbon::parse($fechaB)->format('d-m-y') ;

                    $dataratiof .= '"'.round($ratio,2). '",';
                    $dataavanceR .= '"'.$precio. '",' ;
                    $datafacturado .= '"'.$facturado. '",';
                    $labelsf .= '"'.$label. '",' ;
                     // array_push($dataratiof, $ratio);
                     // array_push($dataavanceR, $precio);
                     // array_push($datafacturado, $facturado);
                     // array_push($labelsf, $label);
                     $fechaA =  $fechaB;
                }
                // foreach ($sector->porcentajeSector->where('tipo',3) as $metrado)
                // {
                //     $fechaB = Carbon::parse($fechaA)->addDays(7)->format('Y-m-d');

                //     $facturado = $proyecto->Facturas->whereBetween('fecha', array($fechaA,  $fechaB))->sum('monto');//8
                //     $precio = $metrado->metrado*$metrado->Actividad->precio;
                //     $ratio=  $facturado/$precio;
                //     $label =  Carbon::parse($fechaA)->format('d-m-y')." - ".Carbon::parse($fechaB)->format('d-m-y') ;

                //     $dataratiof .= '"'.round($ratio,2). '",';
                //     $dataavanceR .= '"'.$precio. '",' ;
                //     $datafacturado .= '"'.$facturado. '",';
                //     $labelsf .= '"'.$label. '",' ;
                //      // array_push($dataratiof, $ratio);
                //      // array_push($dataavanceR, $precio);
                //      // array_push($datafacturado, $facturado);
                //      // array_push($labelsf, $label);
                //      $fechaA =  $fechaB;
                // }
            }

            // ratio de cobro

            $fechaA = $proyecto->fecha_inicio;
            $dataratioc = '';
            $dataavanceRC = '';
            $datacobrado = '';
            $labelsc = '';
            $fechaB = Carbon::parse($proyecto->fecha_inicio)->addDays(7)->format('Y-m-d');

            foreach ($proyecto->Sectores as $sector) {
                 $sector->porcentajeSector->where('tipo',3);
                 if ($sector->porcentajeSector->where('tipo',3)->max('fecha') == null) {
                    $f1 = Carbon::createFromFormat('Y-m-d',$proyecto->fecha_inicio);
                } else {
                    $f1 = Carbon::createFromFormat('Y-m-d',@$sector->porcentajeSector->where('tipo',3)->max('fecha'));
                }
                if ($proyecto->Depositos->max('fecha') == null) {
                    $f2 = Carbon::createFromFormat('Y-m-d',$proyecto->fecha_fin);
                } else {
                    $f2 = Carbon::createFromFormat('Y-m-d',@$proyecto->Depositos->max('fecha'));
                }
                // $f1 = Carbon::createFromFormat('Y-m-d',$sector->porcentajeSector->where('tipo',3)->max('fecha'));
                // $f2 = Carbon::createFromFormat('Y-m-d',$proyecto->Depositos->max('fecha'));
                $c = ceil($f1->max($f2)->diffInDays($fechaA)/7);
                $metrado = $sector->porcentajeSector->where('tipo',3);
                $precio = 0;
                for ($i=0; $i < $c; $i++) {
                    $fechaB = Carbon::parse($fechaA)->addDays(7)->format('Y-m-d');

                    $cobrado = $proyecto->Depositos->whereBetween('fecha', array($fechaA,  $fechaB))->sum('monto');//8
                    foreach ($sector->porcentajeSector->where('tipo',3)->whereBetween('fecha', array($fechaA,  $fechaB)) as $metrado) {
                        $precio = $metrado->metrado*$metrado->Actividad->precio ;
                    }
                    $ratio=  ($precio == 0) ? 0 : round( $cobrado/$precio,2);
                    // $ratio=  $cobrado/$precio;
                    $label =  Carbon::parse($fechaA)->format('d-m-y')." - ".Carbon::parse($fechaB)->format('d-m-y') ;

                     $dataratioc .= '"'.round($ratio,2). '",';
                    $dataavanceRC .= '"'.$precio. '",' ;
                    $datacobrado .= '"'.$cobrado. '",';
                    $labelsc .= '"'.$label. '",' ;
                    $fechaA = $fechaB;
                }

                // foreach ($sector->porcentajeSector->where('tipo',3) as $metrado)
                // {
                //     $fechaB = Carbon::parse($fechaA)->addDays(7)->format('Y-m-d');

                //     $cobrado = $proyecto->Depositos->whereBetween('fecha', array($fechaA, $fechaB))->sum('monto');//8
                //     $precio = $metrado->metrado*$metrado->Actividad->precio;
                //     $ratio=  $cobrado/$precio;
                //     $label =  Carbon::parse($fechaA)->format('d-m-y')." - ".Carbon::parse($fechaB)->format('d-m-y') ;

                //     $dataratioc .= '"'.round($ratio,2). '",';
                //     $dataavanceRC .= '"'.$precio. '",' ;
                //     $datacobrado .= '"'.$cobrado. '",';
                //     $labelsc .= '"'.$label. '",' ;
                //     $fechaA = $fechaB;
                // }
            }
            // ratio de flujo de caja facturada

            $fechaA = $proyecto->fecha_inicio;
            $dataratiofc = '';
            $dataGasF = '';
            $datafacF = '';
            $labelsf = '';
            $fechaB = Carbon::parse($proyecto->fecha_inicio)->addDays(7)->format('Y-m-d');

            foreach ($proyecto->Sectores as $sector) {
                 $sector->porcentajeSector->where('tipo',3);

                // $f1 = Carbon::createFromFormat('Y-m-d',$sector->porcentajeSector->where('tipo',3)->max('fecha'));
                // $f1 = Carbon::createFromFormat('Y-m-d',$proyecto->Gastos->max('fecha'));
                // $f2 = Carbon::createFromFormat('Y-m-d',$proyecto->Facturas->max('fecha'));
                if ($proyecto->Gastos->max('fecha') == null) {
                    $f1 = Carbon::createFromFormat('Y-m-d',$proyecto->fecha_fin);
                } else {
                    $f1 = Carbon::createFromFormat('Y-m-d',@$proyecto->Gastos->max('fecha'));
                }
                if ($proyecto->Facturas->max('fecha') == null) {
                    $f2 = Carbon::createFromFormat('Y-m-d',$proyecto->fecha_fin);
                } else {
                    $f2 = Carbon::createFromFormat('Y-m-d',@$proyecto->Facturas->max('fecha'));
                }
                $c = ceil($f1->max($f2)->diffInDays($fechaA)/7);
                $metrado = $sector->porcentajeSector->where('tipo',3);
                for ($i=0; $i < $c; $i++) {
                    $fechaB = Carbon::parse($fechaA)->addDays(7)->format('Y-m-d');

                    $facturado = $proyecto->Facturas->whereBetween('fecha', array($fechaA,  $fechaB))->sum('monto');//8
                    $gastos = $proyecto->Gastos->whereBetween('fecha', array($fechaA,  $fechaB))->sum('monto');//8
                    
                    $ratio=  ($gastos == 0) ? 0 : round( $facturado/$gastos,2);
                    // $ratio=  $cobrado/$precio;
                    $label =  Carbon::parse($fechaA)->format('d-m-y')." - ".Carbon::parse($fechaB)->format('d-m-y') ;

                    $dataratiofc .= '"'.round($ratio,2). '",';
                    $dataGasF .= '"'.$gastos. '",' ;
                    $datafacF .= '"'.$facturado. '",';
                    $labelsf .= '"'.$label. '",' ;
                    $fechaA = $fechaB;
                }
            }

             // ratio de flujo de liquidez

            $fechaA = $proyecto->fecha_inicio;
            $dataratiofl = '';
            $dataGasDF = '';
            $datafacDF = '';
            $labelsDf = '';
            $fechaB = Carbon::parse($proyecto->fecha_inicio)->addDays(7)->format('Y-m-d');

            foreach ($proyecto->Sectores as $sector) {
                 $sector->porcentajeSector->where('tipo',3);

                // $f1 = Carbon::createFromFormat('Y-m-d',$sector->porcentajeSector->where('tipo',3)->max('fecha'));
                // $f2 = Carbon::createFromFormat('Y-m-d',$proyecto->Depositos->max('fecha'));
                if ($proyecto->Gastos->max('fecha') == null) {
                    $f1 = Carbon::createFromFormat('Y-m-d',$proyecto->fecha_fin);
                } else {
                    $f1 = Carbon::createFromFormat('Y-m-d',@$proyecto->Gastos->max('fecha'));
                }
                if ($proyecto->Depositos->max('fecha') == null) {
                    $f2 = Carbon::createFromFormat('Y-m-d',$proyecto->fecha_fin);
                } else {
                    $f2 = Carbon::createFromFormat('Y-m-d',@$proyecto->Depositos->max('fecha'));
                }
                $c = ceil($f1->max($f2)->diffInDays($fechaA)/7);
                $metrado = $sector->porcentajeSector->where('tipo',3);
                for ($i=0; $i < $c; $i++) {
                    $fechaB = Carbon::parse($fechaA)->addDays(7)->format('Y-m-d');

                    $cobrado = $proyecto->Depositos->whereBetween('fecha', array($fechaA,  $fechaB))->sum('monto');//8
                    $gastos = $proyecto->Gastos->whereBetween('fecha', array($fechaA,  $fechaB))->sum('monto');//8
                    
                    $ratio=  ($gastos == 0) ? 0 : round( $cobrado/$gastos,2);
                    // $ratio=  $cobrado/$precio;
                    $label =  Carbon::parse($fechaA)->format('d-m-y')." - ".Carbon::parse($fechaB)->format('d-m-y') ;

                    $dataratiofl .= '"'.round($ratio,2). '",';
                    $dataGasDF .= '"'.$gastos. '",' ;
                    $datafacDF .= '"'.$cobrado. '",';
                    $labelsDf .= '"'.$label. '",' ;
                    $fechaA = $fechaB;
                }
            }

             // ratio de produccion

            $fechaA = $proyecto->fecha_inicio;
            $dataratiofp = '';
            $dataavFP = '';
            $labelsFP = '';
            $fechaB = Carbon::parse($proyecto->fecha_inicio)->addDays(7)->format('Y-m-d');

            foreach ($proyecto->Sectores as $sector) {
                 $sector->porcentajeSector->where('tipo',3);

                // $f1 = Carbon::createFromFormat('Y-m-d',$sector->porcentajeSector->where('tipo',3)->max('fecha'));

                if ($sector->porcentajeSector->where('tipo',3)->max('fecha') == null) {
                    $f1 = Carbon::createFromFormat('Y-m-d',$proyecto->fecha_inicio);
                } else {
                    $f1 = Carbon::createFromFormat('Y-m-d',@$sector->porcentajeSector->where('tipo',3)->max('fecha'));
                }
                $fechaActual = Carbon::now();
                $f2 = ($fechaActual > $proyecto->fecha_fin) ? $proyecto->fecha_fin : $fechaActual ;
                $c = ceil($f1->max($f2)->diffInDays($fechaA)/7);
                for ($i=0; $i < $c; $i++) {
                    $fechaB = Carbon::parse($fechaA)->addDays(7)->format('Y-m-d');
                    $metrado = $sector->porcentajeSector->where('tipo',3)->whereBetween('fecha', array($fechaA,  $fechaB))->sum('metrado');
                    
                    $ratio=  round( $metrado/7,2);
                    // $ratio=  $metrado/$precio;
                    $label =  Carbon::parse($fechaA)->format('d-m-y')." - ".Carbon::parse($fechaB)->format('d-m-y') ;

                    $dataratiofp .= '"'.round($ratio,2). '",';
                    $dataavFP .= '"'.$metrado. '",';
                    $labelsFP .= '"'.$label. '",' ;
                    $fechaA = $fechaB;
                }
            }

            // return '';
            return view('panel.proyectos.show',['proyecto' => $proyecto,
                'labels' => $labels, 
                'datagasto'=> $datagasto, 
                'dataratio' => $dataratio, 
                'dataavance' => $dataavance,

                'labelsf' => $labelsf, 
                'datafacturado'=> $datafacturado, 
                'dataratiof' => $dataratiof, 
                'dataavanceR' => $dataavanceR,

                'dataratioc' => $dataratioc, 
                'dataavanceRC' => $dataavanceRC,
                'datacobrado'=> $datacobrado, 
                'labelsc' => $labelsc, 

                'dataratiofc' => $dataratiofc, 
                'dataGasF' => $dataGasF,
                'datafacF'=> $datafacF, 
                'labelsf' => $labelsf, 

                'dataratiofl' => $dataratiofl, 
                'dataGasDF' => $dataGasDF,
                'datafacDF'=> $datafacDF, 
                'labelsDf' => $labelsDf,

                'dataratiofp' => $dataratiofp,
                'dataavFP' => $dataavFP,
                'labelsFP' => $labelsFP, 



            ]);
        } else {
            return abort(404);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proyecto = Proyecto::find($id);

        if ($proyecto) {
            return view('panel.proyectos.edit',['proyecto' => $proyecto,'supervisores' => User::where('tipo',2)->get(), 'clientes' => User::where('tipo',3)->get(),]);
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
    public function update(ProyectoStoreRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $proyecto = Proyecto::find($id);
            $proyecto->update([
                'empresa_id' => ($request->empresa == '') ? Auth::user()->empresa_id : $request->empresa,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'nombre' => $request->nombre_proyecto,
                'direccion' => $request->direccion,
                'descripcion' => $request->descripcion,
                'gastos_generales' => $request->gastos,
                'utilidad' => $request->utilidad,
                'descuento' => $request->descuento,
                'gasto_estimado' => $request->gastosE,
                'estatus' => $request->estatus,
            ]);

            if (isset($request->supervisor) && $request->supervisor != '') {
                UsuarioProyecto::create([
                    'user_id' => $request->supervisor,
                    'proyecto_id' => $proyecto->id,
                    'tipo' => 1,
                ]);
            }
            if (isset($request->cliente) && $request->cliente != '') {
                UsuarioProyecto::create([
                    'user_id' => $request->cliente,
                    'proyecto_id' => $proyecto->id,
                    'tipo' => 2,
                ]);
            }
            DB::commit();
            return redirect()->route('proyectos.index')->with([
                'success' => __('messages.operacionExitosa')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with([
                'error'     => $e->getMessage(),
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
