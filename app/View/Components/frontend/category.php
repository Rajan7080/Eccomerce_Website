<?php

namespace App\View\Components\frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class category extends Component
{

    public function __construct()
    {
        //
    }
    public function render(): View|Closure|string
    {
        return view('components.frontend.category');
    }
}
