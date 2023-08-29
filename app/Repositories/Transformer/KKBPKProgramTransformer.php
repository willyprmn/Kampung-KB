<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\KkbpkProgram;

/**
 * Class KkbpkProgramTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class KkbpkProgramTransformer extends TransformerAbstract
{
    /**
     * Transform the KkbpkProgram entity.
     *
     * @param \App\Models\KkbpkProgram $model
     *
     * @return array
     */
    public function transform(KkbpkProgram $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
