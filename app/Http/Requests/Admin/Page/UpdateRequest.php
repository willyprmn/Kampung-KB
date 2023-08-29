<?php

namespace App\Http\Requests\Admin\Configuration;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'type' => ['bail', 'required'],
            'title' => ['bail', 'required'],
            'description' => ['bail', 'required'],
        ];
    }


    public function messages()
    {
        return [
            'type' => 'Harus diisi',
            'title' => 'Harus diisi',
            'description' => 'Harus diisi',
        ];
    }
}
