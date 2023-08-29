<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\JenisPostTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class JenisPostPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class JenisPostPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new JenisPostTransformer();
    }
}
