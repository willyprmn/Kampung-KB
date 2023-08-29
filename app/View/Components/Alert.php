<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{

    public $variant, $title, $message;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $alert = [])
    {
        $this->variant = $alert['variant'] ?? 'info';
        $this->title = $alert['title'] ?? 'Info';
        $this->message = $alert['message'] ?? '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
