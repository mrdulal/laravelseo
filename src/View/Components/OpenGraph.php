<?php

namespace LaravelSeoPro\View\Components;

use Illuminate\View\Component;
use LaravelSeoPro\Facades\Seo;

class OpenGraph extends Component
{
    public $openGraph;
    public $model;

    public function __construct($model = null)
    {
        $this->model = $model;
        
        if ($model && method_exists($model, 'getSeoMeta')) {
            Seo::loadFromModel($model);
        }
        
        $this->openGraph = Seo::getOpenGraphData();
    }

    public function render()
    {
        return view('seo::components.open-graph');
    }
}
