<?php

/**
 * Laravel SEO Pro - Usage Examples
 * 
 * This file demonstrates various ways to use the Laravel SEO Pro package.
 */

use LaravelSeoPro\Facades\Seo;
use LaravelSeoPro\Traits\HasSeo;

// Example 1: Basic SEO setup in a controller
class HomeController extends Controller
{
    public function index()
    {
        // Set basic meta tags
        Seo::setTitle('Welcome to My Website')
           ->setDescription('This is the homepage of my amazing website')
           ->setKeywords('homepage, welcome, website')
           ->setAuthor('John Doe');

        // Set Open Graph data
        Seo::setOpenGraph('og:title', 'Welcome to My Website')
           ->setOpenGraph('og:description', 'This is the homepage of my amazing website')
           ->setOpenGraph('og:image', 'https://example.com/homepage-image.jpg')
           ->setOpenGraph('og:type', 'website');

        // Set Twitter Card data
        Seo::setTwitterCard('twitter:card', 'summary_large_image')
           ->setTwitterCard('twitter:title', 'Welcome to My Website')
           ->setTwitterCard('twitter:description', 'This is the homepage of my amazing website')
           ->setTwitterCard('twitter:image', 'https://example.com/homepage-image.jpg');

        // Set JSON-LD schema
        Seo::setJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'My Website',
            'url' => 'https://example.com',
            'description' => 'This is the homepage of my amazing website'
        ]);

        return view('home');
    }
}

// Example 2: Using with a model that has HasSeo trait
class Post extends Model
{
    use HasSeo;

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
        return Str::limit(strip_tags($this->content), 160);
    }
}

// Example 3: Controller method for a blog post
class PostController extends Controller
{
    public function show(Post $post)
    {
        // Load SEO data from the model
        Seo::loadFromModel($post);

        // Override or add additional SEO data
        Seo::setOpenGraph('og:image', $post->featured_image)
           ->setJsonLd([
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

        return view('posts.show', compact('post'));
    }
}

// Example 4: Blade template usage
/*
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Include all SEO meta tags -->
    <x-seo.meta />
    <x-seo.og />
    <x-seo.twitter />
    <x-seo.json-ld />
    
    <!-- Or include them individually -->
    <x-seo.meta />
    <x-seo.og />
    <x-seo.twitter />
    <x-seo.json-ld />
</head>
<body>
    <h1>{{ $post->title }}</h1>
    <div>{{ $post->content }}</div>
</body>
</html>
*/

// Example 5: Artisan commands usage
/*
# Generate robots.txt
php artisan seo:generate-robots

# Generate sitemap.xml
php artisan seo:generate-sitemap

# Attach SEO trait to a model
php artisan seo:attach "App\Models\Post"

# Perform SEO audit
php artisan seo:audit https://example.com
*/

// Example 6: Middleware usage
/*
// In your routes/web.php
Route::middleware(['seo.audit'])->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
});
*/

// Example 7: Custom SEO configuration
/*
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
        'dashboard' => false,
    ],
    
    'defaults' => [
        'title' => 'My Website',
        'description' => 'Welcome to my website',
        'keywords' => 'website, laravel, seo',
        'author' => 'John Doe',
        'robots' => 'index, follow',
    ],
    
    'sitemap' => [
        'models' => [
            \App\Models\Post::class,
            \App\Models\Page::class,
        ],
        'urls' => [
            ['url' => '/about', 'lastmod' => '2024-01-01', 'priority' => '0.8'],
            ['url' => '/contact', 'lastmod' => '2024-01-01', 'priority' => '0.7'],
        ],
    ],
];
*/
