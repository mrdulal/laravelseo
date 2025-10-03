# Frequently Asked Questions

## General Questions

### What is Laravel SEO Pro?

Laravel SEO Pro is a comprehensive SEO toolkit for Laravel applications that provides meta tags, Open Graph, Twitter Cards, JSON-LD schema, canonical URLs, robots.txt generation, XML sitemaps, and SEO auditing capabilities.

### What Laravel versions are supported?

Laravel SEO Pro supports Laravel 9.0 and higher, including Laravel 10.x and 11.x.

### What PHP versions are supported?

Laravel SEO Pro requires PHP 8.1 or higher.

### Is this package free?

Yes, Laravel SEO Pro is completely free and open-source under the MIT license.

## Installation Questions

### How do I install Laravel SEO Pro?

The easiest way is using the interactive installer:

```bash
composer require laravel-seo-pro/seo-pro
php artisan seo:install
```

### What integration options are available?

- **Blade Components Only** - Lightweight, no additional dependencies
- **Livewire Integration** - Reactive components with real-time updates
- **Filament Integration** - Admin panel with advanced management
- **Full Integration** - Livewire + Filament + Blade components

### Do I need to install Livewire or Filament separately?

The installer can automatically install these dependencies for you, or you can install them manually:

```bash
# For Livewire
composer require livewire/livewire

# For Filament
composer require filament/filament
```

### What files are created during installation?

- Configuration file: `config/seo.php`
- Database migration: `create_seo_meta_table.php`
- Blade views: `resources/views/vendor/seo/`
- Example files (optional): Controller, Model, Blade template, etc.

## Usage Questions

### How do I add SEO to my models?

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

### How do I include SEO components in my Blade templates?

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

### How do I set SEO data programmatically?

Use the Seo facade:

```php
use LaravelSeoPro\Facades\Seo;

Seo::setTitle('My Page Title')
   ->setDescription('My page description')
   ->setKeywords('laravel, seo, php')
   ->setOpenGraph('og:image', 'https://example.com/image.jpg');
```

### How do I use Livewire components?

```blade
<!-- Full SEO Manager -->
<livewire:seo-manager :model="$post" />

<!-- Simple SEO Fields -->
<livewire:seo-fields :model="$post" />
```

### How do I access Filament admin panel?

Visit `/admin` and look for "SEO Meta" in the navigation menu.

## Configuration Questions

### Where is the configuration file?

The configuration file is located at `config/seo.php`.

### How do I customize default values?

Edit the `defaults` section in `config/seo.php`:

```php
'defaults' => [
    'title' => 'My Website',
    'description' => 'Welcome to my website',
    'keywords' => 'website, laravel, php',
    'author' => 'My Company',
    'robots' => 'index, follow',
],
```

### How do I enable/disable features?

Use the `features` section in `config/seo.php`:

```php
'features' => [
    'meta_tags' => true,
    'open_graph' => true,
    'twitter_cards' => true,
    'json_ld' => true,
    'robots_txt' => true,
    'sitemap' => true,
    'audit_middleware' => true,
    'dashboard' => false,
],
```

### How do I configure robots.txt rules?

Edit the `robots` section in `config/seo.php`:

```php
'robots' => [
    'user_agent' => '*',
    'disallow' => [
        '/admin',
        '/api',
        '/storage',
    ],
    'allow' => [
        '/',
    ],
    'sitemap' => '/sitemap.xml',
],
```

## Troubleshooting Questions

### Components are not rendering

1. Check if the feature is enabled in `config/seo.php`
2. Verify the model has the `HasSeo` trait
3. Check Laravel logs for errors
4. Ensure the package is properly installed

### Livewire components not working

1. Make sure Livewire is installed: `composer require livewire/livewire`
2. Publish Livewire config: `php artisan vendor:publish --tag=livewire:config`
3. Check if Livewire is properly configured
4. Verify the component is registered

### Filament not accessible

1. Make sure Filament is installed: `composer require filament/filament`
2. Create a Filament user: `php artisan make:filament-user`
3. Check if Filament is properly configured
4. Verify the resource is registered

### Migration fails

1. Check database connection
2. Run `php artisan migrate:status` to see migration status
3. Check if the migration file exists
4. Verify database permissions

### SEO data not saving

1. Check if the model has the `HasSeo` trait
2. Verify the model is saved before updating SEO
3. Check database connection
4. Look for validation errors

## Performance Questions

### Does this package affect performance?

Laravel SEO Pro is designed to be lightweight and efficient. The package only loads SEO data when needed and caches it appropriately.

### How can I optimize SEO performance?

1. Use the `loadFromModel()` method to load SEO data efficiently
2. Cache SEO data for frequently accessed pages
3. Use database indexes on SEO meta fields
4. Minimize the number of SEO queries

### Can I use this with caching?

Yes, Laravel SEO Pro works well with Laravel's caching system. You can cache SEO data using:

```php
$seoData = Cache::remember("seo.{$post->id}", 3600, function() use ($post) {
    return $post->getSeoMeta();
});
```

## Integration Questions

### Can I use this with other SEO packages?

Laravel SEO Pro is designed to work independently, but you can use it alongside other SEO packages if needed. Be careful not to have conflicting meta tags.

### Does this work with Laravel Nova?

Laravel SEO Pro doesn't have built-in Nova integration, but you can use the Filament integration or create custom Nova resources.

### Can I use this with Laravel Breeze/Jetstream?

Yes, Laravel SEO Pro works with any Laravel application, including those using Breeze or Jetstream.

### Does this work with Laravel Sail?

Yes, Laravel SEO Pro works perfectly with Laravel Sail and Docker environments.

## Advanced Questions

### How do I create custom SEO components?

You can create custom Blade components that extend the base SEO functionality:

```php
<?php

namespace App\View\Components;

use Illuminate\View\Component;
use LaravelSeoPro\Facades\Seo;

class CustomSeo extends Component
{
    public function render()
    {
        return view('components.custom-seo');
    }
}
```

### How do I add custom meta tags?

Use the `addMeta()` method or `setAdditionalMeta()` method:

```php
Seo::addMeta('custom-tag', 'custom-value')
   ->setAdditionalMeta([
       'theme-color' => '#ffffff',
       'msapplication-TileColor' => '#da532c'
   ]);
```

### How do I create custom JSON-LD schema?

Use the `setJsonLd()` or `addJsonLd()` methods:

```php
Seo::setJsonLd([
    '@context' => 'https://schema.org',
    '@type' => 'CustomType',
    'name' => 'Custom Value'
]);
```

### How do I extend the SeoMeta model?

You can extend the SeoMeta model by creating your own model:

```php
<?php

namespace App\Models;

use LaravelSeoPro\Models\SeoMeta as BaseSeoMeta;

class SeoMeta extends BaseSeoMeta
{
    // Add your custom methods here
}
```

## Support Questions

### Where can I get help?

- **GitHub Discussions** - For questions and general discussion
- **Discord** - For real-time chat and support
- **GitHub Issues** - For bug reports and feature requests
- **Documentation** - Comprehensive guides and examples

### How do I report a bug?

1. Check if the issue already exists
2. Use the bug report template
3. Include steps to reproduce
4. Provide environment details
5. Add screenshots if applicable

### How do I request a feature?

1. Check if the feature is already requested
2. Use the feature request template
3. Describe the use case
4. Explain the expected behavior
5. Provide examples if possible

### Can I contribute to the project?

Yes! We welcome contributions. Please see our [Contributing Guide](CONTRIBUTING.md) for details.

## License Questions

### What license does this package use?

Laravel SEO Pro is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

### Can I use this in commercial projects?

Yes, the MIT License allows commercial use.

### Can I modify and redistribute this package?

Yes, the MIT License allows modification and redistribution.

### Do I need to include the license in my project?

You should include the license file when redistributing the package, but it's not required for normal usage.
