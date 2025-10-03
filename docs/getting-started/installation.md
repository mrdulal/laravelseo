# Installation

This guide will walk you through installing Laravel SEO Pro in your Laravel application.

## Requirements

- PHP 8.1 or higher
- Laravel 9.0 or higher
- Composer

## Quick Installation

The easiest way to install Laravel SEO Pro is using the interactive installer:

```bash
composer require laravel-seo-pro/seo-pro
php artisan seo:install
```

The installer will guide you through selecting your integration method and automatically set up everything you need.

## Installation Options

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

## Manual Installation

If you prefer manual installation:

### Step 1: Install the Package

```bash
composer require laravel-seo-pro/seo-pro
```

### Step 2: Publish Configuration

```bash
php artisan vendor:publish --provider="LaravelSeoPro\SeoProServiceProvider" --tag="seo-config"
```

### Step 3: Run Migrations

```bash
php artisan vendor:publish --provider="LaravelSeoPro\SeoProServiceProvider" --tag="seo-migrations"
php artisan migrate
```

### Step 4: Publish Views (Optional)

```bash
php artisan vendor:publish --provider="LaravelSeoPro\SeoProServiceProvider" --tag="seo-views"
```

### Step 5: Install Additional Dependencies (Optional)

For Livewire support:
```bash
composer require livewire/livewire
```

For Filament support:
```bash
composer require filament/filament
```

## What Gets Installed

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

## Verification

After installation, verify everything is working:

```bash
# Check if the package is installed
composer show laravel-seo-pro/seo-pro

# Run the SEO audit command
php artisan seo:audit

# Generate robots.txt
php artisan seo:generate-robots

# Generate sitemap
php artisan seo:generate-sitemap
```

## Next Steps

1. [Add the HasSeo trait to your models](quick-start.md#add-has-seo-trait)
2. [Include SEO components in your templates](quick-start.md#include-seo-components)
3. [Configure your SEO settings](configuration/README.md)

## Troubleshooting

### Common Issues

**Composer dependency installation fails**
```bash
# Install dependencies manually
composer require livewire/livewire
composer require filament/filament
```

**Migration fails**
```bash
# Check database connection
php artisan migrate:status
php artisan migrate
```

**Livewire components not working**
```bash
# Publish Livewire config
php artisan vendor:publish --tag=livewire:config
```

**Filament not accessible**
```bash
# Create Filament user
php artisan make:filament-user
```

### Getting Help

- Check the example files created during installation
- Review the configuration in `config/seo.php`
- Run `php artisan seo:audit` to check for issues
- Check Laravel logs for any errors
- Join our [Discord community](https://discord.gg/laravel-seo-pro)
- Report issues on [GitHub](https://github.com/laravel-seo-pro/seo-pro/issues)
