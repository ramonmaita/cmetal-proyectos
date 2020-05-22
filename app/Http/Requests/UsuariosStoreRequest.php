<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosStoreRequest extends FormRequest
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
            'nombres' => 'required|min:5',
            'apellidos' => 'required|min:5',
            'email' => 'required|min:5|unique:users,email,'.$this->id,
            'password' => 'required|min:5',
            'estatus' => 'required',
            'tipo_usuario' => 'required',
        ];
    }
}
