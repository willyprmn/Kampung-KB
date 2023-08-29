<?php

namespace App\View\Components;

use Str;

use Illuminate\View\Component;
use App\Repositories\Contract\KampungRepository;
use App\Repositories\Criteria\Kampung\LocationCriteria as KampungLocationCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

class Maps extends Component
{


    protected $kampungRepository;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(KampungRepository $kampungRepository)
    {
        $this->kampungRepository = $kampungRepository;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

        return view('components.maps');
    }
}
