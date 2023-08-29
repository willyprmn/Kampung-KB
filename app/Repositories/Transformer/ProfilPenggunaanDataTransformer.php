<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\ProfilPenggunaanData;

/**
 * Class ProfilPenggunaanDataTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class ProfilPenggunaanDataTransformer extends TransformerAbstract
{
    /**
     * Transform the ProfilPenggunaanData entity.
     *
     * @param \App\Models\ProfilPenggunaanData $model
     *
     * @return array
     */
    public function transform(ProfilPenggunaanData $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
