<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\KkbpkNonKontrasepsiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class KkbpkNonKontrasepsiPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class KkbpkNonKontrasepsiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new KkbpkNonKontrasepsiTransformer();
    }
}
