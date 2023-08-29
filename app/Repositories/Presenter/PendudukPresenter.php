<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\PendudukTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PendudukPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class PendudukPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PendudukTransformer();
    }
}
