<?php

namespace LaravelSeoPro\Livewire;

use Livewire\Component;
use LaravelSeoPro\Models\SeoMeta;
use LaravelSeoPro\Traits\HasSeo;

class SeoManager extends Component
{
    public $model;
    public $seoMeta;
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
    public $additionalMeta = [];

    protected $rules = [
        'title' => 'nullable|string|max:60',
        'description' => 'nullable|string|max:160',
        'keywords' => 'nullable|string|max:255',
        'author' => 'nullable|string|max:255',
        'robots' => 'nullable|string|max:255',
        'canonicalUrl' => 'nullable|url|max:255',
        'ogTitle' => 'nullable|string|max:60',
        'ogDescription' => 'nullable|string|max:160',
        'ogImage' => 'nullable|url|max:255',
        'ogType' => 'nullable|string|max:50',
        'ogUrl' => 'nullable|url|max:255',
        'ogSiteName' => 'nullable|string|max:100',
        'ogLocale' => 'nullable|string|max:10',
        'twitterCard' => 'nullable|string|max:50',
        'twitterSite' => 'nullable|string|max:100',
        'twitterCreator' => 'nullable|string|max:100',
        'twitterTitle' => 'nullable|string|max:60',
        'twitterDescription' => 'nullable|string|max:160',
        'twitterImage' => 'nullable|url|max:255',
    ];

    public function mount($model = null)
    {
        $this->model = $model;
        
        if ($model && method_exists($model, 'getSeoMeta')) {
            $this->seoMeta = $model->getSeoMeta();
            $this->loadSeoData();
        } else {
            $this->resetSeoData();
        }
    }

    public function loadSeoData()
    {
        if ($this->seoMeta) {
            $this->title = $this->seoMeta->title;
            $this->description = $this->seoMeta->description;
            $this->keywords = $this->seoMeta->keywords;
            $this->author = $this->seoMeta->author;
            $this->robots = $this->seoMeta->robots;
            $this->canonicalUrl = $this->seoMeta->canonical_url;
            $this->ogTitle = $this->seoMeta->og_title;
            $this->ogDescription = $this->seoMeta->og_description;
            $this->ogImage = $this->seoMeta->og_image;
            $this->ogType = $this->seoMeta->og_type;
            $this->ogUrl = $this->seoMeta->og_url;
            $this->ogSiteName = $this->seoMeta->og_site_name;
            $this->ogLocale = $this->seoMeta->og_locale;
            $this->twitterCard = $this->seoMeta->twitter_card;
            $this->twitterSite = $this->seoMeta->twitter_site;
            $this->twitterCreator = $this->seoMeta->twitter_creator;
            $this->twitterTitle = $this->seoMeta->twitter_title;
            $this->twitterDescription = $this->seoMeta->twitter_description;
            $this->twitterImage = $this->seoMeta->twitter_image;
            $this->jsonLd = $this->seoMeta->json_ld;
            $this->additionalMeta = $this->seoMeta->additional_meta ?? [];
        }
    }

    public function resetSeoData()
    {
        $this->title = '';
        $this->description = '';
        $this->keywords = '';
        $this->author = '';
        $this->robots = config('seo.defaults.robots');
        $this->canonicalUrl = '';
        $this->ogTitle = '';
        $this->ogDescription = '';
        $this->ogImage = '';
        $this->ogType = config('seo.open_graph.type');
        $this->ogUrl = '';
        $this->ogSiteName = config('seo.open_graph.site_name');
        $this->ogLocale = config('seo.open_graph.locale');
        $this->twitterCard = config('seo.twitter.card');
        $this->twitterSite = config('seo.twitter.site');
        $this->twitterCreator = config('seo.twitter.creator');
        $this->twitterTitle = '';
        $this->twitterDescription = '';
        $this->twitterImage = '';
        $this->jsonLd = [];
        $this->additionalMeta = [];
    }

    public function save()
    {
        $this->validate();

        if (!$this->model || !method_exists($this->model, 'updateSeoMeta')) {
            $this->addError('model', 'Invalid model provided.');
            return;
        }

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'author' => $this->author,
            'robots' => $this->robots,
            'canonical_url' => $this->canonicalUrl,
            'og_title' => $this->ogTitle,
            'og_description' => $this->ogDescription,
            'og_image' => $this->ogImage,
            'og_type' => $this->ogType,
            'og_url' => $this->ogUrl,
            'og_site_name' => $this->ogSiteName,
            'og_locale' => $this->ogLocale,
            'twitter_card' => $this->twitterCard,
            'twitter_site' => $this->twitterSite,
            'twitter_creator' => $this->twitterCreator,
            'twitter_title' => $this->twitterTitle,
            'twitter_description' => $this->twitterDescription,
            'twitter_image' => $this->twitterImage,
            'json_ld' => $this->jsonLd,
            'additional_meta' => $this->additionalMeta,
        ];

        $this->model->updateSeoMeta($data);
        
        $this->dispatch('seo-saved');
        session()->flash('message', 'SEO data saved successfully!');
    }

    public function addAdditionalMeta()
    {
        $this->additionalMeta[] = ['name' => '', 'content' => ''];
    }

    public function removeAdditionalMeta($index)
    {
        unset($this->additionalMeta[$index]);
        $this->additionalMeta = array_values($this->additionalMeta);
    }

    public function addJsonLdProperty()
    {
        $this->jsonLd[] = ['key' => '', 'value' => ''];
    }

    public function removeJsonLdProperty($index)
    {
        unset($this->jsonLd[$index]);
        $this->jsonLd = array_values($this->jsonLd);
    }

    public function render()
    {
        return view('seo::livewire.seo-manager');
    }
}
