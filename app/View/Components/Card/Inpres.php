<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;
use App\Repositories\Contract\InpresProgramRepository;
use App\Repositories\Criteria\Program\InpresCriteria;

class Inpres extends Component
{
    public $inprePrograms;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $themes = [
        1 => 'info',
        2 => 'warning',
        3 => 'purple',
        4 => 'green',
        5 => 'danger',
        6 => 'secondary',
        7 => 'indigo',
        8 => 'orange',
    ];

    public $icons = [
        1 => 'file-alt',
        2 => 'people-arrows',
        3 => 'hospital-user',
        4 => 'people-carry',
        5 => 'user-graduate',
        6 => 'user-shield',
        7 => 'money-bill',
        8 => 'home'
    ];

    public function __construct(InpresProgramRepository $repository)
    {
        $repository->pushCriteria(InpresCriteria::class);
        $this->inprePrograms = $repository->get();

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
        return view('components.card.inpres');
    }
}
