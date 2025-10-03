<?php

namespace LaravelSeoPro\View\Components;

use Illuminate\View\Component;
use LaravelSeoPro\Facades\Seo;

class TwitterCard extends Component
{
    public $twitter;
    public $model;

    public function __construct($model = null)
    {
        $this->model = $model;
        
        if ($model && method_exists($model, 'getSeoMeta')) {
            Seo::loadFromModel($model);
        }
        
        $this->twitter = Seo::getTwitterCardData();
    }

    public function render()
    {
        return view('seo::components.twitter-card');
    }
}
