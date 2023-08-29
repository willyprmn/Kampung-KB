<?php

namespace App\Repositories\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\JenisPost;

/**
 * Class JenisPostTransformer.
 *
 * @package namespace App\Repositories\Transformer;
 */
class JenisPostTransformer extends TransformerAbstract
{
    /**
     * Transform the JenisPost entity.
     *
     * @param \App\Models\JenisPost $model
     *
     * @return array
     */
    public function transform(JenisPost $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
