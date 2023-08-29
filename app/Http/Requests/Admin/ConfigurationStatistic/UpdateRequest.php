<?php

namespace App\Http\Requests\Admin\ConfigurationStatistic;

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
            'statistiks.*.title' => ['bail', 'required'],
            'statistiks.*.description' => ['bail', 'required'],
            'statistiks.*.tooltip' => ['bail', 'required'],
        ];
    }

    public function messages()
    {
        return [
            'statistiks.*.title' => 'Harus diisi',
            'statistiks.*.description' => 'Harus diisi',
            'statistiks.*.tooltip' => 'Harus diisi',
        ];
    }
}
