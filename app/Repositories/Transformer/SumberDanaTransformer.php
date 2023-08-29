<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\SumberDana;

/**
 * Class SumberDanaTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class SumberDanaTransformer extends TransformerAbstract
{
    /**
     * Transform the SumberDana entity.
     *
     * @param \App\Models\SumberDana $model
     *
     * @return array
     */
    public function transform(SumberDana $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
