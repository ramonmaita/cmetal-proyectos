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
            return view('panel.proyectos.show',['proyecto' => $proyecto]);
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
