<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UsuariosStoreRequest;

use App\User;

use Auth;

use Yajra\DataTables\Facades\DataTables;

use DB;

class UsuariosController extends Controller
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
        
        return view('panel.usuarios.index');
    }

    public function getData()
    {
        $model =  User::where('id','!=',Auth::user()->id)->get();

        return DataTables::of($model)
            ->editColumn('estatus',function ($model)
            {
                switch ($model->estatus) {

                    case 1:
                        return '<span class="badge badge-pill badge-info">'.__('messages.activo').'</span>';
                        break;
                    case 2:
                        return '<span class="badge badge-pill badge-warning">'.__('messages.suspendido').'</span>';
                        break;
                    default:
                        return '<span class="badge badge-pill badge-primary">'.__('messages.espera').'</span>';
                        break;
                }
            })
            ->editColumn('tipo',function ($model)
            {
                switch ($model->tipo) {
                    case 1:
                        return '<span class="badge badge-pill badge-dark">'.__('messages.admin').'</span>';
                        break;
                    case 2:
                        return '<span class="badge badge-pill badge-primary">'.__('messages.supervisor').'</span>';
                        break;
                    default:
                        return '<span class="badge badge-pill badge-warning">'.__('messages.cliente').'</span>';
                        break;
                }
            })
            ->addColumn('acciones',function ($model)
            {

                return '
                <a href="'.route('sectores',['id' => $model->id]).'" class="btn btn-icon   btn-light-cmetal "><i class="bx bxs-plus-circle"></i></a>
                <a href="'.route('proyectos.show',['id' => $model->id]).'" class="btn  btn-icon btn-cmetal "><i class="bx bxs-show"></i></a>
                <a href="'.route('usuarios.edit',['id' => $model->id]).'" class="btn  btn-icon btn-dark "><i class="bx bxs-pencil"></i></a>
            
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
        return view('panel.usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuariosStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            User::create([
                'nombre' => $request->nombres,
                'apellido' => $request->apellidos,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'tipo' => $request->tipo_usuario,
                'estatus' => $request->estatus,
            ]);
            DB::commit();
            return redirect()->route('usuarios.index')->with([
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
        $usuario = User::find($id);
        if ($usuario) {
            return view('panel.usuarios.edit',['usuario' => $usuario]);
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
    public function update(UsuariosStoreRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            User::find($id)->update([
                'nombre' => $request->nombres,
                'apellido' => $request->apellidos,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'tipo' => $request->tipo_usuario,
                'estatus' => $request->estatus,
            ]);
            DB::commit();
            return redirect()->route('usuarios.index')->with([
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
