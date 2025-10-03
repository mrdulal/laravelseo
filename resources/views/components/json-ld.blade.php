@if(config('seo.features.json_ld') && !empty($jsonLd))
    <script type="application/ld+json">
        {!! json_encode($jsonLd, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endif
