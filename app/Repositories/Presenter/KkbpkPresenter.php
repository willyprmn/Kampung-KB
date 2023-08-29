<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\KkbpkTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class KkbpkPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class KkbpkPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new KkbpkTransformer();
    }
}
