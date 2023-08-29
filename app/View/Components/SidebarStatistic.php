<?php

namespace App\View\Components;

use Str;
use Illuminate\View\Component;
use App\Repositories\Contract\{
    ConfigurationStatisticRepository
};
use Cache;
class SidebarStatistic extends Component
{
    protected $configurationStatisticRepository;
    public $menus;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ConfigurationStatisticRepository $configurationStatisticRepository)
    {
        $this->configurationStatisticRepository = $configurationStatisticRepository;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        #cache one day
        $this->menus = Cache::remember('sidebar-statistic', 86400, function (){
            return \Menu::make('StatisticNavBar', function ($menu) {

                $menus = $this->configurationStatisticRepository->orderBy('id')
                    ->whereNotIn('id', [24, 25, 26, 27, 28, 29, 30, 31]) #exclude inpres
                    ->get();

                function recursiveMenu($menu, $parentName, $parentId, $menus){

                    foreach($menus->where('parent_id', $parentId) as $child)
                    {
                        $menu->$parentName->add($child->title, ['route'  => [
                            'portal.statistik.show',
                            'statistik' => $child->id,
                            'slug' => Str::slug($child->title),
                        ], 'tooltip' => $child->tooltip]);

                        if($menus->where('parent_id', $child->id)->isNotEmpty()){
                            $parentName = $menu->items->firstWhere('title', $child->title)->nickname;
                            recursiveMenu($menu, $parentName, $child->id, $menus);
                        }
                    }
                }

                foreach($menus->where('parent_id', null) as $key => $item)
                {
                    $menu->add($item->title, ['route'  => [
                        'portal.statistik.show',
                        'statistik' => $item->id,
                        'slug' => Str::slug($item->title),
                    ], 'tooltip' => $item->tooltip]);
                    $parentName = $menu->items->firstWhere('title', $item->title)->nickname;

                    if($menus->where('parent_id', $item->id)->isNotEmpty()){
                        recursiveMenu($menu, $parentName, $item->id, $menus);
                    }
                    
                }

                
            });
        });

        return view('components.sidebar-statistic');
    }
}
