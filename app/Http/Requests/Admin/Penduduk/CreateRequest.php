<?php

namespace App\Http\Requests\Admin\Penduduk;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'penduduk_ranges.*.jumlah' => ['bail', 'required', 'integer'],
            'keluargas.*.jumlah' => ['bail', 'required', 'integer'],
        ];
    }


    public function messages()
    {
        return [
            'penduduk_ranges.*.jumlah.required' => 'Harus diisi',
            'keluargas.*.jumlah.required' => 'Harus diisi',
        ];
    }
}
