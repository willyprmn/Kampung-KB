<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\PlkbPengarahTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PlkbPengarahPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class PlkbPengarahPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PlkbPengarahTransformer();
    }
}
