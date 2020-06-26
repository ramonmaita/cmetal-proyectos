<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empresa;

use DB;

use Yajra\DataTables\Facades\DataTables;

use Auth;

class EmpresaController extends Controller
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
        return view('panel.empresas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        $model =  Empresa::where('estatus',1)->get();

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
                    return '
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="'.route('empresas.show',['id' => $model->id]).'" class="btn  btn-icon btn-cmetal "><i class="bx bxs-show"></i></a>
                        <a href="'.route('empresas.edit',['id' => $model->id]).'" class="btn btn-icon  btn-light-cmetal"><i class="bx bxs-pencil"></i></a>
                
                    </div>
                    ';
                // if (Auth::user()->tipo == 1 ) {
                // }else{
                //      return '
                //     <a href="'.route('proyectos.show',['id' => $model->id]).'" class="btn  btn-icon btn-cmetal "><i class="bx bxs-show"></i></a>
                
                //     ';
                // }
            }) 
            ->rawColumns(['action'])
            ->escapeColumns([])
            ->toJson();
    }
    public function create()
    {
        return view('panel.empresas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            Empresa::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'sector' => $request->sector,
                'estatus' => $request->estatus
            ]);
            DB::commit();

             return redirect()->route('empresas.index')->with([
                'success' => __('messages.operacionExitosa')
            ]);
        } catch (Exception $e) {
            DB::rollback();
             return redirect()->back()->with([
                'error'     => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        if ($empresa) {
            return view('panel.empresas.show',['empresa' => $empresa]);
        } else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
        if ($empresa) {
            return view('panel.empresas.edit',['empresa' => $empresa]);
        } else {
            return abort(404);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresa $empresa)
    {
        try {
            DB::beginTransaction();
            $empresa->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'sector' => $request->sector,
                'estatus' => $request->estatus
            ]);
            DB::commit();

             return redirect()->route('empresas.index')->with([
                'success' => __('messages.operacionExitosa')
            ]);
        } catch (Exception $e) {
            DB::rollback();
             return redirect()->back()->with([
                'error'     => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        //
    }
}
