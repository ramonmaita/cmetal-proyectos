<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use App\Sector;
use App\Actividad;

class ProyectosMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->tipo != 1 && Auth::user()->ProyectosUsuarios->where('proyecto_id',$request->id)->count() <= 0 ) {
            return abort(403);
        }
        $sector = Sector::find($request->id);
        if (Auth::user()->tipo != 1 && Auth::user()->ProyectosUsuarios->where('proyecto_id',$sector->Proyecto->id)->count() <= 0 ) {
            return abort(403);
        }

        $actividad = Actividad::find($request->id);
        if (Auth::user()->tipo != 1 && Auth::user()->ProyectosUsuarios->where('proyecto_id',$actividad->Sector->Proyecto->id)->count() <= 0 ) {
            return abort(403);
        }
        // return dd($request->id);
        return $next($request);
    }
}
