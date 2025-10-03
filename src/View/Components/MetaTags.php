<?php

namespace LaravelSeoPro\View\Components;

use Illuminate\View\Component;
use LaravelSeoPro\Facades\Seo;

class MetaTags extends Component
{
    public $meta;
    public $model;

    public function __construct($model = null)
    {
        $this->model = $model;
        
        if ($model && method_exists($model, 'getSeoMeta')) {
            Seo::loadFromModel($model);
        }
        
        $this->meta = Seo::getAllMeta()['meta'];
    }

    public function render()
    {
        return view('seo::components.meta-tags');
    }
}
