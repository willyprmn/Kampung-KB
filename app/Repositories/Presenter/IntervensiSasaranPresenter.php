<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\IntervensiSasaranTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class IntervensiSasaranPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class IntervensiSasaranPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new IntervensiSasaranTransformer();
    }
}
