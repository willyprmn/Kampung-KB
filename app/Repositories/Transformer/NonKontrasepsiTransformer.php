<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\NonKontrasepsi;

/**
 * Class NonKontrasepsiTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class NonKontrasepsiTransformer extends TransformerAbstract
{
    /**
     * Transform the NonKontrasepsi entity.
     *
     * @param \App\Models\NonKontrasepsi $model
     *
     * @return array
     */
    public function transform(NonKontrasepsi $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
