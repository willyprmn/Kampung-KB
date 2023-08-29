<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\ProfilProgramTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProfilProgramPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class ProfilProgramPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProfilProgramTransformer();
    }
}
