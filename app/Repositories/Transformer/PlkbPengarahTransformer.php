<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\PlkbPengarah;

/**
 * Class PlkbPengarahTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class PlkbPengarahTransformer extends TransformerAbstract
{
    /**
     * Transform the PlkbPengarah entity.
     *
     * @param \App\Models\PlkbPengarah $model
     *
     * @return array
     */
    public function transform(PlkbPengarah $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
