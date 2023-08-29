<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Repositories\Contract\{
    ProvinsiRepository,
};

class RegionalFilter extends Component
{
    protected $provinsiRepository;
    public $provinsis;
    public $searchType;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ProvinsiRepository $provinsiRepository, $searchType)
    {
        $this->provinsiRepository = $provinsiRepository;
        //
        $this->provinsis = $this->provinsiRepository->get()->sortBy('id')->pluck('name', 'id');

        $this->searchType = $searchType;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.regional-filter');
    }
}
