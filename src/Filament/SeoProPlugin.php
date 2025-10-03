<?php

namespace LaravelSeoPro\Filament;

use Filament\PluginServiceProvider;
use LaravelSeoPro\Filament\Resources\SeoMetaResource;
use LaravelSeoPro\Filament\Pages\SeoDashboard;
use LaravelSeoPro\Filament\Pages\SitemapManager;
use LaravelSeoPro\Filament\Pages\RobotsManager;
use LaravelSeoPro\Filament\Widgets\SeoOverviewWidget;
use LaravelSeoPro\Filament\Widgets\SeoAuditWidget;
use LaravelSeoPro\Filament\Widgets\SeoPerformanceWidget;
use Spatie\LaravelPackageTools\Package;

class SeoProPlugin extends PluginServiceProvider
{
    protected array $resources = [
        SeoMetaResource::class,
    ];

    protected array $pages = [
        SeoDashboard::class,
        SitemapManager::class,
        RobotsManager::class,
    ];

    protected array $widgets = [
        SeoOverviewWidget::class,
        SeoAuditWidget::class,
        SeoPerformanceWidget::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-seo-pro')
            ->hasConfigFile('seo')
            ->hasViews()
            ->hasMigrations();
    }
}
