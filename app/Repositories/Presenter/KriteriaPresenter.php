<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\KriteriaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class KriteriaPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class KriteriaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new KriteriaTransformer();
    }
}
