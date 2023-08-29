<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\IntervensiSasaran;

/**
 * Class IntervensiSasaranTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class IntervensiSasaranTransformer extends TransformerAbstract
{
    /**
     * Transform the IntervensiSasaran entity.
     *
     * @param \App\Models\IntervensiSasaran $model
     *
     * @return array
     */
    public function transform(IntervensiSasaran $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
