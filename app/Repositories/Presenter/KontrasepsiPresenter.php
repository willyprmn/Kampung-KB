<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\KontrasepsiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class KontrasepsiPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class KontrasepsiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new KontrasepsiTransformer();
    }
}
