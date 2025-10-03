<?php

namespace LaravelSeoPro\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class SeoCacheService
{
    protected int $defaultTtl = 3600; // 1 hour
    protected string $prefix = 'seo_pro_';

    public function remember(string $key, callable $callback, ?int $ttl = null): mixed
    {
        $ttl = $ttl ?? $this->defaultTtl;
        $cacheKey = $this->prefix . $key;

        return Cache::remember($cacheKey, $ttl, $callback);
    }

    public function rememberForever(string $key, callable $callback): mixed
    {
        $cacheKey = $this->prefix . $key;
        return Cache::rememberForever($cacheKey, $callback);
    }

    public function forget(string $key): bool
    {
        $cacheKey = $this->prefix . $key;
        return Cache::forget($cacheKey);
    }

    public function flush(): bool
    {
        return Cache::flush();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $cacheKey = $this->prefix . $key;
        return Cache::get($cacheKey, $default);
    }

    public function put(string $key, mixed $value, ?int $ttl = null): bool
    {
        $ttl = $ttl ?? $this->defaultTtl;
        $cacheKey = $this->prefix . $key;
        return Cache::put($cacheKey, $value, $ttl);
    }

    public function has(string $key): bool
    {
        $cacheKey = $this->prefix . $key;
        return Cache::has($cacheKey);
    }

    public function getCacheKey(string $type, string $identifier): string
    {
        return "{$type}_{$identifier}";
    }

    public function getMetaCacheKey(string $url): string
    {
        return $this->getCacheKey('meta', md5($url));
    }

    public function getSitemapCacheKey(): string
    {
        return $this->getCacheKey('sitemap', 'xml');
    }

    public function getRobotsCacheKey(): string
    {
        return $this->getCacheKey('robots', 'txt');
    }

    public function getSeoScoreCacheKey(string $url): string
    {
        return $this->getCacheKey('score', md5($url));
    }
}
