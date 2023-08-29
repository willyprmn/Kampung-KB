<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\FrekuensiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FrekuensiPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class FrekuensiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FrekuensiTransformer();
    }
}
