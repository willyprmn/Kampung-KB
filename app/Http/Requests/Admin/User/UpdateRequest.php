<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

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

        $uniqueRegion = 'sometimes';
        $table = User::getTableName();

        if (
            $this->is_active &&
            !is_null($this->provinsi_id)
        ) {
            $uniqueRegion = Rule::unique($table)
                ->where(function ($query) {
                    $query
                        ->where('provinsi_id', $this->provinsi_id)
                        ->where('kabupaten_id', $this->kabupaten_id)
                        ->where('kecamatan_id', $this->kecamatan_id)
                        ->where('desa_id', $this->desa_id)
                        ->where('is_active', $this->is_active);

                })
                ->ignore($this->user)
                ;
        }

        return [
            'email' => ['bail', 'required', "unique:$table,email,{$this->user}"],
            'phone' => ['bail', 'required', 'regex:/^[0-9\+\(\ \)\-]/i'],
            'roles' => ['bail', 'required', 'array', 'min:1'],
            'provinsi_id' => [
                'bail',
                'required_with:kabupaten_id,kecamatan_id,desa_id',
                $uniqueRegion
            ],
            'kabupaten_id' => [
                'bail',
                'required_with:kecamatan_id,desa_id',
                $uniqueRegion
            ],
            'kecamatan_id' => [
                'bail',
                'required_with:desa_id',
                $uniqueRegion
            ],
            'desa_id' => [
                'bail',
                'nullable',
                $uniqueRegion
            ],
            'is_active' => ['bail', 'boolean', 'nullable'],
        ];
    }


    public function prepareForValidation()
    {

        $isActive = filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN);
        $this->merge(['is_active' => true]);
        if (!$isActive) {
            $this->merge(['is_active' => null]);
        }

        if (empty($this->provinsi_id)) {
            $this->merge(['provinsi_id' => null]);
        }

        if (empty($this->kabupaten_id)) {
            $this->merge(['kabupaten_id' => null]);
        }

        if (empty($this->kecamatan_id)) {
            $this->merge(['kecamatan_id' => null]);
        }

        if (empty($this->desa_id)) {
            $this->merge(['desa_id' => null]);
        }
    }

    public function messages()
    {
        $messages = [
            'email.required' => 'Email/Username harus diisi!',
            'email.unique' => 'Email/Username sudah digunakan user lain',
            'phone.required' => 'No. Telpon harus diisi',
            'phone.regex' => 'No telpon harus diisi dengan format yang benar.',
            'phone.unique' => 'No. Telpon sudah digunakan user lain',
        ];

        $holder = User::query()
            ->where(function ($query) {
                $query->where('provinsi_id', $this->provinsi_id)
                    ->where('kabupaten_id', $this->kabupaten_id)
                    ->where('kecamatan_id', $this->kecamatan_id)
                    ->where('desa_id', $this->desa_id)
                    ->where('is_active', $this->is_active)
                    ;
            })
            ->where('id', '<>' ,$this->user)
            ->first()->email ?? null;
            ;

        if (!empty($holder)) {
            $messages = array_merge($messages, [
                "provinsi_id.unique" => 'Admin provinsi ini sudah diisi oleh ' . $holder,
                "kabupaten_id.unique" => 'Admin kabupaten ini sudah diisi oleh ' . $holder,
                "kecamatan_id.unique" => 'Admin kecamatan ini sudah diisi oleh ' . $holder,
                "desa_id.unique" => 'Admin desa ini sudah diisi oleh ' . $holder,
            ]);
        }

        return $messages;
    }
}
