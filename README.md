# Laravel SEO Pro

A comprehensive SEO toolkit for Laravel applications that provides meta tags, Open Graph, Twitter Cards, JSON-LD schema, canonical URLs, robots.txt generation, XML sitemaps, and SEO auditing capabilities.

## Features

- 🏷️ **Meta Tags Management** - Title, description, keywords, author, robots
- 📱 **Open Graph Support** - Complete Open Graph meta tags for social sharing
- 🐦 **Twitter Cards** - Twitter Card meta tags for enhanced tweets
- 📊 **JSON-LD Schema** - Structured data markup for search engines
- 🔗 **Canonical URLs** - Prevent duplicate content issues
- 🤖 **Robots.txt Generation** - Automatic robots.txt file generation
- 🗺️ **XML Sitemap** - Dynamic XML sitemap generation
- 🔍 **SEO Audit Middleware** - Real-time SEO issue detection
- 📈 **SEO Dashboard** - Optional admin dashboard for SEO management
- 🎨 **Blade Components** - Easy-to-use Blade components for templates
- ⚡ **Artisan Commands** - Command-line tools for SEO management
- 🗄️ **Database Integration** - Polymorphic SEO meta storage with HasSeo trait

## Installation

1. Install the package via Composer:

```bash
composer require laravel-seo-pro/seo-pro
```

2. Publish the configuration file:

```bash
php artisan vendor:publish --provider="LaravelSeoPro\SeoProServiceProvider" --tag="seo-config"
```

3. Publish and run the migrations:

```bash
php artisan vendor:publish --provider="LaravelSeoPro\SeoProServiceProvider" --tag="seo-migrations"
php artisan migrate
```

4. (Optional) Publish the Blade views:

```bash
php artisan vendor:publish --provider="LaravelSeoPro\SeoProServiceProvider" --tag="seo-views"
```

## Configuration

The package configuration is located in `config/seo.php`. You can customize:

- Enable/disable specific features
- Set default meta values
- Configure Open Graph and Twitter Card defaults
- Set up robots.txt rules
- Configure sitemap generation
- Set up SEO audit rules

## Basic Usage

### Using the Facade

```php
use LaravelSeoPro\Facades\Seo;

// Set basic meta tags
Seo::setTitle('My Page Title')
   ->setDescription('This is my page description')
   ->setKeywords('laravel, seo, php')
   ->setAuthor('John Doe');

// Set Open Graph data
Seo::setOpenGraph('og:title', 'My Page Title')
   ->setOpenGraph('og:description', 'This is my page description')
   ->setOpenGraph('og:image', 'https://example.com/image.jpg');

// Set Twitter Card data
Seo::setTwitterCard('twitter:card', 'summary_large_image')
   ->setTwitterCard('twitter:title', 'My Page Title');

// Set JSON-LD schema
Seo::setJsonLd([
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => 'My Article Title',
    'author' => [
        '@type' => 'Person',
        'name' => 'John Doe'
    ]
]);
```

### Using Blade Components

Include the SEO components in your layout:

```blade
<!DOCTYPE html>
<html>
<head>
    <x-seo.meta />
    <x-seo.og />
    <x-seo.twitter />
    <x-seo.json-ld />
</head>
<body>
    <!-- Your content -->
</body>
</html>
```

### Using the HasSeo Trait

Add the `HasSeo` trait to your models:

```php
use LaravelSeoPro\Traits\HasSeo;

class Post extends Model
{
    use HasSeo;
    
    public function getSeoUrl()
    {
        return route('posts.show', $this);
    }
}
```

Then manage SEO data for your models:

```php
$post = Post::find(1);

// Update SEO meta
$post->updateSeoMeta([
    'title' => 'My Post Title',
    'description' => 'This is my post description',
    'og_image' => 'https://example.com/post-image.jpg',
]);

// Load SEO data into the service
Seo::loadFromModel($post);
```

## Artisan Commands

### Generate robots.txt

```bash
php artisan seo:generate-robots
```

### Generate sitemap.xml

```bash
php artisan seo:generate-sitemap
```

### Attach SEO to a model

```bash
php artisan seo:attach "App\Models\Post"
```

### Perform SEO audit

```bash
php artisan seo:audit https://example.com
```

## Middleware

Add the SEO audit middleware to your routes:

```php
Route::middleware(['seo.audit'])->group(function () {
    // Your routes
});
```

## Routes

The package automatically registers these routes:

- `/seo/robots.txt` - Dynamic robots.txt
- `/seo/sitemap.xml` - Dynamic XML sitemap

## Advanced Usage

### Custom JSON-LD Schema

```php
Seo::addJsonLd([
    '@type' => 'Organization',
    'name' => 'My Company',
    'url' => 'https://example.com',
    'logo' => 'https://example.com/logo.png'
]);
```

### Additional Meta Tags

```php
Seo::addMeta('custom-tag', 'custom-value')
   ->addMeta('another-tag', 'another-value');
```

### Custom Sitemap Models

Add your models to the sitemap configuration:

```php
// config/seo.php
'sitemap' => [
    'models' => [
        \App\Models\Post::class,
        \App\Models\Page::class,
    ],
    // ...
],
```

## Testing

Run the test suite:

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Support

If you discover any issues or have questions, please open an issue on GitHub.

## Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for more information on what has changed recently.
