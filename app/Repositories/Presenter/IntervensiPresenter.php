<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\IntervensiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class IntervensiPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class IntervensiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new IntervensiTransformer();
    }
}
