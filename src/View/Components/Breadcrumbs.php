<?php

namespace LaravelSeoPro\View\Components;

use Illuminate\View\Component;
use LaravelSeoPro\Services\SeoService;

class Breadcrumbs extends Component
{
    public array $breadcrumbs;
    public bool $showJsonLd;
    public string $separator;
    public string $class;

    public function __construct(
        array $breadcrumbs = [],
        bool $showJsonLd = true,
        string $separator = '>',
        string $class = 'breadcrumbs'
    ) {
        $this->breadcrumbs = $breadcrumbs;
        $this->showJsonLd = $showJsonLd;
        $this->separator = $separator;
        $this->class = $class;
    }

    public function render()
    {
        return view('seo::components.breadcrumbs');
    }

    public function getJsonLd(): string
    {
        if (!$this->showJsonLd || empty($this->breadcrumbs)) {
            return '';
        }

        $seoService = app(SeoService::class);
        
        foreach ($this->breadcrumbs as $breadcrumb) {
            $seoService->addBreadcrumb(
                $breadcrumb['name'],
                $breadcrumb['url'],
                $breadcrumb['position'] ?? null
            );
        }

        return $seoService->renderBreadcrumbs();
    }
}
