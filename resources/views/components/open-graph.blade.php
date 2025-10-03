@if(config('seo.features.open_graph', true))
    <meta property="og:title" content="{{ $openGraph['og:title'] ?? $openGraph['title'] ?? config('seo.defaults.title', 'Laravel Application') }}">
    <meta property="og:description" content="{{ $openGraph['og:description'] ?? $openGraph['description'] ?? config('seo.defaults.description', 'A Laravel application') }}">
    <meta property="og:type" content="{{ $openGraph['og:type'] ?? config('seo.open_graph.type', 'website') }}">
    <meta property="og:url" content="{{ $openGraph['og:url'] ?? request()->url() }}">
    <meta property="og:site_name" content="{{ $openGraph['og:site_name'] ?? config('seo.open_graph.site_name', 'Laravel Application') }}">
    <meta property="og:locale" content="{{ $openGraph['og:locale'] ?? config('seo.open_graph.locale', 'en_US') }}">
    
    @if(isset($openGraph['og:image']) && $openGraph['og:image'])
        <meta property="og:image" content="{{ $openGraph['og:image'] }}">
        <meta property="og:image:width" content="{{ $openGraph['og:image:width'] ?? config('seo.open_graph.image_width', 1200) }}">
        <meta property="og:image:height" content="{{ $openGraph['og:image:height'] ?? config('seo.open_graph.image_height', 630) }}">
    @endif
@endif
