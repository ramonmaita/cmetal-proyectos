<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetradoStoreRequest extends FormRequest
{
    protected $redirectRoute = 'metrados.create';
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
            'nombre_metrado' => 'required',
            'precio' => 'required|numeric',
            'estatus' => 'required'
        ];
    }
}
