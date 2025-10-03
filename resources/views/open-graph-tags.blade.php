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
