<?php

/**
 * @author mrdulal
 * @package LaravelSeoPro
 */

namespace LaravelSeoPro\Services;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use LaravelSeoPro\Models\SeoMeta;

class SeoService
{
    protected array $meta = [];
    protected array $openGraph = [];
    protected array $twitter = [];
    protected array $jsonLd = [];
    protected array $additionalMeta = [];

    public function __construct()
    {
        $this->reset();
    }

    /**
     * Reset all SEO data to defaults
     */
    public function reset(): self
    {
        $this->meta = config('seo.defaults', []);
        $this->openGraph = config('seo.open_graph', []);
        $this->twitter = config('seo.twitter', []);
        $this->jsonLd = [];
        $this->additionalMeta = [];

        return $this;
    }

    /**
     * Set the page title
     */
    public function setTitle(string $title): self
    {
        $this->meta['title'] = $title;
        return $this;
    }

    /**
     * Get the page title
     */
    public function getTitle(): string
    {
        return $this->meta['title'] ?? config('seo.defaults.title');
    }

    /**
     * Set the page description
     */
    public function setDescription(string $description): self
    {
        $this->meta['description'] = $description;
        return $this;
    }

    /**
     * Get the page description
     */
    public function getDescription(): string
    {
        return $this->meta['description'] ?? config('seo.defaults.description');
    }

    /**
     * Set the page keywords
     */
    public function setKeywords(string $keywords): self
    {
        $this->meta['keywords'] = $keywords;
        return $this;
    }

    /**
     * Get the page keywords
     */
    public function getKeywords(): string
    {
        return $this->meta['keywords'] ?? config('seo.defaults.keywords');
    }

    /**
     * Set the page author
     */
    public function setAuthor(string $author): self
    {
        $this->meta['author'] = $author;
        return $this;
    }

    /**
     * Set the robots meta tag
     */
    public function setRobots(string $robots): self
    {
        $this->meta['robots'] = $robots;
        return $this;
    }

    /**
     * Set the canonical URL
     */
    public function setCanonicalUrl(string $url): self
    {
        $this->meta['canonical_url'] = $url;
        return $this;
    }

    /**
     * Get the canonical URL
     */
    public function getCanonicalUrl(): ?string
    {
        return $this->meta['canonical_url'] ?? URL::current();
    }

    /**
     * Set Open Graph data
     */
    public function setOpenGraph(string $property, string $content): self
    {
        $this->openGraph[$property] = $content;
        return $this;
    }

    /**
     * Set multiple Open Graph properties
     */
    public function setOpenGraphData(array $data): self
    {
        $this->openGraph = array_merge($this->openGraph, $data);
        return $this;
    }

    /**
     * Get Open Graph data
     */
    public function getOpenGraphData(): array
    {
        return $this->openGraph;
    }

    /**
     * Set Twitter Card data
     */
    public function setTwitterCard(string $name, string $content): self
    {
        $this->twitter[$name] = $content;
        return $this;
    }

    /**
     * Set multiple Twitter Card properties
     */
    public function setTwitterCardData(array $data): self
    {
        $this->twitter = array_merge($this->twitter, $data);
        return $this;
    }

    /**
     * Get Twitter Card data
     */
    public function getTwitterCardData(): array
    {
        return $this->twitter;
    }

    /**
     * Set JSON-LD schema
     */
    public function setJsonLd(array $data): self
    {
        $this->jsonLd = $data;
        return $this;
    }

    /**
     * Add JSON-LD schema
     */
    public function addJsonLd(array $data): self
    {
        if (!isset($this->jsonLd['@context'])) {
            $this->jsonLd = array_merge(['@context' => 'https://schema.org'], $data);
        } else {
            $this->jsonLd = array_merge($this->jsonLd, $data);
        }
        return $this;
    }

    /**
     * Get JSON-LD schema
     */
    public function getJsonLd(): array
    {
        return $this->jsonLd;
    }

    /**
     * Set additional meta tags
     */
    public function setAdditionalMeta(array $meta): self
    {
        $this->additionalMeta = array_merge($this->additionalMeta, $meta);
        return $this;
    }

    /**
     * Add a single additional meta tag
     */
    public function addMeta(string $name, string $content): self
    {
        $this->additionalMeta[$name] = $content;
        return $this;
    }

    /**
     * Get additional meta tags
     */
    public function getAdditionalMeta(): array
    {
        return $this->additionalMeta;
    }

    /**
     * Load SEO data from a model
     */
    public function loadFromModel($model): self
    {
        if (!$model || !method_exists($model, 'seoMeta')) {
            return $this;
        }

        $seoMeta = $model->getSeoMeta();

        if ($seoMeta) {
            $this->setTitle($seoMeta->getDisplayTitleAttribute())
                 ->setDescription($seoMeta->getDisplayDescriptionAttribute())
                 ->setKeywords($seoMeta->getDisplayKeywordsAttribute());

            if ($seoMeta->canonical_url) {
                $this->setCanonicalUrl($seoMeta->canonical_url);
            }

            // Load Open Graph data
            if ($seoMeta->og_title) {
                $this->setOpenGraph('og:title', $seoMeta->getDisplayOgTitleAttribute());
            }
            if ($seoMeta->og_description) {
                $this->setOpenGraph('og:description', $seoMeta->getDisplayOgDescriptionAttribute());
            }
            if ($seoMeta->og_image) {
                $this->setOpenGraph('og:image', $seoMeta->og_image);
            }
            if ($seoMeta->og_type) {
                $this->setOpenGraph('og:type', $seoMeta->og_type);
            }
            if ($seoMeta->og_url) {
                $this->setOpenGraph('og:url', $seoMeta->og_url);
            }
            if ($seoMeta->og_site_name) {
                $this->setOpenGraph('og:site_name', $seoMeta->og_site_name);
            }
            if ($seoMeta->og_locale) {
                $this->setOpenGraph('og:locale', $seoMeta->og_locale);
            }

            // Load Twitter Card data
            if ($seoMeta->twitter_card) {
                $this->setTwitterCard('twitter:card', $seoMeta->twitter_card);
            }
            if ($seoMeta->twitter_site) {
                $this->setTwitterCard('twitter:site', $seoMeta->twitter_site);
            }
            if ($seoMeta->twitter_creator) {
                $this->setTwitterCard('twitter:creator', $seoMeta->twitter_creator);
            }
            if ($seoMeta->twitter_title) {
                $this->setTwitterCard('twitter:title', $seoMeta->getDisplayTwitterTitleAttribute());
            }
            if ($seoMeta->twitter_description) {
                $this->setTwitterCard('twitter:description', $seoMeta->getDisplayTwitterDescriptionAttribute());
            }
            if ($seoMeta->twitter_image) {
                $this->setTwitterCard('twitter:image', $seoMeta->twitter_image);
            }

            // Load JSON-LD data
            if ($seoMeta->json_ld) {
                $this->setJsonLd($seoMeta->json_ld);
            }

            // Load additional meta tags
            if ($seoMeta->additional_meta) {
                $this->setAdditionalMeta($seoMeta->additional_meta);
            }
        }

        return $this;
    }

    /**
     * Generate robots.txt content
     */
    public function generateRobots(): string
    {
        $config = config('seo.robots');
        $content = "User-agent: {$config['user_agent']}\n";

        foreach ($config['disallow'] as $path) {
            $content .= "Disallow: {$path}\n";
        }

        foreach ($config['allow'] as $path) {
            $content .= "Allow: {$path}\n";
        }

        if (isset($config['sitemap'])) {
            $content .= "\nSitemap: " . url($config['sitemap']) . "\n";
        }

        return $content;
    }

    /**
     * Generate XML sitemap
     */
    public function generateSitemap(): string
    {
        $config = config('seo.sitemap');
        $urls = $config['urls'] ?? [];

        // Add URLs from configured models
        foreach ($config['models'] as $modelClass) {
            if (class_exists($modelClass)) {
                $model = new $modelClass;
                $items = $model->all();

                foreach ($items as $item) {
                    if (method_exists($item, 'getSeoUrl')) {
                        $urls[] = [
                            'url' => $item->getSeoUrl(),
                            'lastmod' => $item->updated_at?->format('Y-m-d'),
                            'priority' => $config['priority'],
                            'changefreq' => $config['changefreq'],
                        ];
                    }
                }
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url['url']) . "</loc>\n";
            
            if (isset($url['lastmod'])) {
                $xml .= "    <lastmod>" . $url['lastmod'] . "</lastmod>\n";
            }
            
            if (isset($url['priority'])) {
                $xml .= "    <priority>" . $url['priority'] . "</priority>\n";
            }
            
            if (isset($url['changefreq'])) {
                $xml .= "    <changefreq>" . $url['changefreq'] . "</changefreq>\n";
            }
            
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Get all meta data
     */
    public function getAllMeta(): array
    {
        return [
            'meta' => $this->meta,
            'open_graph' => $this->openGraph,
            'twitter' => $this->twitter,
            'json_ld' => $this->jsonLd,
            'additional_meta' => $this->additionalMeta,
        ];
    }

    /**
     * Render meta tags as HTML
     */
    public function renderMetaTags(): string
    {
        return View::make('seo::meta-tags', $this->getAllMeta())->render();
    }

    /**
     * Render Open Graph tags as HTML
     */
    public function renderOpenGraphTags(): string
    {
        return View::make('seo::open-graph-tags', ['open_graph' => $this->openGraph])->render();
    }

    /**
     * Render Twitter Card tags as HTML
     */
    public function renderTwitterCardTags(): string
    {
        return View::make('seo::twitter-card-tags', ['twitter' => $this->twitter])->render();
    }

    /**
     * Render JSON-LD schema as HTML
     */
    public function renderJsonLd(): string
    {
        if (empty($this->jsonLd)) {
            return '';
        }

        return '<script type="application/ld+json">' . json_encode($this->jsonLd, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>';
    }
}
