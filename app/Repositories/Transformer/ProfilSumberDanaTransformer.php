<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\ProfilSumberDana;

/**
 * Class ProfilSumberDanaTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class ProfilSumberDanaTransformer extends TransformerAbstract
{
    /**
     * Transform the ProfilSumberDana entity.
     *
     * @param \App\Models\ProfilSumberDana $model
     *
     * @return array
     */
    public function transform(ProfilSumberDana $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
