<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Intervensi;

/**
 * Class IntervensiTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class IntervensiTransformer extends TransformerAbstract
{
    /**
     * Transform the Intervensi entity.
     *
     * @param \App\Models\Intervensi $model
     *
     * @return array
     */
    public function transform(Intervensi $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
