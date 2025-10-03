# Blade Components

Laravel SEO Pro provides several Blade components for easy integration into your templates.

## Available Components

### Meta Tags Component

The `<x-seo.meta />` component renders all basic meta tags.

```blade
<x-seo.meta :model="$post" />
```

**Renders:**
```html
<title>Post Title - My Blog</title>
<meta name="description" content="Post description">
<meta name="keywords" content="blog, post, laravel">
<meta name="author" content="John Doe">
<meta name="robots" content="index, follow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="canonical" href="https://example.com/posts/1">
```

### Open Graph Component

The `<x-seo.og />` component renders Open Graph meta tags for social media.

```blade
<x-seo.og :model="$post" />
```

**Renders:**
```html
<meta property="og:title" content="Post Title - My Blog">
<meta property="og:description" content="Post description">
<meta property="og:type" content="article">
<meta property="og:url" content="https://example.com/posts/1">
<meta property="og:site_name" content="My Blog">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="https://example.com/images/post.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
```

### Twitter Card Component

The `<x-seo.twitter />` component renders Twitter Card meta tags.

```blade
<x-seo.twitter :model="$post" />
```

**Renders:**
```html
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@myblog">
<meta name="twitter:creator" content="@johndoe">
<meta name="twitter:title" content="Post Title - My Blog">
<meta name="twitter:description" content="Post description">
<meta name="twitter:image" content="https://example.com/images/post.jpg">
```

### JSON-LD Component

The `<x-seo.json-ld />` component renders structured data markup.

```blade
<x-seo.json-ld :model="$post" />
```

**Renders:**
```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Post Title",
  "author": {
    "@type": "Person",
    "name": "John Doe"
  },
  "datePublished": "2024-01-01T00:00:00+00:00",
  "dateModified": "2024-01-01T00:00:00+00:00"
}
</script>
```

## Usage Examples

### Basic Usage

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Include all SEO components -->
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

### Without Model

You can also use components without passing a model:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <x-seo.meta />
    <x-seo.og />
    <x-seo.twitter />
    <x-seo.json-ld />
</head>
<body>
    <!-- Your content -->
</body>
</html>
```

### Conditional Rendering

```blade
@if(config('seo.features.meta_tags'))
    <x-seo.meta :model="$post" />
@endif

@if(config('seo.features.open_graph'))
    <x-seo.og :model="$post" />
@endif

@if(config('seo.features.twitter_cards'))
    <x-seo.twitter :model="$post" />
@endif

@if(config('seo.features.json_ld'))
    <x-seo.json-ld :model="$post" />
@endif
```

## Customization

### Override Component Views

Publish the component views to customize them:

```bash
php artisan vendor:publish --provider="LaravelSeoPro\SeoProServiceProvider" --tag="seo-views"
```

This will create the views in `resources/views/vendor/seo/components/` where you can customize them.

### Custom Data

You can pass custom data to components:

```blade
<x-seo.meta :model="$post" :custom-data="['custom' => 'value']" />
```

### Component Attributes

All components support standard HTML attributes:

```blade
<x-seo.meta :model="$post" class="seo-meta" data-custom="value" />
```

## Configuration

Components respect the configuration in `config/seo.php`:

```php
'features' => [
    'meta_tags' => true,
    'open_graph' => true,
    'twitter_cards' => true,
    'json_ld' => true,
],

'defaults' => [
    'title' => 'Laravel Application',
    'description' => 'A Laravel application',
    'keywords' => 'laravel, php, web development',
    'author' => 'Laravel Developer',
    'robots' => 'index, follow',
],
```

## Troubleshooting

### Components Not Rendering

1. Check if the feature is enabled in `config/seo.php`
2. Verify the model has the `HasSeo` trait
3. Check Laravel logs for errors

### Missing Data

1. Ensure the model has SEO data
2. Check if the model implements the required methods
3. Verify the Seo facade is working correctly

### Custom Styling

If you need to style the components, you can:

1. Override the component views
2. Add CSS classes to the components
3. Use CSS to target the generated HTML

## Best Practices

1. **Always pass a model** when available for better SEO data
2. **Use conditional rendering** to respect user preferences
3. **Customize default values** in the configuration
4. **Test your components** with different data scenarios
5. **Keep components updated** with the latest package version
