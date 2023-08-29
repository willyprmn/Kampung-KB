<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\OperasionalTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OperasionalPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class OperasionalPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OperasionalTransformer();
    }
}
