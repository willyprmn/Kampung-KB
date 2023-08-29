<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\PenggunaanDataTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PenggunaanDataPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class PenggunaanDataPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PenggunaanDataTransformer();
    }
}
