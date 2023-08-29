<?php

namespace App\Repositories\Presenter;

use App\Repositories\Transformer\ProgramGroupTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProgramGroupPresenter.
 *
 * @package namespace App\Repositories\Presenter;
 */
class ProgramGroupPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProgramGroupTransformer();
    }
}
