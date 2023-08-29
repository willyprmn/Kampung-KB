<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Keluarga;

/**
 * Class KeluargaTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class KeluargaTransformer extends TransformerAbstract
{
    /**
     * Transform the Keluarga entity.
     *
     * @param \App\Models\Keluarga $model
     *
     * @return array
     */
    public function transform(Keluarga $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
