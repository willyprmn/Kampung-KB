<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\Contract\ProgramRepository;
use App\Repositories\Criteria\Program\PoktanCriteria as ProgramPoktanKriteria;

class ProfilProgramRule implements Rule
{

    protected $programRepository;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(ProgramRepository $programRepository)
    {
        $this->programRepository = $programRepository;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $input = array_keys($value);

        $this->programRepository->pushCriteria(ProgramPoktanKriteria::class);
        $programs = $this->programRepository->get()->pluck('id')->toArray();

        $diff = array_diff($programs, $input);

        return empty($diff);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Seluruh program kepemilikan harus diisi.';
    }
}
