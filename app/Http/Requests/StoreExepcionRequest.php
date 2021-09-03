<?php

namespace App\Http\Requests;

use App\Models\Excepcion;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

class StoreExepcionRequest extends FormRequest
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
            'usuario_id' => 'required|exists:usuarios,id',
            'fecha' => 'date',
            'laborable' => 'required|boolean',
            'nota' => 'required',
        ];
    }
}
