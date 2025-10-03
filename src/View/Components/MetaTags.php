<?php

namespace LaravelSeoPro\View\Components;

use Illuminate\View\Component;
use LaravelSeoPro\Facades\Seo;

class MetaTags extends Component
{
    public $meta;

    public function __construct()
    {
        $this->meta = Seo::getAllMeta()['meta'];
    }

    public function render()
    {
        return view('seo::components.meta-tags');
    }
}
