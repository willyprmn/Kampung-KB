<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Kkbpk;

/**
 * Class KkbpkTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class KkbpkTransformer extends TransformerAbstract
{
    /**
     * Transform the Kkbpk entity.
     *
     * @param \App\Models\Kkbpk $model
     *
     * @return array
     */
    public function transform(Kkbpk $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
