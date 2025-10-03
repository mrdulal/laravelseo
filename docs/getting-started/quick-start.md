# Quick Start

Get up and running with Laravel SEO Pro in just a few minutes!

## Installation

```bash
composer require laravel-seo-pro/seo-pro
php artisan seo:install
```

## Basic Usage

### 1. Add HasSeo Trait to Your Models

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelSeoPro\Traits\HasSeo;

class Post extends Model
{
    use HasSeo;

    protected $fillable = [
        'title',
        'content',
        'featured_image',
    ];

    public function getSeoUrl()
    {
        return route('posts.show', $this);
    }

    public function getSeoTitle()
    {
        return $this->title . ' - My Blog';
    }

    public function getSeoDescription()
    {
        return \Str::limit(strip_tags($this->content), 160);
    }
}
```

### 2. Include SEO Components in Your Templates

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Include SEO components -->
    <x-seo.meta :model="$post" />
    <x-seo.og :model="$post" />
    <x-seo.twitter :model="$post" />
    <x-seo.json-ld :model="$post" />
    
    <title>My Blog</title>
</head>
<body>
    <h1>{{ $post->title }}</h1>
    <div>{{ $post->content }}</div>
</body>
</html>
```

### 3. Use the Seo Facade

```php
<?php

namespace App\Http\Controllers;

use LaravelSeoPro\Facades\Seo;

class PostController extends Controller
{
    public function show(Post $post)
    {
        // Load SEO data from model
        Seo::loadFromModel($post);
        
        // Or set SEO data manually
        Seo::setTitle($post->title . ' - My Blog')
           ->setDescription('Read about ' . $post->title)
           ->setKeywords('blog, ' . $post->title)
           ->setOpenGraph('og:image', $post->featured_image);

        return view('posts.show', compact('post'));
    }
}
```

## Livewire Integration

If you installed with Livewire support:

### 1. Use Livewire Components

```blade
<!-- Full SEO Manager -->
<livewire:seo-manager :model="$post" />

<!-- Simple SEO Fields -->
<livewire:seo-fields :model="$post" />
```

### 2. Create Custom Livewire Components

```php
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use LaravelSeoPro\Facades\Seo;

class PostSeoManager extends Component
{
    public $post;
    public $seoData = [];

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->loadSeoData();
    }

    public function loadSeoData()
    {
        Seo::loadFromModel($this->post);
        $this->seoData = Seo::getAllMeta();
    }

    public function updateSeo($data)
    {
        $this->post->updateSeoMeta($data);
        $this->loadSeoData();
        
        $this->dispatch('seo-updated');
        session()->flash('message', 'SEO data updated successfully!');
    }

    public function render()
    {
        return view('livewire.post-seo-manager');
    }
}
```

## Filament Integration

If you installed with Filament support:

### 1. Access Admin Panel

Visit `/admin` and look for "SEO Meta" in the navigation menu.

### 2. Create Custom Filament Resources

```php
<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Post;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->rows(10),
                
                // SEO Section
                Forms\Components\Section::make('SEO Settings')
                    ->schema([
                        Forms\Components\TextInput::make('seo.title')
                            ->label('SEO Title')
                            ->maxLength(60),
                        
                        Forms\Components\Textarea::make('seo.description')
                            ->label('SEO Description')
                            ->maxLength(160),
                        
                        Forms\Components\TextInput::make('seo.keywords')
                            ->label('Keywords'),
                        
                        Forms\Components\TextInput::make('seo.og_image')
                            ->label('Open Graph Image')
                            ->url(),
                    ])
                    ->collapsible(),
            ]);
    }
}
```

## Advanced Usage

### JSON-LD Schema

```php
use LaravelSeoPro\Facades\Seo;

// Article schema
Seo::setJsonLd([
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $post->title,
    'author' => [
        '@type' => 'Person',
        'name' => $post->author->name
    ],
    'datePublished' => $post->created_at->toISOString(),
    'dateModified' => $post->updated_at->toISOString()
]);

// Organization schema
Seo::addJsonLd([
    '@type' => 'Organization',
    'name' => 'My Company',
    'url' => 'https://example.com',
    'logo' => 'https://example.com/logo.png'
]);
```

### Custom Meta Tags

```php
use LaravelSeoPro\Facades\Seo;

// Add custom meta tags
Seo::addMeta('custom-tag', 'custom-value')
   ->addMeta('another-tag', 'another-value');

// Set additional meta data
Seo::setAdditionalMeta([
    'theme-color' => '#ffffff',
    'msapplication-TileColor' => '#da532c',
    'msapplication-config' => '/browserconfig.xml'
]);
```

### Robots.txt and Sitemap

```bash
# Generate robots.txt
php artisan seo:generate-robots

# Generate sitemap.xml
php artisan seo:generate-sitemap

# Perform SEO audit
php artisan seo:audit

# Attach SEO to existing model
php artisan seo:attach "App\Models\Post"
```

## Configuration

Edit `config/seo.php` to customize:

- Feature toggles (enable/disable components)
- Default meta values
- Open Graph and Twitter Card defaults
- Robots.txt rules
- Sitemap configuration
- SEO audit settings

## Next Steps

- [Configuration Guide](configuration/README.md)
- [Blade Components](components/blade-components.md)
- [Livewire Components](components/livewire-components.md)
- [Filament Integration](components/filament-integration.md)
- [Examples](examples/README.md)
