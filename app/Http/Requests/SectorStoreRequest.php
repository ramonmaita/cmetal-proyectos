<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectorStoreRequest extends FormRequest
{
    // protected $redirectRoute = 'sectores.create';
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
            'nombre_sector' => 'required|min:3',
            'descripcion' => 'required|min:3',
        ];
    }
}
