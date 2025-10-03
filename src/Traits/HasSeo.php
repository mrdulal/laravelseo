<?php

namespace LaravelSeoPro\Traits;

use LaravelSeoPro\Models\SeoMeta;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSeo
{
    /**
     * Get the SEO meta data for this model
     */
    public function seoMeta(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    /**
     * Get or create SEO meta data
     */
    public function getSeoMeta(): SeoMeta
    {
        return $this->seoMeta ?: $this->seoMeta()->create([]);
    }

    /**
     * Update SEO meta data
     */
    public function updateSeoMeta(array $data): SeoMeta
    {
        $seoMeta = $this->getSeoMeta();
        $seoMeta->update($data);
        return $seoMeta;
    }

    /**
     * Get SEO title (can be overridden in model)
     */
    public function getSeoTitle(): ?string
    {
        return $this->seoMeta?->title;
    }

    /**
     * Get SEO description (can be overridden in model)
     */
    public function getSeoDescription(): ?string
    {
        return $this->seoMeta?->description;
    }

    /**
     * Get SEO keywords (can be overridden in model)
     */
    public function getSeoKeywords(): ?string
    {
        return $this->seoMeta?->keywords;
    }

    /**
     * Get SEO canonical URL (can be overridden in model)
     */
    public function getSeoCanonicalUrl(): ?string
    {
        return $this->seoMeta?->canonical_url ?: $this->getSeoUrl();
    }

    /**
     * Get SEO URL (should be implemented in model)
     */
    public function getSeoUrl(): ?string
    {
        return null;
    }

    /**
     * Get SEO image (can be overridden in model)
     */
    public function getSeoImage(): ?string
    {
        return $this->seoMeta?->og_image;
    }

    /**
     * Get SEO type (can be overridden in model)
     */
    public function getSeoType(): ?string
    {
        return $this->seoMeta?->og_type ?: 'article';
    }

    /**
     * Get SEO site name (can be overridden in model)
     */
    public function getSeoSiteName(): ?string
    {
        return $this->seoMeta?->og_site_name ?: config('seo.open_graph.site_name');
    }

    /**
     * Get SEO locale (can be overridden in model)
     */
    public function getSeoLocale(): ?string
    {
        return $this->seoMeta?->og_locale ?: config('seo.open_graph.locale');
    }

    /**
     * Get JSON-LD schema data
     */
    public function getSeoJsonLd(): ?array
    {
        return $this->seoMeta?->json_ld;
    }

    /**
     * Set JSON-LD schema data
     */
    public function setSeoJsonLd(array $data): void
    {
        $this->updateSeoMeta(['json_ld' => $data]);
    }

    /**
     * Get additional meta tags
     */
    public function getSeoAdditionalMeta(): ?array
    {
        return $this->seoMeta?->additional_meta;
    }

    /**
     * Set additional meta tags
     */
    public function setSeoAdditionalMeta(array $data): void
    {
        $this->updateSeoMeta(['additional_meta' => $data]);
    }

    /**
     * Boot the trait
     */
    protected static function bootHasSeo()
    {
        // Auto-create SEO meta when model is created
        static::created(function ($model) {
            if (config('seo.features.meta_tags')) {
                $model->seoMeta()->create([]);
            }
        });
    }
}
