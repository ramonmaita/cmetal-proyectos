<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Validator;

use Auth;

use Validator;

use App\User;

use Session;

use Illuminate\Support\Str;


class LoginController extends Controller
{
    public function login(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email|min:3|max:191',
            'password' => 'required',
        ],[
            'email.required' => 'El campo correo electronico es requerido.',
            'email.min' => 'El campo correo electronico debe contener al menos :min caracteres.',
            'password.required' => 'El campo contraseña es requerido.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
    	if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    		if (Auth::user()->estatus == 1) {
                if (Auth::user()->tipo == 1) {
                    return redirect()->intended('/panel');
                }else{
                    return redirect()->intended('/panel/proyectos');
                }
            } else {
                Auth::logout();
                return redirect('/')->with('error','Su cuenta no se encuentra activa, pongase a en contacto con el administrador del sitio.');
            }       
    	}else{
    		return redirect()->back()->with('error','Correo o contraseña incorrecta.');
    	}
    }

    public function logout(Request $request)
    {
    	Auth::logout();
        $request->session()->forget('locale');
    	return redirect('/');
    }
}
