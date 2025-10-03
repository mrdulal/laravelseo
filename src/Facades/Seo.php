<?php

namespace LaravelSeoPro\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \LaravelSeoPro\Services\SeoService reset()
 * @method static \LaravelSeoPro\Services\SeoService setTitle(string $title)
 * @method static string getTitle()
 * @method static \LaravelSeoPro\Services\SeoService setDescription(string $description)
 * @method static string getDescription()
 * @method static \LaravelSeoPro\Services\SeoService setKeywords(string $keywords)
 * @method static string getKeywords()
 * @method static \LaravelSeoPro\Services\SeoService setAuthor(string $author)
 * @method static \LaravelSeoPro\Services\SeoService setRobots(string $robots)
 * @method static \LaravelSeoPro\Services\SeoService setCanonicalUrl(string $url)
 * @method static string|null getCanonicalUrl()
 * @method static \LaravelSeoPro\Services\SeoService setOpenGraph(string $property, string $content)
 * @method static \LaravelSeoPro\Services\SeoService setOpenGraphData(array $data)
 * @method static array getOpenGraphData()
 * @method static \LaravelSeoPro\Services\SeoService setTwitterCard(string $name, string $content)
 * @method static \LaravelSeoPro\Services\SeoService setTwitterCardData(array $data)
 * @method static array getTwitterCardData()
 * @method static \LaravelSeoPro\Services\SeoService setJsonLd(array $data)
 * @method static \LaravelSeoPro\Services\SeoService addJsonLd(array $data)
 * @method static array getJsonLd()
 * @method static \LaravelSeoPro\Services\SeoService setAdditionalMeta(array $meta)
 * @method static \LaravelSeoPro\Services\SeoService addMeta(string $name, string $content)
 * @method static array getAdditionalMeta()
 * @method static \LaravelSeoPro\Services\SeoService loadFromModel($model)
 * @method static string generateRobots()
 * @method static string generateSitemap()
 * @method static array getAllMeta()
 * @method static string renderMetaTags()
 * @method static string renderOpenGraphTags()
 * @method static string renderTwitterCardTags()
 * @method static string renderJsonLd()
 */
class Seo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'seo';
    }
}
