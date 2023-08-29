<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\SasaranTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SasaranPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class SasaranPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SasaranTransformer();
    }
}
