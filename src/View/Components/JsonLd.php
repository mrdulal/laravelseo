<?php

namespace LaravelSeoPro\View\Components;

use Illuminate\View\Component;
use LaravelSeoPro\Facades\Seo;

class JsonLd extends Component
{
    public $jsonLd;
    public $model;

    public function __construct($model = null)
    {
        $this->model = $model;
        
        if ($model && method_exists($model, 'getSeoMeta')) {
            Seo::loadFromModel($model);
        }
        
        $this->jsonLd = Seo::getJsonLd();
    }

    public function render()
    {
        return view('seo::components.json-ld');
    }
}
