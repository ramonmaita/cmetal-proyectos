<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('login', 'LoginController@login')->name('iniciar-sesion');
Route::get('logout', 'LoginController@logout')->name('logout');


Route::get('recuperar-contrasena', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('enviar-email-recuperacion', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

Route::post('resetear-contrasena', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('resetear-contrasena/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

Route::group(['prefix' => 'panel', 'middleware' => 'auth'], function() {
	Route::get('lenguaje/{lenguaje}', function($lenguaje) {
	    Session::put('locale', $lenguaje);
        return redirect()->back();
	})->name('lenguaje');

    Route::get('/', function() {
        if (Auth::user()->tipo != 1) {
            return redirect()->route('proyectos.index');
        }
        $proyectos = \App\Proyecto::count();
        $sectores = \App\Sector::count();
        $actividades = \App\Actividad::count();
        $metrados = \App\Metrado::count();
        return view('panel.index',['proyectos' => $proyectos,'sectores' => $sectores, 'metrados' => $metrados,'actividades' => $actividades]);
    })->name('panel.index');

    Route::group(['prefix' => 'proyectos', 'middleware' => 'proyectos'], function() {
        Route::get('{id}/pdf', 'ProyectosController@pdf')->name('proyectos.pdf');
        Route::get('{id}/sectores','SectoresController@index')->name('sectores');
        Route::get('{id}/sectores/create','SectoresController@create')->name('sectores.create');

        Route::get('sector/{id}/edit', 'SectoresController@edit')->name('sectores.edit');
        Route::put('actualizar/{id}', 'SectoresController@update')->name('sectores.update');
        Route::post('guardar-sector/{id}', 'SectoresController@store')->name('sectores.store');

        Route::post('nuevo-gasto/{id}', 'GastoController@store')->name('gastos.store');
        Route::post('nueva-factura/{id}', 'FacturaController@store')->name('facturas.store');
        Route::post('nueva-factura/{id}', 'FacturaController@store')->name('facturas.store');
        Route::post('nuevo-deposito/{id}', 'DepositoController@store')->name('depositos.store');

        Route::prefix('sectores')->as('sectores.')->group(function () {
            Route::get('{id}/actividades', 'ActividadesController@index')->name('actividades.index');
            Route::get('{id}/actividades/create', 'ActividadesController@create')->name('actividades.create');
            Route::post('guardar-actividad/{id}', 'ActividadesController@store')->name('actividades.store');
            Route::get('actividad/{id}/edit', 'ActividadesController@edit')->name('actividades.edit');
            Route::post('actualizar-actividad/{id}', 'ActividadesController@update')->name('actividades.update');
        });
    });


    Route::prefix('usuarios')->as('usuarios.')->group(function () {
        Route::get('perfil', 'UsuariosController@perfil')->name('perfil');
    });

    Route::post('guardar-reporte/{id}', 'ReportesController@store')->name('reportes.store');


    

    Route::resource('actividades', 'ActividadesController');
    Route::resource('comentarios', 'ComentarioController');
    Route::resource('proyectos', 'ProyectosController');
    Route::resource('metrados', 'MetradosController')->middleware('admin');
    Route::resource('usuarios', 'UsuariosController');

});

