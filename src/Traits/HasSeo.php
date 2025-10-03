<?php

namespace LaravelSeoPro\Traits;

use LaravelSeoPro\Models\SeoMeta;
use LaravelSeoPro\Services\SeoService;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

trait HasSeo
{
    protected ?SeoMeta $seoMetaCache = null;
    protected bool $seoMetaLoaded = false;

    /**
     * Get the SEO meta data for this model
     */
    public function seoMeta(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    /**
     * Get or create SEO meta data with caching
     */
    public function getSeoMeta(): SeoMeta
    {
        if (!$this->seoMetaLoaded) {
            $cacheKey = "seo_meta_{$this->getMorphClass()}_{$this->getKey()}";
            
            $this->seoMetaCache = Cache::remember($cacheKey, 3600, function () {
                return $this->seoMeta ?: $this->seoMeta()->create([]);
            });
            
            $this->seoMetaLoaded = true;
        }

        return $this->seoMetaCache;
    }

    /**
     * Update SEO meta data with cache invalidation
     */
    public function updateSeoMeta(array $data): SeoMeta
    {
        $seoMeta = $this->getSeoMeta();
        $seoMeta->update($data);
        
        // Clear cache
        $this->clearSeoMetaCache();
        
        // Log the update
        Log::info('SEO Meta Updated', [
            'model' => get_class($this),
            'id' => $this->getKey(),
            'data' => $data
        ]);
        
        return $seoMeta;
    }

    /**
     * Clear SEO meta cache
     */
    public function clearSeoMetaCache(): void
    {
        $cacheKey = "seo_meta_{$this->getMorphClass()}_{$this->getKey()}";
        Cache::forget($cacheKey);
        $this->seoMetaCache = null;
        $this->seoMetaLoaded = false;
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
     * Get SEO images for sitemap
     */
    public function getSeoImages(): array
    {
        $images = [];
        
        // Check for image field
        if (isset($this->image) && !empty($this->image)) {
            $images[] = [
                'url' => $this->image,
                'title' => $this->getSeoTitle(),
                'caption' => $this->getSeoDescription(),
            ];
        }
        
        // Check for images field (array)
        if (isset($this->images) && is_array($this->images)) {
            foreach ($this->images as $image) {
                $images[] = [
                    'url' => is_string($image) ? $image : $image['url'] ?? '',
                    'title' => $image['title'] ?? $this->getSeoTitle(),
                    'caption' => $image['caption'] ?? $this->getSeoDescription(),
                ];
            }
        }
        
        return $images;
    }

    /**
     * Get SEO news data for sitemap
     */
    public function getSeoNewsData(): ?array
    {
        // Only return news data if this is a news/article model
        if (!method_exists($this, 'isNewsArticle') || !$this->isNewsArticle()) {
            return null;
        }
        
        return [
            'publication_name' => config('seo.news.publication_name', 'Your Site'),
            'language' => config('seo.news.language', 'en'),
            'publication_date' => $this->created_at?->format('Y-m-d\TH:i:s\Z'),
            'title' => $this->getSeoTitle(),
        ];
    }

    /**
     * Get SEO score for this model
     */
    public function getSeoScore(): int
    {
        $seoService = app(SeoService::class);
        $seoService->loadFromModel($this);
        return $seoService->getSeoScore();
    }

    /**
     * Get SEO recommendations for this model
     */
    public function getSeoRecommendations(): array
    {
        $seoService = app(SeoService::class);
        $seoService->loadFromModel($this);
        return $seoService->getRecommendations();
    }

    /**
     * Optimize SEO data for this model
     */
    public function optimizeSeo(): self
    {
        $seoService = app(SeoService::class);
        $seoService->loadFromModel($this);
        $optimizedData = $seoService->optimize()->getAllMeta();
        
        // Update with optimized data
        $this->updateSeoMeta([
            'title' => $optimizedData['meta']['title'] ?? null,
            'description' => $optimizedData['meta']['description'] ?? null,
            'keywords' => $optimizedData['meta']['keywords'] ?? null,
        ]);
        
        return $this;
    }

    /**
     * Get breadcrumbs for this model
     */
    public function getSeoBreadcrumbs(): array
    {
        $breadcrumbs = [];
        
        // Add home breadcrumb
        $breadcrumbs[] = [
            'name' => 'Home',
            'url' => url('/'),
            'position' => 1,
        ];
        
        // Add model-specific breadcrumbs
        if (method_exists($this, 'getBreadcrumbData')) {
            $modelBreadcrumbs = $this->getBreadcrumbData();
            foreach ($modelBreadcrumbs as $index => $breadcrumb) {
                $breadcrumbs[] = [
                    'name' => $breadcrumb['name'],
                    'url' => $breadcrumb['url'],
                    'position' => $index + 2,
                ];
            }
        }
        
        return $breadcrumbs;
    }

    /**
     * Check if this model is a news article
     */
    public function isNewsArticle(): bool
    {
        return false; // Override in your model if needed
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

        // Clear cache when model is updated
        static::updated(function ($model) {
            $model->clearSeoMetaCache();
        });

        // Clear cache when model is deleted
        static::deleted(function ($model) {
            $model->clearSeoMetaCache();
        });
    }
}
