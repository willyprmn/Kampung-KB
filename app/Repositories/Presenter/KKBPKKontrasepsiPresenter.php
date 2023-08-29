<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\KkbpkKontrasepsiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class KkbpkKontrasepsiPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class KkbpkKontrasepsiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new KkbpkKontrasepsiTransformer();
    }
}
