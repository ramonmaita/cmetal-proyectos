<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ProyectoStoreRequest;

use Yajra\DataTables\Facades\DataTables;

use App\Proyecto;

use DB;

class ProyectosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return $this->getData();
        }
        return view('panel.proyectos.index');
    }

    public function getData()
    {
        $model =  Proyecto::where('estatus',1)->get();

        return DataTables::of($model)
            ->editColumn('estatus',function ($model)
            {
                switch ($model->estatus) {
                    case 0:
                        return '<span class="badge badge-pill badge-success">'.__('messages.finalizado').'</span>';
                        break;
                    case 1:
                        return '<span class="badge badge-pill badge-info">'.__('messages.activo').'</span>';
                        break;
                    case 2:
                        return '<span class="badge badge-pill badge-warning">'.__('messages.suspendido').'</span>';
                        break;
                    case 1:
                        return '<span class="badge badge-pill badge-danger">'.__('messages.cancelado').'</span>';
                        break;
                    default:
                        return '<span class="badge badge-pill badge-primary">'.__('messages.espera').'</span>';
                        break;
                }
            })
            ->addColumn('acciones',function ($model)
            {

                return '
                <a href="'.route('sectores',['id' => $model->id]).'" class="btn btn-icon   btn-light-cmetal "><i class="bx bxs-plus-circle"></i></a>
                <a href="'.route('proyectos.show',['id' => $model->id]).'" class="btn  btn-icon btn-cmetal "><i class="bx bxs-show"></i></a>
                <a href="'.route('proyectos.edit',['id' => $model->id]).'" class="btn  btn-icon btn-dark "><i class="bx bxs-pencil"></i></a>
            
                ';
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
        return view('panel.proyectos.create');
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
            Proyecto::create([
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'nombre' => $request->nombre_proyecto,
                'direccion' => $request->direccion,
                'descripcion' => $request->descripcion,
                'estatus' => $request->estatus,
            ]);
            DB::commit();
            return redirect()->route('proyectos.index')->with([
                'success' => __('messages.operacionExitosa')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with([
                'errorm'     => $e->getMessage(),
                'error' => true
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
            return view('panel.proyectos.edit',['proyecto' => $proyecto]);
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
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'nombre' => $request->nombre_proyecto,
                'direccion' => $request->direccion,
                'descripcion' => $request->descripcion,
                'estatus' => $request->estatus,
            ]);
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
