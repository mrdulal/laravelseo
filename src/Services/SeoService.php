<?php

namespace LaravelSeoPro\Services;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use LaravelSeoPro\Models\SeoMeta;
use LaravelSeoPro\Contracts\SeoServiceInterface;
use LaravelSeoPro\Services\SeoAnalyticsService;
use LaravelSeoPro\Services\SeoCacheService;

class SeoService implements SeoServiceInterface
{
    protected array $meta = [];
    protected array $openGraph = [];
    protected array $twitter = [];
    protected array $jsonLd = [];
    protected array $additionalMeta = [];
    protected array $breadcrumbs = [];
    protected ?SeoAnalyticsService $analytics = null;
    protected ?SeoCacheService $cache = null;
    protected bool $isOptimized = false;

    public function __construct(
        ?SeoAnalyticsService $analytics = null,
        ?SeoCacheService $cache = null
    ) {
        $this->analytics = $analytics ?? app(SeoAnalyticsService::class);
        $this->cache = $cache ?? app(SeoCacheService::class);
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

    /**
     * Add breadcrumb to SEO data
     */
    public function addBreadcrumb(string $name, string $url, ?int $position = null): self
    {
        $position = $position ?? count($this->breadcrumbs) + 1;
        
        $this->breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => $name,
            'item' => $url,
        ];

        return $this;
    }

    /**
     * Set breadcrumbs array
     */
    public function setBreadcrumbs(array $breadcrumbs): self
    {
        $this->breadcrumbs = $breadcrumbs;
        return $this;
    }

    /**
     * Get breadcrumbs
     */
    public function getBreadcrumbs(): array
    {
        return $this->breadcrumbs;
    }

    /**
     * Render breadcrumbs as JSON-LD
     */
    public function renderBreadcrumbs(): string
    {
        if (empty($this->breadcrumbs)) {
            return '';
        }

        $breadcrumbSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $this->breadcrumbs,
        ];

        return '<script type="application/ld+json">' . json_encode($breadcrumbSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>';
    }

    /**
     * Optimize SEO data for better performance
     */
    public function optimize(): self
    {
        if ($this->isOptimized) {
            return $this;
        }

        // Optimize title
        if (!empty($this->meta['title'])) {
            $this->meta['title'] = $this->optimizeTitle($this->meta['title']);
        }

        // Optimize description
        if (!empty($this->meta['description'])) {
            $this->meta['description'] = $this->optimizeDescription($this->meta['description']);
        }

        // Optimize keywords
        if (!empty($this->meta['keywords'])) {
            $this->meta['keywords'] = $this->optimizeKeywords($this->meta['keywords']);
        }

        // Ensure Open Graph data is complete
        $this->ensureOpenGraphCompleteness();

        // Ensure Twitter Card data is complete
        $this->ensureTwitterCardCompleteness();

        $this->isOptimized = true;
        $this->analytics->trackSeoEvent('seo_optimized', $this->getAllMeta());

        return $this;
    }

    /**
     * Get SEO score
     */
    public function getSeoScore(): int
    {
        $cacheKey = $this->cache->getSeoScoreCacheKey(request()->url());
        
        return $this->cache->remember($cacheKey, 1800, function () {
            return $this->analytics->getSeoScore($this->getAllMeta());
        });
    }

    /**
     * Get SEO recommendations
     */
    public function getRecommendations(): array
    {
        return $this->analytics->getRecommendations($this->getAllMeta());
    }

    /**
     * Generate advanced sitemap with images and news
     */
    public function generateAdvancedSitemap(): string
    {
        $config = config('seo.sitemap');
        $urls = $config['urls'] ?? [];

        // Add URLs from configured models with enhanced data
        foreach ($config['models'] as $modelClass) {
            if (class_exists($modelClass)) {
                $model = new $modelClass;
                $items = $model->all();

                foreach ($items as $item) {
                    if (method_exists($item, 'getSeoUrl')) {
                        $urlData = [
                            'url' => $item->getSeoUrl(),
                            'lastmod' => $item->updated_at?->format('Y-m-d\TH:i:s\Z'),
                            'priority' => $config['priority'],
                            'changefreq' => $config['changefreq'],
                        ];

                        // Add images if available
                        if (method_exists($item, 'getSeoImages')) {
                            $urlData['images'] = $item->getSeoImages();
                        }

                        // Add news data if available
                        if (method_exists($item, 'getSeoNewsData')) {
                            $urlData['news'] = $item->getSeoNewsData();
                        }

                        $urls[] = $urlData;
                    }
                }
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
        $xml .= ' xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"';
        $xml .= ' xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">' . "\n";

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

            // Add images
            if (isset($url['images']) && is_array($url['images'])) {
                foreach ($url['images'] as $image) {
                    $xml .= "    <image:image>\n";
                    $xml .= "      <image:loc>" . htmlspecialchars($image['url']) . "</image:loc>\n";
                    if (isset($image['title'])) {
                        $xml .= "      <image:title>" . htmlspecialchars($image['title']) . "</image:title>\n";
                    }
                    if (isset($image['caption'])) {
                        $xml .= "      <image:caption>" . htmlspecialchars($image['caption']) . "</image:caption>\n";
                    }
                    $xml .= "    </image:image>\n";
                }
            }

            // Add news data
            if (isset($url['news']) && is_array($url['news'])) {
                $xml .= "    <news:news>\n";
                $xml .= "      <news:publication>\n";
                $xml .= "        <news:name>" . htmlspecialchars($url['news']['publication_name']) . "</news:name>\n";
                $xml .= "        <news:language>" . htmlspecialchars($url['news']['language']) . "</news:language>\n";
                $xml .= "      </news:publication>\n";
                $xml .= "      <news:publication_date>" . $url['news']['publication_date'] . "</news:publication_date>\n";
                $xml .= "      <news:title>" . htmlspecialchars($url['news']['title']) . "</news:title>\n";
                $xml .= "    </news:news>\n";
            }
            
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Optimize title for SEO
     */
    protected function optimizeTitle(string $title): string
    {
        // Remove extra whitespace
        $title = trim(preg_replace('/\s+/', ' ', $title));
        
        // Ensure it's not too long
        if (strlen($title) > 60) {
            $title = substr($title, 0, 57) . '...';
        }

        return $title;
    }

    /**
     * Optimize description for SEO
     */
    protected function optimizeDescription(string $description): string
    {
        // Remove extra whitespace
        $description = trim(preg_replace('/\s+/', ' ', $description));
        
        // Ensure it's not too long
        if (strlen($description) > 160) {
            $description = substr($description, 0, 157) . '...';
        }

        return $description;
    }

    /**
     * Optimize keywords for SEO
     */
    protected function optimizeKeywords(string $keywords): string
    {
        // Convert to array, remove duplicates, and rejoin
        $keywordArray = array_unique(array_map('trim', explode(',', $keywords)));
        
        // Limit to 10 keywords max
        $keywordArray = array_slice($keywordArray, 0, 10);
        
        return implode(', ', $keywordArray);
    }

    /**
     * Ensure Open Graph data is complete
     */
    protected function ensureOpenGraphCompleteness(): void
    {
        if (empty($this->openGraph['og:title']) && !empty($this->meta['title'])) {
            $this->openGraph['og:title'] = $this->meta['title'];
        }

        if (empty($this->openGraph['og:description']) && !empty($this->meta['description'])) {
            $this->openGraph['og:description'] = $this->meta['description'];
        }

        if (empty($this->openGraph['og:url'])) {
            $this->openGraph['og:url'] = $this->getCanonicalUrl();
        }

        if (empty($this->openGraph['og:type'])) {
            $this->openGraph['og:type'] = config('seo.open_graph.type', 'website');
        }
    }

    /**
     * Ensure Twitter Card data is complete
     */
    protected function ensureTwitterCardCompleteness(): void
    {
        if (empty($this->twitter['twitter:title']) && !empty($this->meta['title'])) {
            $this->twitter['twitter:title'] = $this->meta['title'];
        }

        if (empty($this->twitter['twitter:description']) && !empty($this->meta['description'])) {
            $this->twitter['twitter:description'] = $this->meta['description'];
        }

        if (empty($this->twitter['twitter:card'])) {
            $this->twitter['twitter:card'] = config('seo.twitter.card', 'summary_large_image');
        }
    }
}
