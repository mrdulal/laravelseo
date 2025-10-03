<?php

namespace LaravelSeoPro\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use LaravelSeoPro\View\Components\SeoDirective;

class SeoBladeServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Register Blade components
        Blade::component('seo', SeoDirective::class);
        Blade::component('seo-directive', SeoDirective::class);
        
        // Register custom Blade directives
        $this->registerBladeDirectives();
    }

    protected function registerBladeDirectives()
    {
        // @seo directive
        Blade::directive('seo', function ($expression) {
            return "<?php echo app('LaravelSeoPro\\View\\Components\\SeoDirective', [$expression])->render(); ?>";
        });

        // @seoTitle directive
        Blade::directive('seoTitle', function ($expression) {
            return "<?php echo '<title>' . ($expression ?: config('seo.defaults.title', 'Laravel Application')) . '</title>'; ?>";
        });

        // @seoDescription directive
        Blade::directive('seoDescription', function ($expression) {
            return "<?php echo '<meta name=\"description\" content=\"' . ($expression ?: config('seo.defaults.description', 'A Laravel application')) . '\">'; ?>";
        });

        // @seoKeywords directive
        Blade::directive('seoKeywords', function ($expression) {
            return "<?php echo '<meta name=\"keywords\" content=\"' . ($expression ?: config('seo.defaults.keywords', 'laravel, php, web development')) . '\">'; ?>";
        });

        // @seoCanonical directive
        Blade::directive('seoCanonical', function ($expression) {
            return "<?php if($expression): echo '<link rel=\"canonical\" href=\"' . $expression . '\">'; endif; ?>";
        });

        // @seoRobots directive
        Blade::directive('seoRobots', function ($expression) {
            return "<?php echo '<meta name=\"robots\" content=\"' . ($expression ?: config('seo.defaults.robots', 'index, follow')) . '\">'; ?>";
        });
    }
}
