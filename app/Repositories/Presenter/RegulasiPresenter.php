<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\RegulasiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RegulasiPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class RegulasiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RegulasiTransformer();
    }
}
