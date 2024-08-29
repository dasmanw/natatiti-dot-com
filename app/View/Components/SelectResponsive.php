<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectResponsive extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $class = 'col-md-4',
        public string $html = ''
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-responsive');
    }
}
