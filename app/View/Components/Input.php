<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $type = 'text',
        public string $html = '',
        public string $value = ''
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->type == 'number') {
            $this->html = $this->html . ' onkeydown = "return event.keyCode !== 69"';
        }

        return view('components.input');
    }
}
