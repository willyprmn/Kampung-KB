<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\NonKontrasepsiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class NonKontrasepsiPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class NonKontrasepsiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new NonKontrasepsiTransformer();
    }
}
