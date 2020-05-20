<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActividadStoreRequest extends FormRequest
{
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
            'unidad_id' => 'required|numeric',
            'nombre_actividad' => 'required|min:3',
            'descripcion' => 'required|min:3',
            'metrado' => 'required|numeric',
            'precio' => 'required|numeric',
            'estatus' => 'required|numeric'
        ];
    }
}
