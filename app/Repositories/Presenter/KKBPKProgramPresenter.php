<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\KkbpkProgramTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class KkbpkProgramPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class KkbpkProgramPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new KkbpkProgramTransformer();
    }
}
