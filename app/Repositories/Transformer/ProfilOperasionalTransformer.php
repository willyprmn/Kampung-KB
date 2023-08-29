<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\ProfilOperasional;

/**
 * Class ProfilOperasionalTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class ProfilOperasionalTransformer extends TransformerAbstract
{
    /**
     * Transform the ProfilOperasional entity.
     *
     * @param \App\Models\ProfilOperasional $model
     *
     * @return array
     */
    public function transform(ProfilOperasional $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
