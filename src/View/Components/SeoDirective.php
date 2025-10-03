<?php

namespace LaravelSeoPro\View\Components;

use Illuminate\View\Component;
use LaravelSeoPro\Facades\Seo;

class SeoDirective extends Component
{
    public $meta;
    public $model;
    public $title;
    public $description;
    public $keywords;
    public $author;
    public $robots;
    public $canonicalUrl;
    public $ogTitle;
    public $ogDescription;
    public $ogImage;
    public $ogType;
    public $ogUrl;
    public $ogSiteName;
    public $ogLocale;
    public $twitterCard;
    public $twitterSite;
    public $twitterCreator;
    public $twitterTitle;
    public $twitterDescription;
    public $twitterImage;
    public $jsonLd;
    public $additionalMeta;

    public function __construct(
        $model = null,
        $title = null,
        $description = null,
        $keywords = null,
        $author = null,
        $robots = null,
        $canonicalUrl = null,
        $ogTitle = null,
        $ogDescription = null,
        $ogImage = null,
        $ogType = null,
        $ogUrl = null,
        $ogSiteName = null,
        $ogLocale = null,
        $twitterCard = null,
        $twitterSite = null,
        $twitterCreator = null,
        $twitterTitle = null,
        $twitterDescription = null,
        $twitterImage = null,
        $jsonLd = null,
        $additionalMeta = null
    ) {
        $this->model = $model;
        
        // Load from model if provided
        if ($model && method_exists($model, 'getSeoMeta')) {
            $seoMeta = $model->getSeoMeta();
            $this->title = $title ?? $seoMeta->title ?? config('seo.defaults.title');
            $this->description = $description ?? $seoMeta->description ?? config('seo.defaults.description');
            $this->keywords = $keywords ?? $seoMeta->keywords ?? config('seo.defaults.keywords');
            $this->author = $author ?? $seoMeta->author ?? config('seo.defaults.author');
            $this->robots = $robots ?? $seoMeta->robots ?? config('seo.defaults.robots');
            $this->canonicalUrl = $canonicalUrl ?? $seoMeta->canonical_url;
            $this->ogTitle = $ogTitle ?? $seoMeta->og_title ?? $this->title;
            $this->ogDescription = $ogDescription ?? $seoMeta->og_description ?? $this->description;
            $this->ogImage = $ogImage ?? $seoMeta->og_image;
            $this->ogType = $ogType ?? $seoMeta->og_type ?? config('seo.open_graph.type');
            $this->ogUrl = $ogUrl ?? $seoMeta->og_url ?? $this->canonicalUrl;
            $this->ogSiteName = $ogSiteName ?? $seoMeta->og_site_name ?? config('seo.open_graph.site_name');
            $this->ogLocale = $ogLocale ?? $seoMeta->og_locale ?? config('seo.open_graph.locale');
            $this->twitterCard = $twitterCard ?? $seoMeta->twitter_card ?? config('seo.twitter.card');
            $this->twitterSite = $twitterSite ?? $seoMeta->twitter_site ?? config('seo.twitter.site');
            $this->twitterCreator = $twitterCreator ?? $seoMeta->twitter_creator ?? config('seo.twitter.creator');
            $this->twitterTitle = $twitterTitle ?? $seoMeta->twitter_title ?? $this->title;
            $this->twitterDescription = $twitterDescription ?? $seoMeta->twitter_description ?? $this->description;
            $this->twitterImage = $twitterImage ?? $seoMeta->twitter_image ?? $this->ogImage;
            $this->jsonLd = $jsonLd ?? $seoMeta->json_ld ?? [];
            $this->additionalMeta = $additionalMeta ?? $seoMeta->additional_meta ?? [];
        } else {
            // Use provided values or defaults
            $this->title = $title ?? config('seo.defaults.title');
            $this->description = $description ?? config('seo.defaults.description');
            $this->keywords = $keywords ?? config('seo.defaults.keywords');
            $this->author = $author ?? config('seo.defaults.author');
            $this->robots = $robots ?? config('seo.defaults.robots');
            $this->canonicalUrl = $canonicalUrl;
            $this->ogTitle = $ogTitle ?? $this->title;
            $this->ogDescription = $ogDescription ?? $this->description;
            $this->ogImage = $ogImage;
            $this->ogType = $ogType ?? config('seo.open_graph.type');
            $this->ogUrl = $ogUrl ?? $this->canonicalUrl;
            $this->ogSiteName = $ogSiteName ?? config('seo.open_graph.site_name');
            $this->ogLocale = $ogLocale ?? config('seo.open_graph.locale');
            $this->twitterCard = $twitterCard ?? config('seo.twitter.card');
            $this->twitterSite = $twitterSite ?? config('seo.twitter.site');
            $this->twitterCreator = $twitterCreator ?? config('seo.twitter.creator');
            $this->twitterTitle = $twitterTitle ?? $this->title;
            $this->twitterDescription = $twitterDescription ?? $this->description;
            $this->twitterImage = $twitterImage ?? $this->ogImage;
            $this->jsonLd = $jsonLd ?? [];
            $this->additionalMeta = $additionalMeta ?? [];
        }
    }

    public function render()
    {
        return view('seo::components.seo-directive');
    }
}
