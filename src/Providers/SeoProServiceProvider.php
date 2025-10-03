<?php

namespace LaravelSeoPro\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use LaravelSeoPro\Services\SeoService;
use LaravelSeoPro\Http\Middleware\SeoAuditMiddleware;
use LaravelSeoPro\Console\Commands\GenerateRobotsCommand;
use LaravelSeoPro\Console\Commands\GenerateSitemapCommand;
use LaravelSeoPro\Console\Commands\AttachSeoCommand;
use LaravelSeoPro\Console\Commands\SeoAuditCommand;

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
                GenerateRobotsCommand::class,
                GenerateSitemapCommand::class,
                AttachSeoCommand::class,
                SeoAuditCommand::class,
            ]);
        }

        // Register middleware
        $this->app['router']->aliasMiddleware('seo.audit', SeoAuditMiddleware::class);

        // Register routes
        $this->registerRoutes();
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
