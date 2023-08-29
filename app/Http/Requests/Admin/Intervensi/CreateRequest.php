<?php

namespace App\Http\Requests\Admin\Intervensi;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

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
            'inpres_kegiatan_id' => ['sometimes', 'nullable'],
            'jenis_post_id' => ['bail', 'required'],
            'judul' => ['bail' , 'required'],
            'tanggal' => ['bail', 'required', 'date'],
            'tempat' => ['bail', 'required'],
            'deskripsi' => ['bail', 'required'],
            'kategori_id' => ['bail', 'required'],
            'sasarans' => ['bail', 'array'],
            'sasaran_lainnya' => ['bail', 'array', 'required_without:sasarans'],
            'instansis' => ['bail', 'array'],
            'instansi_lainnya' => ['bail', 'required_without:instansis'],
            'intervensi_gambars' => ['bail', 'nullable', 'max:5'],
            'intervensi_gambars.*.caption' => ['bail', 'required_if:jenis_post_id,2'],
            'intervensi_gambars.*.intervensi_gambar_type_id' => ['bail', 'required_with:intervensi_gambars'],
        ];
    }
}
