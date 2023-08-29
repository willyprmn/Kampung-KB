<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Frekuensi;

/**
 * Class FrekuensiTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class FrekuensiTransformer extends TransformerAbstract
{
    /**
     * Transform the Frekuensi entity.
     *
     * @param \App\Models\Frekuensi $model
     *
     * @return array
     */
    public function transform(Frekuensi $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
