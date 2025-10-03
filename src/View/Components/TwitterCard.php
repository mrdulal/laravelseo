<?php

namespace LaravelSeoPro\View\Components;

use Illuminate\View\Component;
use LaravelSeoPro\Facades\Seo;

class TwitterCard extends Component
{
    public $twitter;

    public function __construct()
    {
        $this->twitter = Seo::getTwitterCardData();
    }

    public function render()
    {
        return view('seo::components.twitter-card');
    }
}
