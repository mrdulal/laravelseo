<?php

namespace LaravelSeoPro\View\Components;

use Illuminate\View\Component;
use LaravelSeoPro\Facades\Seo;

class JsonLd extends Component
{
    public $jsonLd;

    public function __construct()
    {
        $this->jsonLd = Seo::getJsonLd();
    }

    public function render()
    {
        return view('seo::components.json-ld');
    }
}
