<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Kontrasepsi;

/**
 * Class KontrasepsiTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class KontrasepsiTransformer extends TransformerAbstract
{
    /**
     * Transform the Kontrasepsi entity.
     *
     * @param \App\Models\Kontrasepsi $model
     *
     * @return array
     */
    public function transform(Kontrasepsi $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
