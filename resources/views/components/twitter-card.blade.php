@if(config('seo.features.twitter_cards', true))
    <meta name="twitter:card" content="{{ $twitter['twitter:card'] ?? config('seo.twitter.card', 'summary_large_image') }}">
    <meta name="twitter:site" content="{{ $twitter['twitter:site'] ?? config('seo.twitter.site', '@laravel') }}">
    <meta name="twitter:creator" content="{{ $twitter['twitter:creator'] ?? config('seo.twitter.creator', '@laravel') }}">
    <meta name="twitter:title" content="{{ $twitter['twitter:title'] ?? config('seo.defaults.title', 'Laravel Application') }}">
    <meta name="twitter:description" content="{{ $twitter['twitter:description'] ?? config('seo.defaults.description', 'A Laravel application') }}">
    
    @if(isset($twitter['twitter:image']) && $twitter['twitter:image'])
        <meta name="twitter:image" content="{{ $twitter['twitter:image'] }}">
    @endif
@endif
