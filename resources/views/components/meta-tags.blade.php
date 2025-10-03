@if(config('seo.features.meta_tags', true))
    <title>{{ $meta['title'] ?? config('seo.defaults.title', 'Laravel Application') }}</title>
    <meta name="description" content="{{ $meta['description'] ?? config('seo.defaults.description', 'A Laravel application') }}">
    <meta name="keywords" content="{{ $meta['keywords'] ?? config('seo.defaults.keywords', 'laravel, php, web development') }}">
    <meta name="author" content="{{ $meta['author'] ?? config('seo.defaults.author', 'Laravel Developer') }}">
    <meta name="robots" content="{{ $meta['robots'] ?? config('seo.defaults.robots', 'index, follow') }}">
    <meta name="viewport" content="{{ $meta['viewport'] ?? config('seo.defaults.viewport', 'width=device-width, initial-scale=1.0') }}">
    
    @if(isset($meta['canonical_url']) && $meta['canonical_url'])
        <link rel="canonical" href="{{ $meta['canonical_url'] }}">
    @endif

    @if(isset($meta['additional_meta']) && is_array($meta['additional_meta']))
        @foreach($meta['additional_meta'] as $name => $content)
            @if($name && $content)
                <meta name="{{ $name }}" content="{{ $content }}">
            @endif
        @endforeach
    @endif
@endif
