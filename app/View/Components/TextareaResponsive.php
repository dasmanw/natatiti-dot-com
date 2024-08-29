<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextareaResponsive extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $class = 'col-md-4',
        public string $html = '',
        public string $value = ''
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.textarea-responsive');
    }
}
