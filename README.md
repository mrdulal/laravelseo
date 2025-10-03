# Laravel SEO Pro

[![Packagist](https://img.shields.io/packagist/v/laravel-seo-pro/seo-pro.svg?style=flat-square)](https://packagist.org/packages/laravel-seo-pro/seo-pro)
[![Downloads](https://img.shields.io/packagist/dt/laravel-seo-pro/seo-pro.svg?style=flat-square)](https://packagist.org/packages/laravel-seo-pro/seo-pro)
[![License](https://img.shields.io/packagist/l/laravel-seo-pro/seo-pro.svg?style=flat-square)](https://packagist.org/packages/laravel-seo-pro/seo-pro)
[![PHP Version](https://img.shields.io/packagist/php-v/laravel-seo-pro/seo-pro.svg?style=flat-square)](https://packagist.org/packages/laravel-seo-pro/seo-pro)
[![Laravel](https://img.shields.io/badge/Laravel-9%2B-red.svg?style=flat-square)](https://laravel.com)
[![Tests](https://img.shields.io/github/actions/workflow/status/laravel-seo-pro/seo-pro/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/laravel-seo-pro/seo-pro/actions/workflows/tests.yml)

A comprehensive SEO toolkit for Laravel applications that provides meta tags, Open Graph, Twitter Cards, JSON-LD schema, canonical URLs, robots.txt generation, XML sitemaps, and SEO auditing capabilities.

## Features

- ![Meta Tags](https://img.shields.io/badge/Meta%20Tags-🏷️-0066CC?style=flat-square&logo=html5&logoColor=white) **Meta Tags Management** - Title, description, keywords, author, robots
- ![Open Graph](https://img.shields.io/badge/Open%20Graph-📱-00B4DB?style=flat-square&logo=facebook&logoColor=white) **Open Graph Support** - Complete Open Graph meta tags for social sharing
- ![Twitter Cards](https://img.shields.io/badge/Twitter%20Cards-🐦-1DA1F2?style=flat-square&logo=twitter&logoColor=white) **Twitter Cards** - Twitter Card meta tags for enhanced tweets
- ![JSON-LD](https://img.shields.io/badge/JSON--LD-📊-FF6B35?style=flat-square&logo=json&logoColor=white) **JSON-LD Schema** - Structured data markup for search engines
- ![Canonical URLs](https://img.shields.io/badge/Canonical%20URLs-🔗-8B5CF6?style=flat-square&logo=link&logoColor=white) **Canonical URLs** - Prevent duplicate content issues
- ![Robots.txt](https://img.shields.io/badge/Robots.txt-🤖-EF4444?style=flat-square&logo=robot&logoColor=white) **Robots.txt Generation** - Automatic robots.txt file generation
- ![XML Sitemap](https://img.shields.io/badge/XML%20Sitemap-🗺️-14B8A6?style=flat-square&logo=sitemap&logoColor=white) **XML Sitemap** - Dynamic XML sitemap generation
- ![SEO Audit](https://img.shields.io/badge/SEO%20Audit-🔍-F59E0B?style=flat-square&logo=search&logoColor=white) **SEO Audit Middleware** - Real-time SEO issue detection
- ![SEO Dashboard](https://img.shields.io/badge/SEO%20Dashboard-📈-6366F1?style=flat-square&logo=chart-bar&logoColor=white) **SEO Dashboard** - Optional admin dashboard for SEO management
- ![Blade Components](https://img.shields.io/badge/Blade%20Components-🎨-EC4899?style=flat-square&logo=laravel&logoColor=white) **Blade Components** - Easy-to-use Blade components for templates
- ![Artisan Commands](https://img.shields.io/badge/Artisan%20Commands-⚡-F59E0B?style=flat-square&logo=terminal&logoColor=white) **Artisan Commands** - Command-line tools for SEO management
- ![Database Integration](https://img.shields.io/badge/Database%20Integration-🗄️-6B7280?style=flat-square&logo=database&logoColor=white) **Database Integration** - Polymorphic SEO meta storage with HasSeo trait
- ![Livewire Support](https://img.shields.io/badge/Livewire%20Support-⚡-FF2D20?style=flat-square&logo=livewire&logoColor=white) **Livewire Support** - Full Livewire compatibility with reactive components
- ![Filament Integration](https://img.shields.io/badge/Filament%20Integration-🎛️-6366F1?style=flat-square&logo=filament&logoColor=white) **Filament Integration** - Complete Filament admin panel integration
- ![Real-time Updates](https://img.shields.io/badge/Real--time%20Updates-🔄-10B981?style=flat-square&logo=refresh&logoColor=white) **Real-time Updates** - Live SEO management with instant previews
- ![Mobile Responsive](https://img.shields.io/badge/Mobile%20Responsive-📱-8B5CF6?style=flat-square&logo=mobile&logoColor=white) **Mobile Responsive** - Optimized for all device sizes

## Installation

### Quick Installation (Recommended)

Use the interactive installation command to choose your preferred integration:

```bash
composer require laravel-seo-pro/seo-pro
php artisan seo:install
```

The installer will guide you through selecting your integration method:
- **Blade Components Only** - Lightweight, no additional dependencies
- **Livewire Integration** - Reactive components with real-time updates
- **Filament Integration** - Admin panel with advanced management
- **Full Integration** - Livewire + Filament + Blade components

### Installation Options

You can also specify your preferred integration directly:

```bash
# Blade components only (lightweight)
php artisan seo:install --blade-only

# With Livewire integration
php artisan seo:install --livewire

# With Filament integration
php artisan seo:install --filament

# Skip creating example files
php artisan seo:install --no-examples

# Force installation without prompts
php artisan seo:install --force --livewire
```

### Manual Installation

If you prefer manual installation:

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

5. (Optional) Install additional dependencies:

```bash
# For Livewire support
composer require livewire/livewire

# For Filament support
composer require filament/filament
```

## Configuration

The package configuration is located in `config/seo.php`. You can customize:

- **Feature toggles** - Enable/disable specific SEO components
- **Default values** - Set default meta tags and social media data
- **Open Graph settings** - Configure Open Graph defaults
- **Twitter Card settings** - Configure Twitter Card defaults
- **Robots.txt rules** - Set up search engine directives
- **Sitemap configuration** - Configure XML sitemap generation
- **SEO audit rules** - Set up automated SEO analysis

### Configuration Example

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
        'dashboard' => false,
    ],
    
    'defaults' => [
        'title' => 'My Website',
        'description' => 'Welcome to my website',
        'keywords' => 'website, laravel, php',
        'author' => 'My Company',
        'robots' => 'index, follow',
    ],
    
    'open_graph' => [
        'type' => 'website',
        'site_name' => 'My Website',
        'locale' => 'en_US',
    ],
    
    'twitter' => [
        'card' => 'summary_large_image',
        'site' => '@mywebsite',
        'creator' => '@mywebsite',
    ],
];
```

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
    <x-seo.meta :model="$post" />
    <x-seo.og :model="$post" />
    <x-seo.twitter :model="$post" />
    <x-seo.json-ld :model="$post" />
</head>
<body>
    <!-- Your content -->
</body>
</html>
```

### Using Livewire Components

For dynamic SEO management with Livewire:

```blade
<!-- Full SEO Manager -->
<livewire:seo-manager :model="$post" />

<!-- Simple SEO Fields -->
<livewire:seo-fields :model="$post" />
```

### Using with Filament

The package automatically registers Filament resources for SEO management:

1. **SEO Meta Resource** - Manage all SEO data through Filament admin panel
2. **Automatic Integration** - Works with any model that uses the HasSeo trait
3. **Bulk Operations** - Manage multiple SEO records at once
4. **Advanced Filtering** - Filter and search SEO data efficiently

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

## 🆘 Support & Community

### Getting Help

- **📚 Documentation** - Comprehensive guides and examples
- **💬 GitHub Discussions** - Questions and general discussion
- **🎯 Discord Community** - Real-time chat and support
- **🐛 GitHub Issues** - Bug reports and feature requests
- **❓ FAQ** - Common questions and answers

### Community Links

- [📖 Documentation](https://laravelseopro.com/docs)
- [💬 Discord](https://discord.gg/laravel-seo-pro)
- [🐦 Twitter](https://twitter.com/laravelseopro)
- [📧 Email](mailto:support@laravelseopro.com)

### Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

- [🤝 Contributing Guide](CONTRIBUTING.md)
- [📋 Code of Conduct](CODE_OF_CONDUCT.md)
- [🔒 Security Policy](.github/SECURITY.md)

## 📊 Project Status

[![GitHub stars](https://img.shields.io/github/stars/laravel-seo-pro/seo-pro?style=social)](https://github.com/laravel-seo-pro/seo-pro)
[![GitHub forks](https://img.shields.io/github/forks/laravel-seo-pro/seo-pro?style=social)](https://github.com/laravel-seo-pro/seo-pro)
[![GitHub watchers](https://img.shields.io/github/watchers/laravel-seo-pro/seo-pro?style=social)](https://github.com/laravel-seo-pro/seo-pro)

## 📈 Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for more information on what has changed recently.

## 🏆 Acknowledgments

- **Laravel Community** - For the amazing framework
- **Contributors** - Who help improve this package
- **Users** - Who provide feedback and suggestions
- **Open Source** - For making this possible

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

<div align="center">

**Made with ❤️ by the Laravel SEO Pro Team**

[⭐ Star us on GitHub](https://github.com/laravel-seo-pro/seo-pro) • [📖 Read the docs](https://laravelseopro.com/docs) • [💬 Join our Discord](https://discord.gg/laravel-seo-pro)

</div>
