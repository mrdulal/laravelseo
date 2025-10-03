# Basic Usage Examples

This guide provides practical examples of using Laravel SEO Pro in your Laravel application.

## Controller Examples

### Basic Controller with SEO

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelSeoPro\Facades\Seo;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        
        // Set SEO for the index page
        Seo::setTitle('Blog Posts - My Website')
           ->setDescription('Read our latest blog posts about web development, Laravel, and more.')
           ->setKeywords('blog, posts, web development, laravel, php')
           ->setAuthor('My Website');

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        // Load SEO data from the model
        Seo::loadFromModel($post);
        
        // Override or add additional SEO data
        Seo::setOpenGraph('og:image', $post->featured_image)
           ->setTwitterCard('twitter:image', $post->featured_image)
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
```

### Homepage Controller

```php
<?php

namespace App\Http\Controllers;

use LaravelSeoPro\Facades\Seo;

class HomeController extends Controller
{
    public function index()
    {
        // Set homepage SEO
        Seo::setTitle('Welcome to My Website')
           ->setDescription('Discover amazing content, products, and services on our website.')
           ->setKeywords('homepage, welcome, website, services, products')
           ->setAuthor('My Company')
           ->setOpenGraphData([
               'og:title' => 'Welcome to My Website',
               'og:description' => 'Discover amazing content, products, and services on our website.',
               'og:image' => asset('images/homepage-hero.jpg'),
               'og:type' => 'website',
               'og:url' => url('/'),
               'og:site_name' => 'My Website'
           ])
           ->setTwitterCardData([
               'twitter:card' => 'summary_large_image',
               'twitter:site' => '@mywebsite',
               'twitter:title' => 'Welcome to My Website',
               'twitter:description' => 'Discover amazing content, products, and services on our website.',
               'twitter:image' => asset('images/homepage-hero.jpg')
           ])
           ->setJsonLd([
               '@context' => 'https://schema.org',
               '@type' => 'WebSite',
               'name' => 'My Website',
               'url' => url('/'),
               'description' => 'Discover amazing content, products, and services on our website.',
               'potentialAction' => [
                   '@type' => 'SearchAction',
                   'target' => url('/search?q={search_term_string}'),
                   'query-input' => 'required name=search_term_string'
               ]
           ]);

        return view('home');
    }
}
```

## Model Examples

### Post Model with SEO

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
        'excerpt',
        'featured_image',
        'author_id',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // SEO Methods
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
        return $this->excerpt ?: \Str::limit(strip_tags($this->content), 160);
    }

    public function getSeoKeywords()
    {
        return $this->tags->pluck('name')->join(', ');
    }

    public function getSeoImage()
    {
        return $this->featured_image ?: asset('images/default-post.jpg');
    }

    public function getSeoType()
    {
        return 'article';
    }

    public function getSeoSiteName()
    {
        return 'My Blog';
    }

    public function getSeoLocale()
    {
        return 'en_US';
    }
}
```

### Product Model with SEO

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelSeoPro\Traits\HasSeo;

class Product extends Model
{
    use HasSeo;

    protected $fillable = [
        'name',
        'description',
        'price',
        'sku',
        'image',
        'category_id',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // SEO Methods
    public function getSeoUrl()
    {
        return route('products.show', $this);
    }

    public function getSeoTitle()
    {
        return $this->name . ' - My Store';
    }

    public function getSeoDescription()
    {
        return $this->description ?: 'Buy ' . $this->name . ' online at My Store.';
    }

    public function getSeoKeywords()
    {
        return $this->name . ', ' . $this->category->name . ', buy online, my store';
    }

    public function getSeoImage()
    {
        return $this->image ?: asset('images/default-product.jpg');
    }

    public function getSeoType()
    {
        return 'product';
    }

    public function getSeoSiteName()
    {
        return 'My Store';
    }

    public function getSeoJsonLd()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->getSeoImage(),
            'sku' => $this->sku,
            'offers' => [
                '@type' => 'Offer',
                'price' => $this->price,
                'priceCurrency' => 'USD',
                'availability' => $this->status === 'active' ? 'InStock' : 'OutOfStock'
            ]
        ];
    }
}
```

## Blade Template Examples

### Basic Layout with SEO

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- SEO Components -->
    <x-seo.meta :model="$model ?? null" />
    <x-seo.og :model="$model ?? null" />
    <x-seo.twitter :model="$model ?? null" />
    <x-seo.json-ld :model="$model ?? null" />
    
    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="#ffffff">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')
        
        <main>
            @yield('content')
        </main>
        
        @include('layouts.footer')
    </div>
</body>
</html>
```

### Post Show Template

```blade
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <article class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($post->featured_image)
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
        @endif
        
        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
            
            <div class="flex items-center text-sm text-gray-600 mb-4">
                <span>By {{ $post->author->name }}</span>
                <span class="mx-2">•</span>
                <time datetime="{{ $post->created_at->toISOString() }}">
                    {{ $post->created_at->format('F j, Y') }}
                </time>
            </div>
            
            <div class="prose max-w-none">
                {!! $post->content !!}
            </div>
            
            @if($post->tags->count())
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-2">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </article>
</div>
@endsection
```

### Product Show Template

```blade
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/2">
                <img src="{{ $product->image ?: asset('images/default-product.jpg') }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-96 object-cover">
            </div>
            
            <div class="md:w-1/2 p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                
                <div class="text-2xl font-bold text-green-600 mb-4">
                    ${{ number_format($product->price, 2) }}
                </div>
                
                <div class="text-gray-700 mb-6">
                    {!! $product->description !!}
                </div>
                
                <div class="mb-4">
                    <span class="text-sm text-gray-600">SKU: {{ $product->sku }}</span>
                </div>
                
                <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
```

## Service Provider Examples

### Custom SEO Service

```php
<?php

namespace App\Services;

use LaravelSeoPro\Facades\Seo;

class SeoService
{
    public function setPageSeo($page, $data = [])
    {
        $defaults = [
            'title' => $page->title ?? 'My Website',
            'description' => $page->description ?? 'Welcome to my website',
            'keywords' => $page->keywords ?? 'website, laravel, php',
            'author' => $page->author ?? 'My Company'
        ];

        $seoData = array_merge($defaults, $data);

        Seo::setTitle($seoData['title'])
           ->setDescription($seoData['description'])
           ->setKeywords($seoData['keywords'])
           ->setAuthor($seoData['author']);

        if (isset($seoData['image'])) {
            Seo::setOpenGraph('og:image', $seoData['image'])
               ->setTwitterCard('twitter:image', $seoData['image']);
        }

        return Seo::getAllMeta();
    }

    public function setArticleSeo($article)
    {
        Seo::setTitle($article->title . ' - My Blog')
           ->setDescription($article->excerpt ?: \Str::limit(strip_tags($article->content), 160))
           ->setKeywords($article->tags->pluck('name')->join(', '))
           ->setAuthor($article->author->name)
           ->setOpenGraphData([
               'og:title' => $article->title,
               'og:description' => $article->excerpt ?: \Str::limit(strip_tags($article->content), 160),
               'og:image' => $article->featured_image ?: asset('images/default-article.jpg'),
               'og:type' => 'article',
               'og:url' => route('articles.show', $article),
               'og:site_name' => 'My Blog',
               'og:locale' => 'en_US'
           ])
           ->setJsonLd([
               '@context' => 'https://schema.org',
               '@type' => 'Article',
               'headline' => $article->title,
               'author' => [
                   '@type' => 'Person',
                   'name' => $article->author->name
               ],
               'datePublished' => $article->created_at->toISOString(),
               'dateModified' => $article->updated_at->toISOString()
           ]);

        return Seo::getAllMeta();
    }
}
```

## Middleware Examples

### SEO Audit Middleware

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use LaravelSeoPro\Facades\Seo;

class SeoAuditMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only audit HTML responses
        if ($response->headers->get('Content-Type') && 
            str_contains($response->headers->get('Content-Type'), 'text/html')) {
            
            $this->auditSeo($request, $response);
        }

        return $response;
    }

    protected function auditSeo($request, $response)
    {
        $content = $response->getContent();
        $issues = [];

        // Check for title tag
        if (!preg_match('/<title[^>]*>(.*?)<\/title>/i', $content)) {
            $issues[] = 'Missing title tag';
        }

        // Check for meta description
        if (!preg_match('/<meta[^>]*name=["\']description["\'][^>]*>/i', $content)) {
            $issues[] = 'Missing meta description';
        }

        // Check for Open Graph tags
        if (!preg_match('/<meta[^>]*property=["\']og:title["\'][^>]*>/i', $content)) {
            $issues[] = 'Missing Open Graph title';
        }

        if (!empty($issues)) {
            \Log::warning('SEO Issues on ' . $request->url(), [
                'issues' => $issues,
                'url' => $request->url()
            ]);
        }
    }
}
```

## Best Practices

1. **Always set a title and description** for every page
2. **Use canonical URLs** to prevent duplicate content issues
3. **Include Open Graph tags** for better social media sharing
4. **Add JSON-LD schema** for rich snippets in search results
5. **Keep titles under 60 characters** and descriptions under 160 characters
6. **Use high-quality images** for social media sharing
7. **Test your SEO** using tools like Google's Rich Results Test
8. **Monitor your SEO performance** using Google Search Console
