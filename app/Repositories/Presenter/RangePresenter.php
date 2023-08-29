<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\RangeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RangePresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class RangePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RangeTransformer();
    }
}
