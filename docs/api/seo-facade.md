# Seo Facade

The `Seo` facade provides a simple interface for managing SEO data in your Laravel application.

## Basic Usage

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
    'headline' => 'My Article Title'
]);
```

## Methods

### Meta Tags

#### `setTitle(string $title): self`
Set the page title.

```php
Seo::setTitle('My Page Title');
```

#### `getTitle(): string`
Get the current page title.

```php
$title = Seo::getTitle();
```

#### `setDescription(string $description): self`
Set the page description.

```php
Seo::setDescription('This is my page description');
```

#### `getDescription(): string`
Get the current page description.

```php
$description = Seo::getDescription();
```

#### `setKeywords(string $keywords): self`
Set the page keywords.

```php
Seo::setKeywords('laravel, seo, php');
```

#### `getKeywords(): string`
Get the current page keywords.

```php
$keywords = Seo::getKeywords();
```

#### `setAuthor(string $author): self`
Set the page author.

```php
Seo::setAuthor('John Doe');
```

#### `setRobots(string $robots): self`
Set the robots meta tag.

```php
Seo::setRobots('index, follow');
```

#### `setCanonicalUrl(string $url): self`
Set the canonical URL.

```php
Seo::setCanonicalUrl('https://example.com/page');
```

#### `getCanonicalUrl(): ?string`
Get the current canonical URL.

```php
$url = Seo::getCanonicalUrl();
```

### Open Graph

#### `setOpenGraph(string $property, string $content): self`
Set an Open Graph property.

```php
Seo::setOpenGraph('og:title', 'My Page Title');
Seo::setOpenGraph('og:description', 'My page description');
Seo::setOpenGraph('og:image', 'https://example.com/image.jpg');
```

#### `setOpenGraphData(array $data): self`
Set multiple Open Graph properties at once.

```php
Seo::setOpenGraphData([
    'og:title' => 'My Page Title',
    'og:description' => 'My page description',
    'og:image' => 'https://example.com/image.jpg',
    'og:type' => 'article',
    'og:url' => 'https://example.com/page',
    'og:site_name' => 'My Site',
    'og:locale' => 'en_US'
]);
```

#### `getOpenGraphData(): array`
Get all Open Graph data.

```php
$ogData = Seo::getOpenGraphData();
```

### Twitter Cards

#### `setTwitterCard(string $name, string $content): self`
Set a Twitter Card property.

```php
Seo::setTwitterCard('twitter:card', 'summary_large_image');
Seo::setTwitterCard('twitter:title', 'My Page Title');
Seo::setTwitterCard('twitter:description', 'My page description');
```

#### `setTwitterCardData(array $data): self`
Set multiple Twitter Card properties at once.

```php
Seo::setTwitterCardData([
    'twitter:card' => 'summary_large_image',
    'twitter:site' => '@myblog',
    'twitter:creator' => '@johndoe',
    'twitter:title' => 'My Page Title',
    'twitter:description' => 'My page description',
    'twitter:image' => 'https://example.com/image.jpg'
]);
```

#### `getTwitterCardData(): array`
Get all Twitter Card data.

```php
$twitterData = Seo::getTwitterCardData();
```

### JSON-LD Schema

#### `setJsonLd(array $data): self`
Set JSON-LD schema data.

```php
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

#### `addJsonLd(array $data): self`
Add to existing JSON-LD schema data.

```php
Seo::addJsonLd([
    '@type' => 'Organization',
    'name' => 'My Company',
    'url' => 'https://example.com'
]);
```

#### `getJsonLd(): array`
Get the current JSON-LD schema data.

```php
$jsonLd = Seo::getJsonLd();
```

### Additional Meta Tags

#### `addMeta(string $name, string $content): self`
Add a custom meta tag.

```php
Seo::addMeta('custom-tag', 'custom-value');
Seo::addMeta('theme-color', '#ffffff');
```

#### `setAdditionalMeta(array $meta): self`
Set multiple additional meta tags.

```php
Seo::setAdditionalMeta([
    'theme-color' => '#ffffff',
    'msapplication-TileColor' => '#da532c',
    'msapplication-config' => '/browserconfig.xml'
]);
```

#### `getAdditionalMeta(): array`
Get all additional meta tags.

```php
$additionalMeta = Seo::getAdditionalMeta();
```

### Model Integration

#### `loadFromModel($model): self`
Load SEO data from a model that uses the HasSeo trait.

```php
$post = Post::find(1);
Seo::loadFromModel($post);
```

### Utility Methods

#### `reset(): self`
Reset all SEO data to defaults.

```php
Seo::reset();
```

#### `getAllMeta(): array`
Get all SEO data as an array.

```php
$allMeta = Seo::getAllMeta();
```

#### `renderMetaTags(): string`
Render all meta tags as HTML.

```php
$html = Seo::renderMetaTags();
```

#### `renderOpenGraphTags(): string`
Render Open Graph tags as HTML.

```php
$html = Seo::renderOpenGraphTags();
```

#### `renderTwitterCardTags(): string`
Render Twitter Card tags as HTML.

```php
$html = Seo::renderTwitterCardTags();
```

#### `renderJsonLd(): string`
Render JSON-LD schema as HTML.

```php
$html = Seo::renderJsonLd();
```

### File Generation

#### `generateRobots(): string`
Generate robots.txt content.

```php
$robots = Seo::generateRobots();
```

#### `generateSitemap(): string`
Generate XML sitemap content.

```php
$sitemap = Seo::generateSitemap();
```

## Examples

### Complete SEO Setup

```php
use LaravelSeoPro\Facades\Seo;

// Basic meta tags
Seo::setTitle('My Article Title')
   ->setDescription('This is a great article about Laravel SEO')
   ->setKeywords('laravel, seo, php, web development')
   ->setAuthor('John Doe')
   ->setRobots('index, follow')
   ->setCanonicalUrl('https://example.com/articles/my-article');

// Open Graph
Seo::setOpenGraphData([
    'og:title' => 'My Article Title',
    'og:description' => 'This is a great article about Laravel SEO',
    'og:image' => 'https://example.com/images/article.jpg',
    'og:type' => 'article',
    'og:url' => 'https://example.com/articles/my-article',
    'og:site_name' => 'My Blog',
    'og:locale' => 'en_US'
]);

// Twitter Cards
Seo::setTwitterCardData([
    'twitter:card' => 'summary_large_image',
    'twitter:site' => '@myblog',
    'twitter:creator' => '@johndoe',
    'twitter:title' => 'My Article Title',
    'twitter:description' => 'This is a great article about Laravel SEO',
    'twitter:image' => 'https://example.com/images/article.jpg'
]);

// JSON-LD Schema
Seo::setJsonLd([
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => 'My Article Title',
    'description' => 'This is a great article about Laravel SEO',
    'author' => [
        '@type' => 'Person',
        'name' => 'John Doe',
        'url' => 'https://example.com/authors/john-doe'
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'My Blog',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => 'https://example.com/logo.png'
        ]
    ],
    'datePublished' => '2024-01-01T00:00:00+00:00',
    'dateModified' => '2024-01-01T00:00:00+00:00',
    'image' => 'https://example.com/images/article.jpg'
]);

// Custom meta tags
Seo::setAdditionalMeta([
    'theme-color' => '#ffffff',
    'msapplication-TileColor' => '#da532c'
]);
```

### Using with Models

```php
use LaravelSeoPro\Facades\Seo;

class PostController extends Controller
{
    public function show(Post $post)
    {
        // Load SEO data from model
        Seo::loadFromModel($post);
        
        // Override or add additional data
        Seo::setOpenGraph('og:image', $post->featured_image)
           ->addJsonLd([
               'datePublished' => $post->created_at->toISOString(),
               'dateModified' => $post->updated_at->toISOString()
           ]);

        return view('posts.show', compact('post'));
    }
}
```

## Best Practices

1. **Use method chaining** for cleaner code
2. **Load from models** when possible for consistency
3. **Set canonical URLs** to prevent duplicate content
4. **Use appropriate Open Graph types** for different content
5. **Validate JSON-LD schema** using Google's tool
6. **Keep titles under 60 characters** for better SEO
7. **Keep descriptions under 160 characters** for better display
8. **Use high-quality images** for social media sharing
