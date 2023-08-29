<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Kriteria;

/**
 * Class KriteriaTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class KriteriaTransformer extends TransformerAbstract
{
    /**
     * Transform the Kriteria entity.
     *
     * @param \App\Models\Kriteria $model
     *
     * @return array
     */
    public function transform(Kriteria $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
