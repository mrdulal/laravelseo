@if(config('seo.features.meta_tags', true))
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="author" content="{{ $author }}">
    <meta name="robots" content="{{ $robots }}">
    <meta name="viewport" content="{{ config('seo.defaults.viewport', 'width=device-width, initial-scale=1.0') }}">
    
    @if($canonicalUrl)
        <link rel="canonical" href="{{ $canonicalUrl }}">
    @endif

    @if($additionalMeta && is_array($additionalMeta))
        @foreach($additionalMeta as $name => $content)
            @if($name && $content)
                <meta name="{{ $name }}" content="{{ $content }}">
            @endif
        @endforeach
    @endif
@endif

@if(config('seo.features.open_graph', true))
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:site_name" content="{{ $ogSiteName }}">
    <meta property="og:locale" content="{{ $ogLocale }}">
    
    @if($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:image:width" content="{{ config('seo.open_graph.image_width', 1200) }}">
        <meta property="og:image:height" content="{{ config('seo.open_graph.image_height', 630) }}">
    @endif
    
    @if($ogUrl)
        <meta property="og:url" content="{{ $ogUrl }}">
    @endif
@endif

@if(config('seo.features.twitter_cards', true))
    <meta name="twitter:card" content="{{ $twitterCard }}">
    <meta name="twitter:title" content="{{ $twitterTitle }}">
    <meta name="twitter:description" content="{{ $twitterDescription }}">
    
    @if($twitterSite)
        <meta name="twitter:site" content="{{ $twitterSite }}">
    @endif
    
    @if($twitterCreator)
        <meta name="twitter:creator" content="{{ $twitterCreator }}">
    @endif
    
    @if($twitterImage)
        <meta name="twitter:image" content="{{ $twitterImage }}">
    @endif
@endif

@if(config('seo.features.json_ld', true) && $jsonLd && is_array($jsonLd) && count($jsonLd) > 0)
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        @foreach($jsonLd as $key => $value)
            "@{{ $key }}": {!! is_array($value) ? json_encode($value) : '"' . $value . '"' !!}{{ $loop->last ? '' : ',' }}
        @endforeach
    }
    </script>
@endif
