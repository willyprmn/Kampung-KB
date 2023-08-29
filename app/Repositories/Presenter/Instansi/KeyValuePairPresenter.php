<?php

namespace App\Repositories\Presenter\Instansi;

use App\Repositories\Transformer\Instansi\KeyValuePairTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class InstansiPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class KeyValuePairPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new KeyValuePairTransformer();
    }
}
