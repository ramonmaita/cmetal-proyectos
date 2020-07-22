<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoStoreRequest extends FormRequest
{
    protected $redirectRoute = 'proyectos.create';
    protected $dontFlash = [];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'nombre_proyecto' => 'required|min:3',
            'direccion' => 'required|min:3',
            'descripcion' => 'required|min:3',
            'gastos' => 'required|numeric',
            'utilidad' => 'required|numeric',
            'descuento' => 'required|numeric',
            'gastosE' => 'required|numeric',
            'estatus' => 'required|numeric',
        ];
    }
    
    public function attributes()
    {
        return [
            // 'nombre_proyecto' => __('messages.project'),
        ];
    }

    
    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 422);
        }
 
        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }
}
