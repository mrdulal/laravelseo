@if(config('seo.features.meta_tags'))
    <title>{{ $meta['title'] ?? config('seo.defaults.title') }}</title>
    <meta name="description" content="{{ $meta['description'] ?? config('seo.defaults.description') }}">
    <meta name="keywords" content="{{ $meta['keywords'] ?? config('seo.defaults.keywords') }}">
    <meta name="author" content="{{ $meta['author'] ?? config('seo.defaults.author') }}">
    <meta name="robots" content="{{ $meta['robots'] ?? config('seo.defaults.robots') }}">
    <meta name="viewport" content="{{ $meta['viewport'] ?? config('seo.defaults.viewport') }}">
    
    @if(isset($meta['canonical_url']))
        <link rel="canonical" href="{{ $meta['canonical_url'] }}">
    @endif

    @if(isset($meta['additional_meta']) && is_array($meta['additional_meta']))
        @foreach($meta['additional_meta'] as $name => $content)
            <meta name="{{ $name }}" content="{{ $content }}">
        @endforeach
    @endif
@endif
