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
    // return view('panel.index');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('login', 'LoginController@login')->name('iniciar-sesion');
Route::get('logout', 'LoginController@logout')->name('logout');


Route::group(['prefix' => 'panel', 'middleware' => 'auth'], function() {
	Route::get('lenguaje/{lenguaje}', function($lenguaje) {
	    Session::put('locale', $lenguaje);
        return redirect()->back();
	})->name('lenguaje');

    Route::get('/', function() {
        $proyectos = \App\Proyecto::count();
        $sectores = \App\Sector::count();
        $actividades = \App\Actividad::count();
        $metrados = \App\Metrado::count();
        return view('panel.index',['proyectos' => $proyectos,'sectores' => $sectores, 'metrados' => $metrados,'actividades' => $actividades]);
    })->name('panel.index');

    Route::group(['prefix' => 'proyectos'], function() {
        Route::get('{id}/sectores','SectoresController@index')->name('sectores');
        Route::get('{id}/sectores/create','SectoresController@create')->name('sectores.create');
        Route::get('sector/{id}/edit', 'SectoresController@edit')->name('sectores.edit');
        Route::put('actualizar/{id}', 'SectoresController@update')->name('sectores.update');
        Route::post('guardar-sector/{id}', 'SectoresController@store')->name('sectores.store');

        Route::prefix('sectores')->as('sectores.')->group(function () {
            Route::get('{id}/actividades', 'ActividadesController@index')->name('actividades.index');
            Route::get('{id}/actividades/create', 'ActividadesController@create')->name('actividades.create');
            Route::post('guardar-actividad/{id}', 'ActividadesController@store')->name('actividades.store');
            Route::get('actividad/{id}/edit', 'SectoresController@edit')->name('actividades.edit');
        });
    });

    Route::resource('actividades', 'ActividadesController');
    Route::resource('proyectos', 'ProyectosController');

    Route::prefix('metrados')->as('metrados.')->group(function () {

    });

    Route::resource('metrados', 'MetradosController');
});


// Route::prefix('panel/admin')
//     ->namespace('Admin')
//     ->middleware(['auth:admin'])
//     ->as('panel.admin.')
//     ->group(function () {

//         Route::get('/inicio', 'PanelController@index')->name('index');

//         Route::prefix('perfil')->group(function (){
//             Route::get('/', 'PerfilController@perfil')->name('perfil.perfil');
//             Route::post('actualizar-contrasena', 'PerfilController@cambiarContrasena')->name('perfil.actualizar-contrasena');
//             Route::post('actualizar-perfil', 'PerfilController@actualizarDatos')->name('perfil.actualizar-perfil');
//         });

//         Route::prefix('bancos')->as('bancos.')->group(function () {
//             Route::get('/', 'BancosController@index')->name('index');
//             Route::post('/', 'BancosController@store')->name('store');
//             Route::get('crear', 'BancosController@create')->name('crear');
//             Route::get('{id}/editar', 'BancosController@edit')->name('editar');
//             Route::put('/{id}', 'BancosController@update')->name('update');
//             Route::delete('/{id}', 'BancosController@destroy')->name('destroy');
//             Route::get('data', 'BancosController@data')->name('data');
//         });

// });
