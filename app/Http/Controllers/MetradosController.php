<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\MetradoStoreRequest;

use Yajra\DataTables\Facades\DataTables;

use App\Metrado;

use DB;

class MetradosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            return $this->getData();
        }
        return view('panel.metrados.index');
    }

    public function getData()
    {
        $model =  Metrado::where('estatus',1)->get();

        return DataTables::of($model)
            ->editColumn('estatus',function($model){
                if ($model->estatus == 1) {
                    return '<span class="badge badge-pill badge-success">'.__('messages.activo').'</span>';
                } else {
                    return '<span class="badge badge-pill badge-danger">'.__('messages.inactivo').'</span>';
                }
                
            })
            ->addColumn('acciones',function ($model)
            {

                return '
                <a href="'.route('metrados.edit',['id' => $model->id]).'" class="btn btn-icon   btn-light-cmetal redirect" data-uri="'.route('metrados.edit',['id' => $model->id]).'"><i class="bx bxs-pencil"></i></a>
            
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
        return view('panel.metrados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MetradoStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            Metrado::create([
                'nombre' => $request->nombre_metrado,
                'precio' => $request->precio,
                'estatus' => $request->estatus,
            ]);
            DB::commit();
            return redirect()->route('metrados.index')->with([
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
        $metrado = Metrado::find($id);
        if ($metrado) {
            return view('panel.metrados.edit',['metrado' => $metrado]);
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
    public function update(MetradoStoreRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $metrado = Metrado::find($id);
            $metrado->update([
                'nombre' => $request->nombre_metrado,
                'precio' => $request->precio,
                'estatus' => $request->estatus,
            ]);
            DB::commit();
            return redirect()->route('metrados.index')->with([
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
