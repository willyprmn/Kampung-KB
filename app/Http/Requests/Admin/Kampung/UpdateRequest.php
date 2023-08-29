<?php

namespace App\Http\Requests\Admin\Kampung;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            'nama' => ['bail', 'required'],
            'provinsi_id' => ['bail', 'required'],
            'kabupaten_id' => ['bail', 'required'],
            'kecamatan_id' => ['bail', 'required'],
            'desa_id' => [
                'bail',
                'required',
                // 'unique:new_kampung_kb,desa_id'
                Rule::unique('new_kampung_kb')
                    ->where(function ($kampung) {
                        $kampung->where('is_active', true);
                    })
                    ->ignore(request()->route('kampung')),
            ],
            'tanggal_pencanangan' => ['bail', 'required', 'date', 'after_or_equal:2016-01-01'],
            'gambaran_umum' => ['bail', 'required'],
        ];
    }


    public function prepareForValidation()
    {

        if (!empty($this->tanggal_pencanangan))
        $this->merge([
            'tanggal_pencanangan' => Carbon::createFromFormat('d / m / Y', $this->tanggal_pencanangan)
        ]);
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama kampung harus diisi',
            'tanggal_pencanangan.after_or_equal' => 'Tanggal pencanangan tidak boleh kurang dari tahun 2016',
            'provinsi_id.required' => 'Provinsi harus dipilih',
            'kabupaten_id.required' => 'Kabupaten harus dipilih',
            'kecamatan_id.required' => 'Kecamatan harus dipilih',
            'desa_id.required' => 'Desa harus dipilih',
            'gambaran_umum.required' => 'Gambaran umum harus diisi',
        ];
    }
}
