<?php

namespace App\View\Components\Navbar;

use Illuminate\View\Component;
use App\Models\Kategori as KategoriModel;

class Kategori extends Component
{

    public $kategories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->kategories = KategoriModel::get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.navbar.kategori');
    }
}
