<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\PenggunaanData;

/**
 * Class PenggunaanDataTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class PenggunaanDataTransformer extends TransformerAbstract
{
    /**
     * Transform the PenggunaanData entity.
     *
     * @param \App\Models\PenggunaanData $model
     *
     * @return array
     */
    public function transform(PenggunaanData $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
