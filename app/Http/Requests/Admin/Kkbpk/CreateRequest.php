<?php

namespace App\Http\Requests\Admin\Kkbpk;

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
            'programs.*.jumlah' => ['bail', 'required', 'numeric', 'lte:programs.*.max', 'gte:0'],
            'kontrasepsis.*.jumlah' => ['bail', 'required', 'numeric'],
            'kontrasepsis' => ['bail', 'required', 'sum_equal:jumlah_pus,jumlah,non_kontrasepsis,jumlah'],
            'non_kontrasepsis' => ['bail', 'required', 'sum_equal:jumlah_pus,jumlah,kontrasepsis,jumlah'],
            'non_kontrasepsis.*.jumlah' => ['bail', 'required', 'numeric'],
            'pengguna_bpjs' => ['bail', 'required', 'numeric', 'lte:jumlah_jiwa', 'gte:0'],
        ];
    }


    public function messages()
    {
        return [
            'programs.*.jumlah.required' => 'Harus diisi',
            'kontrasepsis.*.jumlah.required' => 'Harus diisi',
            'non_kontrasepsis.*.jumlah.required' => 'Harus diisi',
            'pengguna_bpjs.required' => 'Harus diisi',
            'pengguna_bpjs.gte' => 'Tidak boleh negatif',
            'pengguna_bpjs.lte' => 'Tidak boleh lebih besar dari jumlah jiwa.',
            'programs.*.jumlah.lte' => 'Tidak boleh lebih dari :value',
            'programs.*.jumlah.gte' => 'Tidak boleh negatif',
            'kontrasepsis.sum_equal' => 'Total pengguna kontrasepsi dan non kontrasepsi harus sama dengan total PUS',
            'non_kontrasepsis.sum_equal' => 'Total pengguna kontrasepsi dan non kontrasepsi harus sama dengan total PUS',
        ];
    }
}
