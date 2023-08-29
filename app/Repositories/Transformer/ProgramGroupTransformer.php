<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\ProgramGroup;

/**
 * Class ProgramGroupTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class ProgramGroupTransformer extends TransformerAbstract
{
    /**
     * Transform the ProgramGroup entity.
     *
     * @param \App\Models\ProgramGroup $model
     *
     * @return array
     */
    public function transform(ProgramGroup $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
