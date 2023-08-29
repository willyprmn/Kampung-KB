<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\KkbpkKontrasepsi;

/**
 * Class KkbpkKontrasepsiTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class KkbpkKontrasepsiTransformer extends TransformerAbstract
{
    /**
     * Transform the KkbpkKontrasepsi entity.
     *
     * @param \App\Models\KkbpkKontrasepsi $model
     *
     * @return array
     */
    public function transform(KkbpkKontrasepsi $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
