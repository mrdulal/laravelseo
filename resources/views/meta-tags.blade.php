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

@if(config('seo.features.open_graph'))
    <meta property="og:title" content="{{ $open_graph['og:title'] ?? $open_graph['title'] ?? config('seo.defaults.title') }}">
    <meta property="og:description" content="{{ $open_graph['og:description'] ?? $open_graph['description'] ?? config('seo.defaults.description') }}">
    <meta property="og:type" content="{{ $open_graph['og:type'] ?? config('seo.open_graph.type') }}">
    <meta property="og:url" content="{{ $open_graph['og:url'] ?? request()->url() }}">
    <meta property="og:site_name" content="{{ $open_graph['og:site_name'] ?? config('seo.open_graph.site_name') }}">
    <meta property="og:locale" content="{{ $open_graph['og:locale'] ?? config('seo.open_graph.locale') }}">
    
    @if(isset($open_graph['og:image']))
        <meta property="og:image" content="{{ $open_graph['og:image'] }}">
        <meta property="og:image:width" content="{{ $open_graph['og:image:width'] ?? config('seo.open_graph.image_width') }}">
        <meta property="og:image:height" content="{{ $open_graph['og:image:height'] ?? config('seo.open_graph.image_height') }}">
    @endif
@endif

@if(config('seo.features.twitter_cards'))
    <meta name="twitter:card" content="{{ $twitter['twitter:card'] ?? config('seo.twitter.card') }}">
    <meta name="twitter:site" content="{{ $twitter['twitter:site'] ?? config('seo.twitter.site') }}">
    <meta name="twitter:creator" content="{{ $twitter['twitter:creator'] ?? config('seo.twitter.creator') }}">
    <meta name="twitter:title" content="{{ $twitter['twitter:title'] ?? config('seo.defaults.title') }}">
    <meta name="twitter:description" content="{{ $twitter['twitter:description'] ?? config('seo.defaults.description') }}">
    
    @if(isset($twitter['twitter:image']))
        <meta name="twitter:image" content="{{ $twitter['twitter:image'] }}">
    @endif
@endif

@if(config('seo.features.json_ld') && !empty($json_ld))
    <script type="application/ld+json">
        {!! json_encode($json_ld, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endif
