<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\ProfilOperasionalTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProfilOperasionalPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class ProfilOperasionalPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProfilOperasionalTransformer();
    }
}
