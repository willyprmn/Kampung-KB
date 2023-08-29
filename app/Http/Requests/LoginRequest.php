<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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

        if (request()->cookie('debug') === 'true' && config('app.env') !== 'production') return [];

        if (config('captcha.hidden') == true) return [];

        return [
            'g-recaptcha-response' => 'required|captcha',
        ];
    }
}
