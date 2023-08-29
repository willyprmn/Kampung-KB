<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\KeluargaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class KeluargaPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class KeluargaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new KeluargaTransformer();
    }
}
