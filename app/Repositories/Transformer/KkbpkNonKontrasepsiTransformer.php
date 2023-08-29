<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\KkbpkNonKontrasepsi;

/**
 * Class KkbpkNonKontrasepsiTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class KkbpkNonKontrasepsiTransformer extends TransformerAbstract
{
    /**
     * Transform the KkbpkNonKontrasepsi entity.
     *
     * @param \App\Models\KkbpkNonKontrasepsi $model
     *
     * @return array
     */
    public function transform(KkbpkNonKontrasepsi $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
