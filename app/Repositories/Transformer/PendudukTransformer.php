<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Penduduk;

/**
 * Class PendudukTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class PendudukTransformer extends TransformerAbstract
{
    /**
     * Transform the Penduduk entity.
     *
     * @param \App\Models\Penduduk $model
     *
     * @return array
     */
    public function transform(Penduduk $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
