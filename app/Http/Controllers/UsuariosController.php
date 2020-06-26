<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UsuariosStoreRequest;

use App\User;

use App\Empresa;

use Auth;

use Yajra\DataTables\Facades\DataTables;

use DB;

class UsuariosController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');

        // $this->middleware('log')->only('index');

        $this->middleware('admin', ['only' => ['index','create','store', 'edit', 'destroy']]);

        // $this->middleware('proyectos', ['only' => ['store', 'edit', 'update', 'destroy']]);
    }
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
        if (Auth::user()->isAdmin() == true) {
            $model =  User::where('id','!=',Auth::user()->id)->get();
        }else{
            $model =  User::where('id','!=',Auth::user()->id)->where('empresa_id',Auth::user()->empresa_id)->get();
        }

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
                    case 0:
                        return '<span class="badge badge-pill badge-info">'.__('messages.superAdmin').'</span>';
                        break;
                    case 1:
                        return '<span class="badge badge-pill badge-dark">'.__('messages.admin').'</span>';
                        break;
                    case 2:
                        return '<span class="badge badge-pill badge-primary">'.__('messages.supervisor').'</span>';
                        break;
                    case 4:
                        return '<span class="badge badge-pill badge-primary">'.__('messages.proveedor').'</span>';
                        break;
                    default:
                        return '<span class="badge badge-pill badge-warning">'.__('messages.cliente').'</span>';
                        break;
                }
            })
            ->addColumn('acciones',function ($model)
            {

                return '
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
        $empresas = Empresa::where('estatus',1)->get();
        return view('panel.usuarios.create',['empresas' => $empresas]);
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
                'empresa_id' => ($request->tipo_usuario == 0) ? 0 : $retVal = (Auth::user()->empresa_id == 0) ? $request->empresa :  Auth::user()->empresa_id 
            ]);
            DB::commit();
            return redirect()->route('usuarios.index')->with([
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
        $empresas = Empresa::where('estatus',1)->get();
        if ($usuario) {
            return view('panel.usuarios.edit',['usuario' => $usuario,'empresas' => $empresas]);
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
                ($request->tipo_usuario == '') ?  '' : 'tipo' => $request->tipo_usuario, 
                ($request->estatus == '') ?  '' : 'estatus' => $request->estatus, 
                'empresa_id' => ($request->tipo_usuario == 0 || $request->tipo_usuario == '') ? 0 : $retVal = (Auth::user()->empresa_id == 0) ? $request->empresa :  Auth::user()->empresa_id 
            ]);
            DB::commit();
            if (isset($request->perfil)) {
                return redirect()->back()->with([
                    'success' => __('messages.operacionExitosa')
                ]);  
            }
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

    public function perfil()
    {
        return view('panel.usuarios.perfil');
    }
    public function destroy($id)
    {
        //
    }
}
