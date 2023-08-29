<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Sasaran;

/**
 * Class SasaranTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class SasaranTransformer extends TransformerAbstract
{
    /**
     * Transform the Sasaran entity.
     *
     * @param \App\Models\Sasaran $model
     *
     * @return array
     */
    public function transform(Sasaran $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
