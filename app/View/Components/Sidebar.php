<?php

namespace App\View\Components;

use Auth;
use Cache;

use Menu as LavaryMenu;
use App\Models\Menu;
use Illuminate\View\Component;
use App\Repositories\Contract\MenuRepository;
use App\Repositories\Contract\UserRepository;
use App\Repositories\Criteria\Menu\RoleMenuFilterCriteria;

class Sidebar extends Component
{

    protected $menus;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(MenuRepository $repository, UserRepository $userRepository)
    {

        $this->menus = session('menus');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.sidebar', ['menus' => $this->menus]);
    }
}
