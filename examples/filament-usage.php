<?php

/**
 * Laravel SEO Pro - Filament Integration Example
 * 
 * This example shows how to integrate Laravel SEO Pro with Filament
 * for comprehensive SEO management in your Laravel application.
 */

// 1. Install the package
// composer require laravel-seo-pro/seo-pro

// 2. Install Filament components
// php artisan seo:install-filament

// 3. Add SEO fields to your Filament resources

use Filament\Forms\Form;
use Filament\Resources\Resource;
use LaravelSeoPro\Filament\Components\SeoFields;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Your existing form fields
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                
                Textarea::make('content')
                    ->required()
                    ->rows(10),
                
                // Add SEO fields
                ...SeoFields::make('seo'),
            ]);
    }
}

// 4. Use the HasSeo trait in your models

use LaravelSeoPro\Traits\HasSeo;

class Post extends Model
{
    use HasSeo;
    
    protected $fillable = [
        'title',
        'content',
        'slug',
    ];
}

// 5. Access the SEO admin interface
// Visit: /admin/seo-dashboard
// Visit: /admin/seo-meta
// Visit: /admin/sitemap-manager
// Visit: /admin/robots-manager

// 6. Generate SEO meta programmatically

use LaravelSeoPro\Facades\Seo;

// In your controller or service
$post = Post::find(1);

// Set SEO meta
$post->seo()->updateOrCreate([], [
    'title' => 'My Amazing Post Title',
    'description' => 'This is a great post about Laravel SEO Pro',
    'keywords' => 'laravel, seo, filament, php',
    'og_title' => 'My Amazing Post Title',
    'og_description' => 'This is a great post about Laravel SEO Pro',
    'og_image' => 'https://example.com/image.jpg',
    'twitter_title' => 'My Amazing Post Title',
    'twitter_description' => 'This is a great post about Laravel SEO Pro',
    'twitter_image' => 'https://example.com/image.jpg',
]);

// 7. Display SEO meta in your views

// In your Blade template
@seo([
    'title' => $post->seo?->title ?? $post->title,
    'description' => $post->seo?->description ?? $post->excerpt,
    'keywords' => $post->seo?->keywords,
    'og_title' => $post->seo?->og_title ?? $post->title,
    'og_description' => $post->seo?->og_description ?? $post->excerpt,
    'og_image' => $post->seo?->og_image ?? $post->featured_image,
    'twitter_title' => $post->seo?->twitter_title ?? $post->title,
    'twitter_description' => $post->seo?->twitter_description ?? $post->excerpt,
    'twitter_image' => $post->seo?->twitter_image ?? $post->featured_image,
])

// 8. Generate sitemap and robots.txt

// Generate sitemap
php artisan seo:generate-sitemap

// Generate robots.txt
php artisan seo:generate-robots

// 9. Run SEO audit

// Check for missing SEO elements
php artisan seo:audit

// 10. Customize SEO configuration

// In config/seo.php
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
        'dashboard' => true, // Enable Filament dashboard
    ],
    
    'defaults' => [
        'title' => 'My Website',
        'description' => 'Welcome to my amazing website',
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

// 11. Use SEO middleware for automatic auditing

// In your routes/web.php
Route::middleware(['seo.audit'])->group(function () {
    Route::get('/posts/{post}', [PostController::class, 'show']);
});

// 12. Customize Filament navigation

// In your Filament panel provider
protected function getNavigationGroups(): array
{
    return [
        'Content' => 'Content Management',
        'SEO' => 'SEO Management',
        'Settings' => 'System Settings',
    ];
}

// 13. Add custom SEO fields

use LaravelSeoPro\Filament\Components\SeoFields;

class CustomSeoFields extends SeoFields
{
    public static function make(string $name = 'seo'): array
    {
        $fields = parent::make($name);
        
        // Add custom fields
        $fields[0]->schema[0]->tabs[0]->schema[] = 
            TextInput::make($name . '.custom_field')
                ->label('Custom SEO Field')
                ->helperText('This is a custom SEO field');
        
        return $fields;
    }
}

// 14. Use in your Filament resource

class PostResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Your existing fields
                TextInput::make('title'),
                Textarea::make('content'),
                
                // Custom SEO fields
                ...CustomSeoFields::make('seo'),
            ]);
    }
}
