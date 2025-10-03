<?php

namespace LaravelSeoPro\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMeta extends Model
{
    protected $fillable = [
        'seoable_type',
        'seoable_id',
        'title',
        'description',
        'keywords',
        'author',
        'robots',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'og_url',
        'og_site_name',
        'og_locale',
        'twitter_card',
        'twitter_site',
        'twitter_creator',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'json_ld',
        'additional_meta',
    ];

    protected $casts = [
        'json_ld' => 'array',
        'additional_meta' => 'array',
    ];

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the title for display
     */
    public function getDisplayTitleAttribute(): string
    {
        return $this->title ?: $this->seoable?->getSeoTitle() ?: config('seo.defaults.title');
    }

    /**
     * Get the description for display
     */
    public function getDisplayDescriptionAttribute(): string
    {
        return $this->description ?: $this->seoable?->getSeoDescription() ?: config('seo.defaults.description');
    }

    /**
     * Get the keywords for display
     */
    public function getDisplayKeywordsAttribute(): string
    {
        return $this->keywords ?: $this->seoable?->getSeoKeywords() ?: config('seo.defaults.keywords');
    }

    /**
     * Get the canonical URL for display
     */
    public function getDisplayCanonicalUrlAttribute(): ?string
    {
        return $this->canonical_url ?: $this->seoable?->getSeoCanonicalUrl();
    }

    /**
     * Get the Open Graph title for display
     */
    public function getDisplayOgTitleAttribute(): string
    {
        return $this->og_title ?: $this->getDisplayTitleAttribute();
    }

    /**
     * Get the Open Graph description for display
     */
    public function getDisplayOgDescriptionAttribute(): string
    {
        return $this->og_description ?: $this->getDisplayDescriptionAttribute();
    }

    /**
     * Get the Twitter title for display
     */
    public function getDisplayTwitterTitleAttribute(): string
    {
        return $this->twitter_title ?: $this->getDisplayTitleAttribute();
    }

    /**
     * Get the Twitter description for display
     */
    public function getDisplayTwitterDescriptionAttribute(): string
    {
        return $this->twitter_description ?: $this->getDisplayDescriptionAttribute();
    }
}
