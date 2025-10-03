# Laravel SEO Pro Documentation

Welcome to the comprehensive documentation for Laravel SEO Pro, the most powerful SEO toolkit for Laravel applications.

## 🚀 Quick Start

Get up and running in minutes:

```bash
composer require laravel-seo-pro/seo-pro
php artisan seo:install
```

## 📚 Documentation Sections

### Getting Started
- [Installation Guide](getting-started/installation.md) - Complete installation instructions
- [Quick Start](getting-started/quick-start.md) - Get up and running quickly
- [Configuration](getting-started/configuration.md) - Understanding configuration options

### Components
- [Blade Components](components/blade-components.md) - Using SEO Blade components
- [Livewire Components](components/livewire-components.md) - Reactive SEO management
- [Filament Integration](components/filament-integration.md) - Admin panel integration

### Features
- [Meta Tags](features/meta-tags.md) - Managing meta tags
- [Open Graph](features/open-graph.md) - Social media optimization
- [Twitter Cards](features/twitter-cards.md) - Twitter optimization
- [JSON-LD Schema](features/json-ld.md) - Structured data markup
- [Robots.txt](features/robots-txt.md) - Search engine directives
- [XML Sitemap](features/xml-sitemap.md) - Site structure for search engines
- [SEO Audit](features/seo-audit.md) - Automated SEO analysis

### Commands
- [Artisan Commands](commands/artisan-commands.md) - Command-line tools
- [Installation Command](commands/installation-command.md) - Interactive installer

### Examples
- [Basic Usage](examples/basic-usage.md) - Simple examples
- [Advanced Usage](examples/advanced-usage.md) - Complex scenarios
- [Livewire Examples](examples/livewire-examples.md) - Reactive components
- [Filament Examples](examples/filament-examples.md) - Admin panel usage

### API Reference
- [Seo Facade](api/seo-facade.md) - Facade methods
- [HasSeo Trait](api/has-seo-trait.md) - Model integration
- [SeoMeta Model](api/seo-meta-model.md) - Database model

## 🎯 Key Features

### Core SEO Features
- **Meta Tags Management** - Title, description, keywords, author, robots
- **Open Graph Support** - Complete Open Graph meta tags for social sharing
- **Twitter Cards** - Twitter Card meta tags for enhanced tweets
- **JSON-LD Schema** - Structured data markup for search engines
- **Canonical URLs** - Prevent duplicate content issues

### Advanced Features
- **Robots.txt Generation** - Automatic robots.txt file generation
- **XML Sitemap** - Dynamic XML sitemap generation
- **SEO Audit Middleware** - Real-time SEO issue detection
- **SEO Dashboard** - Optional admin dashboard for SEO management

### Integration Options
- **Blade Components** - Easy-to-use Blade components for templates
- **Livewire Support** - Full Livewire compatibility with reactive components
- **Filament Integration** - Complete Filament admin panel integration
- **Artisan Commands** - Command-line tools for SEO management

## 🛠️ Installation Options

### Interactive Installation (Recommended)
```bash
composer require laravel-seo-pro/seo-pro
php artisan seo:install
```

### Command Line Options
```bash
# Blade components only (lightweight)
php artisan seo:install --blade-only

# With Livewire integration
php artisan seo:install --livewire

# With Filament integration
php artisan seo:install --filament

# Skip creating example files
php artisan seo:install --no-examples
```

## 📖 Usage Examples

### Basic Usage
```php
use LaravelSeoPro\Facades\Seo;

Seo::setTitle('My Page Title')
   ->setDescription('This is my page description')
   ->setKeywords('laravel, seo, php')
   ->setOpenGraph('og:image', 'https://example.com/image.jpg');
```

### Blade Components
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

### Livewire Components
```blade
<!-- Full SEO Manager -->
<livewire:seo-manager :model="$post" />

<!-- Simple SEO Fields -->
<livewire:seo-fields :model="$post" />
```

### Model Integration
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

## 🔧 Configuration

The package configuration is located in `config/seo.php`. You can customize:

- Feature toggles (enable/disable components)
- Default meta values
- Open Graph and Twitter Card defaults
- Robots.txt rules
- Sitemap configuration
- SEO audit settings

## 🎨 Customization

### Override Component Views
```bash
php artisan vendor:publish --provider="LaravelSeoPro\SeoProServiceProvider" --tag="seo-views"
```

### Custom SEO Service
```php
use LaravelSeoPro\Facades\Seo;

class CustomSeoService
{
    public function setPageSeo($page, $data = [])
    {
        Seo::setTitle($data['title'])
           ->setDescription($data['description'])
           ->setKeywords($data['keywords']);
    }
}
```

## 🧪 Testing

### Run Tests
```bash
composer test
```

### Test Coverage
```bash
composer test-coverage
```

## 📊 Performance

Laravel SEO Pro is designed to be lightweight and efficient:

- Only loads SEO data when needed
- Caches SEO data appropriately
- Minimal database queries
- Optimized for production use

## 🆘 Support

### Getting Help
- **GitHub Discussions** - For questions and general discussion
- **Discord** - For real-time chat and support
- **GitHub Issues** - For bug reports and feature requests
- **FAQ** - Common questions and answers

### Community
- Join our [Discord community](https://discord.gg/laravel-seo-pro)
- Follow us on [Twitter](https://twitter.com/laravelseopro)
- Star us on [GitHub](https://github.com/laravel-seo-pro/seo-pro)

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

### Development Setup
```bash
git clone https://github.com/laravel-seo-pro/seo-pro.git
cd seo-pro
composer install
npm install
composer test
```

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel community for the amazing framework
- All contributors who help improve this package
- Users who provide feedback and suggestions

---

**Ready to get started?** Check out our [Quick Start Guide](getting-started/quick-start.md) or [Installation Guide](getting-started/installation.md)!
