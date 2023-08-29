<?php

namespace App\Http\Requests\Admin\Profil;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ProfilProgramRule;

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
    public function rules(ProfilProgramRule $profilProgramRule)
    {
        return [
            # Poktan
            'programs.*.program_flag' => ['bail', 'string', 'in:true,false', 'required'],

            # Pokja
            'pokja_pengurusan_flag' => ['bail', 'required', 'string', 'in:true,false'],
            'pokja_sk_flag' => ['bail', 'required_if:pokja_pengurusan_flag,true'],
            'pokja_jumlah' => ['bail', 'required_if:pokja_pengurusan_flag,true'],

            # Pokja pelatih
            'pokja_pelatihan_flag' => ['bail', 'string', 'in:true,false', 'required_if:pokja_pengurusan_flag,true'],
            'pokja_pelatihan_desc' => ['bail', 'required_if:pokja_pelatihan_flag,true'],
            'pokja_jumlah_terlatih' => ['bail', 'required_if:pokja_pelatihan_flag,true'],

            # Plkb
            'plkb_pendamping_flag' => ['bail', 'string', 'in:true,false', 'required'],
            'plkb_nip' => ['bail', 'required_if:plkb_pendamping_flag,true'],
            'plkb_pengarah_id' => ['bail', 'required_if:plkb_pendamping_flag,false'],
            'plkb_pengarah_lainnya' => [
                'bail',
                function ($attribute, $value, $fail) {

                    switch (true) {
                        case (bool) $this->plkb_pendamping_flag === true: break;
                        case (int) $this->plkb_pengarah_id !== 9: break;
                        case !empty($value): break;
                        default:
                            $fail($attribute.' is invalid.');
                    }
                },
            ],
            'plkb_nama' => ['bail', 'required'],
            'plkb_kontak' => ['bail', 'required'],

            # Regulasi
            'regulasi_flag' => ['bail', 'required', 'string', 'in:true,false'],
            'regulasis' => ['bail', 'array', 'required_if:regulasi_flag,true'],

            # Pengunaan data
            'rencana_kerja_masyarakat_flag' => ['bail', 'string', 'in:true,false', 'required'],
            'penggunaan_data_flag' => ['bail', 'string', 'in:true,false', 'required_if:rencana_kerja_masyarakat_flag,true'],
            'penggunaan_datas' => ['array', 'required_if:penggunaan_data_flag,true'],

            # Operasional
            'operasionals.*.operasional_flag' => ['bail', 'string', 'in:true,false', 'required'],
            'operasionals.*.frekuensi_id' => ['bail', 'required_if:operasionals.*.operasional_flag,true'],
            'operasionals.*.frekuensi_lainnya' => ['bail', 'required_if:operasionals.*.frekuensi_id,6'],

        ];
    }


    public function prepareForValidation()
    {

        if (!filter_var($this->regulasi_flag, FILTER_VALIDATE_BOOLEAN)) {
            $this->merge([
                'regulasis' => [],
            ]);
        }

        if (!filter_var($this->pokja_pengurusan_flag, FILTER_VALIDATE_BOOLEAN)) {
            $this->merge([
                'pokja_sk_flag' => 'false',
                'pokja_pelatihan_flag' => 'false',
                'pokja_pelatihan_desc' => null,
                'pokja_jumlah' => 0,
                'pokja_jumlah_terlatih' => 0,
            ]);
        }

        if (filter_var($this->plkb_pendamping_flag, FILTER_VALIDATE_BOOLEAN)) {
            $this->merge([
                'plkb_pengarah_id' => null,
                'plkb_pengarah_lainnya' => null,
            ]);
        } else {
            $this->merge([
                'plkb_nip' => null,
            ]);        }


        if (!filter_var($this->rencana_kerja_masyarakat_flag, FILTER_VALIDATE_BOOLEAN)) {
            $this->merge([
                'perggunaan_data_flag' => 'false',
                'penggunaan_datas' => [],
            ]);
        }

        $this->merge([
            'operasionals' => collect($this->operasionals)->mapWithKeys(function ($item, $key) {

                $operasional = $item;
                if ($operasional['frekuensi_id'] === "-1") {
                    $operasional['frekuensi_id'] = null;
                }

                return [$key => $operasional];
            })
            ->toArray()
        ]);
    }


    public function messages()
    {
        return [
            'programs.*.program_flag.required' => 'Harus diisi',
            'pokja_pengurusan_flag.required' => 'Pokja harus dipilih',
            'penggunaan_datas.required_if' => 'Apabila inputan "Penggunaan data dalam perencanaan dan evaluasi kegiatan" dipilih, harus pilih minimal satu pilihan yang diberikan'
        ];
    }
}
