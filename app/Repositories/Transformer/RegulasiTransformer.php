<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Regulasi;

/**
 * Class RegulasiTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class RegulasiTransformer extends TransformerAbstract
{
    /**
     * Transform the Regulasi entity.
     *
     * @param \App\Models\Regulasi $model
     *
     * @return array
     */
    public function transform(Regulasi $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
