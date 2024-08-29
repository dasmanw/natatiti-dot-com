<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     * @param string $name
     * @param string $action 
     * @param string $method Possible values are POST, PUT, PATCH, DELETE
     * @param bool $multipart
     */
    public string $name;
    public string $action;
    public string $method;
    public string $multipart;
    public function __construct(
        string $name = '',
        string $action = 'javascript:void(0)',
        string $method = 'POST',
        bool $multipart = false
    ) {
        $this->name = $name;
        $this->action = $action;
        $this->multipart = $multipart;
        $methods = [
            'POST' => 'POST',
            'PUT' => 'PUT',
            'PATCH' => 'PATCH',
            'DELETE' => 'DELETE',
        ];

        $method = strtoupper($method);

        $this->method = array_key_exists($method, $methods) ? $methods[$method] : $method;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form');
    }
}
