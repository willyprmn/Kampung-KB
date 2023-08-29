<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\SumberDanaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SumberDanaPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class SumberDanaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SumberDanaTransformer();
    }
}
