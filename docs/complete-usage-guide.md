# Laravel SEO Pro - Complete Usage Guide

This comprehensive guide covers all features and integrations of Laravel SEO Pro.

## Table of Contents

1. [Installation](#installation)
2. [Basic Usage](#basic-usage)
3. [Blade Components](#blade-components)
4. [Livewire Integration](#livewire-integration)
5. [Filament Integration](#filament-integration)
6. [Advanced Features](#advanced-features)
7. [API Reference](#api-reference)
8. [Troubleshooting](#troubleshooting)

## Installation

### 1. Install the Package

```bash
composer require laravel-seo-pro/seo-pro
```

### 2. Publish Configuration

```bash
php artisan vendor:publish --tag=seo-config
```

### 3. Run Migrations

```bash
php artisan migrate
```

### 4. Install Filament Components (Optional)

```bash
php artisan seo:install-filament
```

## Basic Usage

### Using the SEO Facade

```php
use LaravelSeoPro\Facades\Seo;

// Set basic meta tags
Seo::setTitle('My Page Title');
Seo::setDescription('This is my page description');
Seo::setKeywords('laravel, seo, php');

// Set Open Graph tags
Seo::setOgTitle('My Page Title');
Seo::setOgDescription('This is my page description');
Seo::setOgImage('https://example.com/image.jpg');

// Set Twitter Card tags
Seo::setTwitterTitle('My Page Title');
Seo::setTwitterDescription('This is my page description');
Seo::setTwitterImage('https://example.com/image.jpg');

// Generate all meta tags
echo Seo::render();
```

### Using the HasSeo Trait

```php
use LaravelSeoPro\Traits\HasSeo;

class Post extends Model
{
    use HasSeo;
    
    protected $fillable = ['title', 'content', 'slug'];
}

// In your controller
$post = Post::find(1);

// Set SEO data
$post->updateSeoMeta([
    'title' => 'My Post Title',
    'description' => 'This is my post description',
    'keywords' => 'laravel, seo, blog',
    'og_title' => 'My Post Title',
    'og_description' => 'This is my post description',
    'og_image' => 'https://example.com/post-image.jpg',
]);

// Get SEO data
$seoMeta = $post->getSeoMeta();
```

## Blade Components

### 1. Complete SEO Component

```blade
@seo([
    'title' => 'My Page Title',
    'description' => 'This is my page description',
    'keywords' => 'laravel, seo, php',
    'canonical_url' => 'https://example.com/page',
    'og_title' => 'My Page Title',
    'og_description' => 'This is my page description',
    'og_image' => 'https://example.com/image.jpg',
    'twitter_title' => 'My Page Title',
    'twitter_description' => 'This is my page description',
    'twitter_image' => 'https://example.com/image.jpg',
])
```

### 2. Individual SEO Directives

```blade
@seoTitle('My Page Title')
@seoDescription('This is my page description')
@seoKeywords('laravel, seo, php')
@seoCanonical('https://example.com/page')
@seoRobots('index, follow')
```

### 3. Using with Models

```blade
@seo(['model' => $post])
```

### 4. Individual Components

```blade
<x-seo::meta-tags :model="$post" />
<x-seo::open-graph :model="$post" />
<x-seo::twitter-card :model="$post" />
<x-seo::json-ld :model="$post" />
```

## Livewire Integration

### 1. SEO Manager Component

```blade
<livewire:seo-manager :model="$post" />
```

### 2. SEO Fields Component

```blade
<livewire:seo-fields :model="$post" />
```

### 3. Custom Livewire Component

```php
use LaravelSeoPro\Traits\HasSeo;

class MyComponent extends Component
{
    use HasSeo;
    
    public $post;
    
    public function mount($post)
    {
        $this->post = $post;
    }
    
    public function updateSeo($data)
    {
        $this->post->updateSeoMeta($data);
        $this->dispatch('seo-updated');
    }
}
```

## Filament Integration

### 1. Accessing the Admin Interface

After running `php artisan seo:install-filament`, you'll have access to:

- **SEO Dashboard**: `/admin/seo-dashboard`
- **SEO Meta Management**: `/admin/seo-meta`
- **Sitemap Manager**: `/admin/sitemap-manager`
- **Robots Manager**: `/admin/robots-manager`
- **SEO Audit Dashboard**: `/admin/seo-audit-dashboard`

### 2. Adding SEO Fields to Filament Resources

```php
use LaravelSeoPro\Filament\Components\SeoFields;

class PostResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Your existing fields
                TextInput::make('title'),
                Textarea::make('content'),
                
                // Add SEO fields
                ...SeoFields::make('seo'),
            ]);
    }
}
```

### 3. Custom SEO Fields

```php
use LaravelSeoPro\Filament\Components\SeoFields;

class CustomSeoFields extends SeoFields
{
    public static function make(string $name = 'seo'): array
    {
        $fields = parent::make($name);
        
        // Add custom fields
        $fields[0]->schema[0]->tabs[0]->schema[] = 
            TextInput::make($name . '.custom_field')
                ->label('Custom SEO Field');
        
        return $fields;
    }
}
```

## Advanced Features

### 1. SEO Audit Middleware

```php
// In your routes/web.php
Route::middleware(['seo.audit'])->group(function () {
    Route::get('/posts/{post}', [PostController::class, 'show']);
});
```

### 2. Custom SEO Service

```php
use LaravelSeoPro\Services\SeoService;

class CustomSeoService extends SeoService
{
    public function generateCustomMeta($model)
    {
        // Your custom logic
        return $this->generateMeta($model);
    }
}
```

### 3. SEO Configuration

```php
// config/seo.php
return [
    'features' => [
        'meta_tags' => true,
        'open_graph' => true,
        'twitter_cards' => true,
        'json_ld' => true,
        'canonical_urls' => true,
        'robots_meta' => true,
        'robots_txt' => true,
        'sitemap' => true,
        'audit_middleware' => true,
        'dashboard' => true,
    ],
    
    'defaults' => [
        'title' => 'My Website',
        'description' => 'Welcome to my website',
        'keywords' => 'website, laravel, seo',
        'author' => 'John Doe',
        'robots' => 'index, follow',
    ],
    
    'open_graph' => [
        'type' => 'website',
        'site_name' => 'My Website',
        'locale' => 'en_US',
        'image_width' => 1200,
        'image_height' => 630,
    ],
    
    'twitter' => [
        'card' => 'summary_large_image',
        'site' => '@mywebsite',
        'creator' => '@johndoe',
    ],
];
```

### 4. Sitemap Generation

```php
use LaravelSeoPro\Services\SeoService;

$seoService = app(SeoService::class);

// Generate sitemap
$sitemap = $seoService->generateSitemap();

// Generate robots.txt
$robots = $seoService->generateRobots();
```

### 5. SEO Commands

```bash
# Generate sitemap
php artisan seo:generate-sitemap

# Generate robots.txt
php artisan seo:generate-robots

# Run SEO audit
php artisan seo:audit

# Install Filament components
php artisan seo:install-filament
```

## API Reference

### Seo Facade Methods

```php
// Basic meta tags
Seo::setTitle($title)
Seo::setDescription($description)
Seo::setKeywords($keywords)
Seo::setAuthor($author)
Seo::setRobots($robots)
Seo::setCanonicalUrl($url)

// Open Graph
Seo::setOgTitle($title)
Seo::setOgDescription($description)
Seo::setOgImage($image)
Seo::setOgType($type)
Seo::setOgUrl($url)
Seo::setOgSiteName($siteName)
Seo::setOgLocale($locale)

// Twitter Cards
Seo::setTwitterCard($card)
Seo::setTwitterSite($site)
Seo::setTwitterCreator($creator)
Seo::setTwitterTitle($title)
Seo::setTwitterDescription($description)
Seo::setTwitterImage($image)

// JSON-LD
Seo::setJsonLd($jsonLd)
Seo::addJsonLdProperty($key, $value)

// Additional meta
Seo::addMeta($name, $content)
Seo::setAdditionalMeta($meta)

// Rendering
Seo::render()
Seo::getAllMeta()
```

### HasSeo Trait Methods

```php
// Get SEO meta
$model->getSeoMeta()

// Update SEO meta
$model->updateSeoMeta($data)

// Check if has SEO
$model->hasSeoMeta()

// Get SEO title
$model->getSeoTitle()

// Get SEO description
$model->getSeoDescription()

// Get SEO keywords
$model->getSeoKeywords()

// Get canonical URL
$model->getSeoCanonicalUrl()
```

## Troubleshooting

### Common Issues

1. **Blade directives not working**
   - Make sure you've published the views: `php artisan vendor:publish --tag=seo-views`
   - Clear view cache: `php artisan view:clear`

2. **Livewire components not loading**
   - Make sure Livewire is installed: `composer require livewire/livewire`
   - Clear Livewire cache: `php artisan livewire:discover`

3. **Filament integration not working**
   - Make sure Filament is installed: `composer require filament/filament`
   - Run the installation command: `php artisan seo:install-filament`

4. **SEO meta not appearing**
   - Check if the model uses the `HasSeo` trait
   - Verify the SEO data is saved correctly
   - Check the Blade template includes the SEO components

### Debug Mode

Enable debug mode in your `.env` file:

```env
APP_DEBUG=true
LOG_LEVEL=debug
```

### Support

For issues and questions:
- Check the [GitHub Issues](https://github.com/laravel-seo-pro/seo-pro/issues)
- Read the [Documentation](https://laravel-seo-pro.com/docs)
- Join our [Discord Community](https://discord.gg/laravel-seo-pro)
