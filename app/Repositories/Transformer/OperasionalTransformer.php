<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Operasional;

/**
 * Class OperasionalTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class OperasionalTransformer extends TransformerAbstract
{
    /**
     * Transform the Operasional entity.
     *
     * @param \App\Models\Operasional $model
     *
     * @return array
     */
    public function transform(Operasional $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
