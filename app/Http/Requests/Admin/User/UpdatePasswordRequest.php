<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'password_old' => 'required',
            'password' => 'confirmed|min:4',
            'password_confirmation' => 'required|min:4',
        ];
    }

    
    public function messages()
    {
        return [
            'password_old.required' => 'Password Lama harus diisi!',
            'password.required' => 'Password harus diisi!',
            'password.confirmed' => 'Konfirmasi Password harus sama dengan Password!',
            'password.min' => 'Password minimal 4 karakter!',
            'password_confirmation.required' => 'Konfirmasi Password harus diisi!',
            'password_confirmation.min' => 'Konfirmasi Password minimal 4 karakter!',
        ];
    }
}
