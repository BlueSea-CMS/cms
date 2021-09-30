<?php

namespace BlueSea\Cms\Views\Components;

use Illuminate\View\Component;

class AppTemplate extends Component
{
    protected $componentName = 'app';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return __DIR__ . '../../../resources/views/app.blade.php';
    }
}
