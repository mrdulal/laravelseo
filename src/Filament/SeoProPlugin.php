<?php

namespace LaravelSeoPro\Filament;

use Filament\PluginServiceProvider;
use LaravelSeoPro\Filament\Resources\SeoMetaResource;
use Spatie\LaravelPackageTools\Package;

class SeoProPlugin extends PluginServiceProvider
{
    protected array $resources = [
        SeoMetaResource::class,
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
