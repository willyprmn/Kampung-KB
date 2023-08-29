<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\ProfilPenggunaanDataTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProfilPenggunaanDataPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class ProfilPenggunaanDataPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProfilPenggunaanDataTransformer();
    }
}
