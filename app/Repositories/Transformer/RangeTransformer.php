<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Range;

/**
 * Class RangeTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class RangeTransformer extends TransformerAbstract
{
    /**
     * Transform the Range entity.
     *
     * @param \App\Models\Range $model
     *
     * @return array
     */
    public function transform(Range $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
