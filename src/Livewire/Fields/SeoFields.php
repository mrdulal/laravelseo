<?php

namespace LaravelSeoPro\Livewire\Fields;

use Livewire\Component;
use LaravelSeoPro\Traits\HasSeo;

class SeoFields extends Component
{
    public $model;
    public $seoData = [];
    public $showAdvanced = false;

    protected $rules = [
        'seoData.title' => 'nullable|string|max:60',
        'seoData.description' => 'nullable|string|max:160',
        'seoData.keywords' => 'nullable|string|max:255',
        'seoData.author' => 'nullable|string|max:255',
        'seoData.robots' => 'nullable|string|max:255',
        'seoData.canonical_url' => 'nullable|url|max:255',
    ];

    public function mount($model = null)
    {
        $this->model = $model;
        
        if ($model && method_exists($model, 'getSeoMeta')) {
            $seoMeta = $model->getSeoMeta();
            $this->seoData = [
                'title' => $seoMeta->title ?? '',
                'description' => $seoMeta->description ?? '',
                'keywords' => $seoMeta->keywords ?? '',
                'author' => $seoMeta->author ?? '',
                'robots' => $seoMeta->robots ?? config('seo.defaults.robots'),
                'canonical_url' => $seoMeta->canonical_url ?? '',
                'og_title' => $seoMeta->og_title ?? '',
                'og_description' => $seoMeta->og_description ?? '',
                'og_image' => $seoMeta->og_image ?? '',
                'og_type' => $seoMeta->og_type ?? config('seo.open_graph.type'),
                'twitter_card' => $seoMeta->twitter_card ?? config('seo.twitter.card'),
                'twitter_title' => $seoMeta->twitter_title ?? '',
                'twitter_description' => $seoMeta->twitter_description ?? '',
                'twitter_image' => $seoMeta->twitter_image ?? '',
            ];
        } else {
            $this->resetSeoData();
        }
    }

    public function resetSeoData()
    {
        $this->seoData = [
            'title' => '',
            'description' => '',
            'keywords' => '',
            'author' => '',
            'robots' => config('seo.defaults.robots'),
            'canonical_url' => '',
            'og_title' => '',
            'og_description' => '',
            'og_image' => '',
            'og_type' => config('seo.open_graph.type'),
            'twitter_card' => config('seo.twitter.card'),
            'twitter_title' => '',
            'twitter_description' => '',
            'twitter_image' => '',
        ];
    }

    public function save()
    {
        $this->validate();

        if (!$this->model || !method_exists($this->model, 'updateSeoMeta')) {
            $this->addError('model', 'Invalid model provided.');
            return;
        }

        $this->model->updateSeoMeta($this->seoData);
        
        $this->dispatch('seo-saved');
        session()->flash('message', 'SEO data saved successfully!');
    }

    public function toggleAdvanced()
    {
        $this->showAdvanced = !$this->showAdvanced;
    }

    public function render()
    {
        return view('seo::livewire.fields.seo-fields');
    }
}
