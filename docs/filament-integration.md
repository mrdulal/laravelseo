# Filament Integration

Laravel SEO Pro provides comprehensive Filament integration for managing SEO settings through a beautiful admin interface.

## Installation

### 1. Install the Package

```bash
composer require laravel-seo-pro/seo-pro
```

### 2. Install Filament Components

```bash
php artisan seo:install-filament
```

This command will:
- Publish configuration files
- Run database migrations
- Publish views
- Generate initial robots.txt and sitemap

## Features

### SEO Dashboard
- Overview statistics and completion rates
- SEO audit results with visual charts
- Performance tracking over time
- Quick action buttons

### SEO Meta Management
- Complete CRUD interface for SEO meta records
- Organized form sections for different meta types
- Real-time validation and character counting
- Bulk operations support

### Sitemap Manager
- Generate and preview XML sitemaps
- Submit sitemaps to search engines
- Visual sitemap configuration

### Robots.txt Manager
- Generate and preview robots.txt files
- Test robots.txt with Google tools
- Visual robots.txt configuration

## Usage

### Accessing the Admin Interface

After installation, you'll find the SEO section in your Filament admin panel:

- **SEO Dashboard**: `/admin/seo-dashboard`
- **SEO Meta**: `/admin/seo-meta`
- **Sitemap Manager**: `/admin/sitemap-manager`
- **Robots Manager**: `/admin/robots-manager`

### Using SEO Fields in Your Forms

You can easily add SEO fields to any Filament form:

```php
use LaravelSeoPro\Filament\Components\SeoFields;

// In your Filament resource form method
public static function form(Form $form): Form
{
    return $form
        ->schema([
            // Your existing form fields
            TextInput::make('title'),
            Textarea::make('content'),
            
            // Add SEO fields
            ...SeoFields::make('seo'),
        ]);
}
```

### Managing SEO for Models

The package automatically handles SEO meta for models that use the `HasSeo` trait:

```php
use LaravelSeoPro\Traits\HasSeo;

class Post extends Model
{
    use HasSeo;
    
    // Your model code...
}
```

### Customizing SEO Fields

You can customize the SEO fields by extending the `SeoFields` component:

```php
use LaravelSeoPro\Filament\Components\SeoFields;

class CustomSeoFields extends SeoFields
{
    public static function make(string $name = 'seo'): array
    {
        $fields = parent::make($name);
        
        // Add custom fields or modify existing ones
        $fields[0]->schema[0]->tabs[0]->schema[] = 
            TextInput::make($name . '.custom_field')
                ->label('Custom SEO Field');
        
        return $fields;
    }
}
```

## Configuration

### SEO Configuration

The package uses the `config/seo.php` file for configuration. Key settings include:

```php
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
    'dashboard' => true, // Enable Filament dashboard
],
```

### Filament Configuration

The Filament integration is automatically registered when Filament is detected. You can customize the navigation:

```php
// In your Filament panel provider
protected function getNavigationGroups(): array
{
    return [
        'SEO' => 'SEO Management',
        // Your other navigation groups...
    ];
}
```

## Widgets

### SEO Overview Widget

Displays key SEO metrics:
- Total SEO records
- Completion rate
- Open Graph tags count
- Twitter Cards count

### SEO Audit Widget

Shows missing SEO elements in a doughnut chart:
- Missing titles
- Missing descriptions
- Missing keywords
- Missing OG tags
- Missing Twitter tags
- Missing canonical URLs

### SEO Performance Widget

Tracks SEO record creation over time with a line chart.

## Pages

### SEO Dashboard

Main dashboard with overview widgets and quick actions.

### Sitemap Manager

Manage XML sitemap generation and submission.

### Robots Manager

Manage robots.txt file generation and testing.

## Commands

### Installation Command

```bash
php artisan seo:install-filament
```

### Generate Commands

```bash
# Generate robots.txt
php artisan seo:generate-robots

# Generate sitemap
php artisan seo:generate-sitemap

# Run SEO audit
php artisan seo:audit
```

## Customization

### Custom Widgets

Create custom widgets by extending Filament's widget classes:

```php
use Filament\Widgets\StatsOverviewWidget;

class CustomSeoWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            // Your custom stats
        ];
    }
}
```

### Custom Pages

Create custom pages by extending Filament's Page class:

```php
use Filament\Pages\Page;

class CustomSeoPage extends Page
{
    protected static string $view = 'seo::custom-page';
    
    // Your custom page logic
}
```

## Troubleshooting

### Common Issues

1. **Filament not detected**: Ensure Filament is properly installed and configured
2. **Widgets not showing**: Check that widgets are registered in the plugin
3. **Navigation not appearing**: Verify the plugin is registered in your panel provider

### Debug Mode

Enable debug mode in your `.env` file:

```env
APP_DEBUG=true
LOG_LEVEL=debug
```

This will provide detailed error messages for troubleshooting.

## Support

For issues and questions:
- Check the [GitHub Issues](https://github.com/laravel-seo-pro/seo-pro/issues)
- Read the [Documentation](https://laravel-seo-pro.com/docs)
- Join our [Discord Community](https://discord.gg/laravel-seo-pro)
