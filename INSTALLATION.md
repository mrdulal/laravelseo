# Laravel SEO Pro - Installation Guide

## 🚀 Quick Start

The easiest way to install Laravel SEO Pro is using the interactive installer:

```bash
composer require laravel-seo-pro/seo-pro
php artisan seo:install
```

## 📋 Installation Options

### 1. Interactive Installation (Recommended)

Run the installer and choose your preferred integration:

```bash
php artisan seo:install
```

You'll be prompted to select from:
- **Blade Components Only** - Lightweight, no additional dependencies
- **Livewire Integration** - Reactive components with real-time updates  
- **Filament Integration** - Admin panel with advanced management
- **Full Integration** - Livewire + Filament + Blade components

### 2. Command Line Options

Specify your integration directly:

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

## 🔧 What Gets Installed

### Core Package
- ✅ SEO service and facade
- ✅ Database migrations for seo_meta table
- ✅ Blade components for meta tags
- ✅ Artisan commands for SEO management
- ✅ Configuration file (config/seo.php)

### Livewire Integration (if selected)
- ✅ Livewire components for SEO management
- ✅ Reactive forms with real-time validation
- ✅ Character counting and SEO previews
- ✅ Automatic dependency installation

### Filament Integration (if selected)
- ✅ Filament resource for SEO management
- ✅ Admin panel integration
- ✅ Advanced filtering and bulk operations
- ✅ Automatic dependency installation

### Example Files (optional)
- ✅ Example controller with SEO usage
- ✅ Example model with HasSeo trait
- ✅ Example Blade template
- ✅ Example Livewire component (if Livewire selected)
- ✅ Example Filament resource (if Filament selected)

## 📁 File Structure After Installation

```
app/
├── Http/Controllers/
│   └── ExampleSeoController.php          # Example controller
├── Models/
│   └── ExamplePost.php                   # Example model with HasSeo trait
├── Livewire/                              # If Livewire selected
│   └── ExampleSeoComponent.php           # Example Livewire component
└── Filament/Resources/                    # If Filament selected
    └── ExamplePostResource.php           # Example Filament resource

config/
└── seo.php                               # SEO configuration

database/migrations/
└── 2024_01_01_000000_create_seo_meta_table.php

resources/views/
├── example-seo.blade.php                 # Example Blade template
└── livewire/                             # If Livewire selected
    └── example-seo-component.blade.php   # Example Livewire view

vendor/laravel-seo-pro/
└── seo-pro/                              # Package files
```

## 🎯 Next Steps

After installation, follow these steps:

### 1. Add HasSeo Trait to Your Models

```php
use LaravelSeoPro\Traits\HasSeo;

class YourModel extends Model
{
    use HasSeo;
    
    public function getSeoUrl()
    {
        return route('your-model.show', $this);
    }
}
```

### 2. Include SEO Components in Your Templates

```blade
<!DOCTYPE html>
<html>
<head>
    <x-seo.meta :model="$yourModel" />
    <x-seo.og :model="$yourModel" />
    <x-seo.twitter :model="$yourModel" />
    <x-seo.json-ld :model="$yourModel" />
</head>
<body>
    <!-- Your content -->
</body>
</html>
```

### 3. Use Livewire Components (if installed)

```blade
<!-- Full SEO Manager -->
<livewire:seo-manager :model="$yourModel" />

<!-- Simple SEO Fields -->
<livewire:seo-fields :model="$yourModel" />
```

### 4. Access Filament Admin (if installed)

Visit `/admin` and look for "SEO Meta" in the navigation menu.

### 5. Run SEO Commands

```bash
# Generate robots.txt
php artisan seo:generate-robots

# Generate sitemap.xml
php artisan seo:generate-sitemap

# Perform SEO audit
php artisan seo:audit

# Attach SEO to existing model
php artisan seo:attach "App\Models\YourModel"
```

## 🔧 Configuration

Edit `config/seo.php` to customize:

- Feature toggles (enable/disable components)
- Default meta values
- Open Graph and Twitter Card defaults
- Robots.txt rules
- Sitemap configuration
- SEO audit settings

## 🆘 Troubleshooting

### Common Issues

**1. Composer dependency installation fails**
```bash
# Install dependencies manually
composer require livewire/livewire
composer require filament/filament
```

**2. Migration fails**
```bash
# Check database connection
php artisan migrate:status
php artisan migrate
```

**3. Livewire components not working**
```bash
# Publish Livewire config
php artisan vendor:publish --tag=livewire:config
```

**4. Filament not accessible**
```bash
# Create Filament user
php artisan make:filament-user
```

### Getting Help

- Check the example files created during installation
- Review the configuration in `config/seo.php`
- Run `php artisan seo:audit` to check for issues
- Check Laravel logs for any errors

## 🎉 You're Ready!

Your Laravel SEO Pro installation is complete! Start by adding the HasSeo trait to your models and including the SEO components in your Blade templates.
