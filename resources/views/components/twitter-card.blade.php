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
