<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\ProfilSumberDanaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProfilSumberDanaPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class ProfilSumberDanaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProfilSumberDanaTransformer();
    }
}
