<?php

/**
 * @author mrdulal
 * @package LaravelSeoPro
 */

namespace LaravelSeoPro\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use LaravelSeoPro\Services\SeoService;
use LaravelSeoPro\Http\Middleware\SeoAuditMiddleware;
use LaravelSeoPro\Console\Commands\GenerateRobotsCommand;
use LaravelSeoPro\Console\Commands\GenerateSitemapCommand;
use LaravelSeoPro\Console\Commands\AttachSeoCommand;
use LaravelSeoPro\Console\Commands\SeoAuditCommand;
use LaravelSeoPro\Console\Commands\InstallSeoProCommand;
use LaravelSeoPro\Console\Commands\InstallFilamentSeoCommand;
use LaravelSeoPro\Livewire\SeoManager;
use LaravelSeoPro\Livewire\Fields\SeoFields;
use LaravelSeoPro\Filament\SeoProPlugin;
use LaravelSeoPro\Providers\SeoBladeServiceProvider;
use Filament\Facades\Filament;

class SeoProServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/seo.php', 'seo');

        $this->app->singleton('seo', function ($app) {
            return new SeoService();
        });

        $this->app->alias('seo', SeoService::class);
    }

    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/../../config/seo.php' => config_path('seo.php'),
        ], 'seo-config');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'seo-migrations');

        // Publish views
        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/seo'),
        ], 'seo-views');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'seo');

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallSeoProCommand::class,
                InstallFilamentSeoCommand::class,
                GenerateRobotsCommand::class,
                GenerateSitemapCommand::class,
                AttachSeoCommand::class,
                SeoAuditCommand::class,
            ]);
        }

        // Register middleware
        $this->app['router']->aliasMiddleware('seo.audit', SeoAuditMiddleware::class);

        // Register Livewire components
        $this->registerLivewireComponents();

        // Register Filament plugin
        $this->registerFilamentPlugin();

        // Register Blade directives
        $this->registerBladeDirectives();

        // Register routes
        $this->registerRoutes();
    }

    protected function registerLivewireComponents()
    {
        if (class_exists(\Livewire\Livewire::class)) {
            \Livewire\Livewire::component('seo-manager', SeoManager::class);
            \Livewire\Livewire::component('seo-fields', SeoFields::class);
        }
    }

    protected function registerFilamentPlugin()
    {
        if (class_exists(\Filament\Facades\Filament::class)) {
            Filament::serving(function () {
                Filament::registerPlugin(new SeoProPlugin());
            });
        }
    }

    protected function registerBladeDirectives()
    {
        if (class_exists(\Illuminate\Support\Facades\Blade::class)) {
            $this->app->register(SeoBladeServiceProvider::class);
        }
    }

    protected function registerRoutes()
    {
        Route::group(['prefix' => 'seo'], function () {
            Route::get('robots.txt', function () {
                return response(app('seo')->generateRobots(), 200, [
                    'Content-Type' => 'text/plain'
                ]);
            });

            Route::get('sitemap.xml', function () {
                return response(app('seo')->generateSitemap(), 200, [
                    'Content-Type' => 'application/xml'
                ]);
            });
        });
    }
}
