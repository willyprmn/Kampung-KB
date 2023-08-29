<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;
use App\Repositories\Contract\ProgramRepository;
use App\Repositories\Criteria\Program\AccumulatedKkbpkCriteria;
class Program extends Component
{

    public $programs;
    public $themes = [
        1 => 'primary',
        2 => 'warning',
        3 => 'purple',
        4 => 'yellow',
        5 => 'danger',
    ];

    public $icons = [
        1 => 'bkb-square.jpeg',
        2 => 'bkr-square.jpeg',
        3 => 'bkl-square.jpeg',
        4 => 'uppka-square.jpeg',
        5 => 'pikr-square.jpeg',
        7 => 'rumahdataku-square.jpeg'
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ProgramRepository $repository)
    {
        $repository->pushCriteria(AccumulatedKkbpkCriteria::class);
        $this->programs = $repository->get();

        if (request()->has('debug')) dd(
            ['programs' => $this->programs->toArray()]
        );
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card.program');
    }
}
