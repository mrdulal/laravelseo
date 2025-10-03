<?php

namespace LaravelSeoPro\View\Components;

use Illuminate\View\Component;
use LaravelSeoPro\Facades\Seo;

class OpenGraph extends Component
{
    public $openGraph;

    public function __construct()
    {
        $this->openGraph = Seo::getOpenGraphData();
    }

    public function render()
    {
        return view('seo::components.open-graph');
    }
}
