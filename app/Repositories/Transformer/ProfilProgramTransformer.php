<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\ProfilProgram;

/**
 * Class ProfilProgramTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class ProfilProgramTransformer extends TransformerAbstract
{
    /**
     * Transform the ProfilProgram entity.
     *
     * @param \App\Models\ProfilProgram $model
     *
     * @return array
     */
    public function transform(ProfilProgram $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
