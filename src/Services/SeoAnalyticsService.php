<?php

namespace LaravelSeoPro\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SeoAnalyticsService
{
    protected array $metrics = [];
    protected int $cacheTtl = 3600; // 1 hour

    public function trackSeoEvent(string $event, array $data = []): void
    {
        $this->metrics[] = [
            'event' => $event,
            'data' => $data,
            'timestamp' => now(),
            'url' => request()->url(),
        ];

        // Log important events
        if (in_array($event, ['seo_optimized', 'seo_issue_detected', 'sitemap_generated'])) {
            Log::info("SEO Event: {$event}", $data);
        }
    }

    public function getSeoScore(array $meta): int
    {
        $score = 0;
        $maxScore = 100;

        // Title optimization (20 points)
        if (!empty($meta['title'])) {
            $titleLength = strlen($meta['title']);
            if ($titleLength >= 30 && $titleLength <= 60) {
                $score += 20;
            } elseif ($titleLength >= 20 && $titleLength <= 70) {
                $score += 15;
            } else {
                $score += 5;
            }
        }

        // Description optimization (20 points)
        if (!empty($meta['description'])) {
            $descLength = strlen($meta['description']);
            if ($descLength >= 120 && $descLength <= 160) {
                $score += 20;
            } elseif ($descLength >= 100 && $descLength <= 180) {
                $score += 15;
            } else {
                $score += 5;
            }
        }

        // Keywords (10 points)
        if (!empty($meta['keywords'])) {
            $score += 10;
        }

        // Open Graph (20 points)
        $ogScore = 0;
        if (!empty($meta['og_title'])) $ogScore += 5;
        if (!empty($meta['og_description'])) $ogScore += 5;
        if (!empty($meta['og_image'])) $ogScore += 5;
        if (!empty($meta['og_type'])) $ogScore += 5;
        $score += $ogScore;

        // Twitter Cards (10 points)
        $twitterScore = 0;
        if (!empty($meta['twitter_card'])) $twitterScore += 5;
        if (!empty($meta['twitter_title'])) $twitterScore += 3;
        if (!empty($meta['twitter_description'])) $twitterScore += 2;
        $score += $twitterScore;

        // Canonical URL (10 points)
        if (!empty($meta['canonical_url'])) {
            $score += 10;
        }

        // JSON-LD (10 points)
        if (!empty($meta['json_ld'])) {
            $score += 10;
        }

        return min($score, $maxScore);
    }

    public function getRecommendations(array $meta): array
    {
        $recommendations = [];

        // Title recommendations
        if (empty($meta['title'])) {
            $recommendations[] = 'Add a page title for better SEO';
        } else {
            $titleLength = strlen($meta['title']);
            if ($titleLength < 30) {
                $recommendations[] = 'Consider making your title longer (30-60 characters)';
            } elseif ($titleLength > 60) {
                $recommendations[] = 'Consider shortening your title (30-60 characters)';
            }
        }

        // Description recommendations
        if (empty($meta['description'])) {
            $recommendations[] = 'Add a meta description for better SEO';
        } else {
            $descLength = strlen($meta['description']);
            if ($descLength < 120) {
                $recommendations[] = 'Consider making your description longer (120-160 characters)';
            } elseif ($descLength > 160) {
                $recommendations[] = 'Consider shortening your description (120-160 characters)';
            }
        }

        // Open Graph recommendations
        if (empty($meta['og_image'])) {
            $recommendations[] = 'Add an Open Graph image for better social sharing';
        }

        if (empty($meta['og_title'])) {
            $recommendations[] = 'Add an Open Graph title for better social sharing';
        }

        // Twitter Card recommendations
        if (empty($meta['twitter_card'])) {
            $recommendations[] = 'Add Twitter Card meta tags for better Twitter sharing';
        }

        // Canonical URL recommendations
        if (empty($meta['canonical_url'])) {
            $recommendations[] = 'Add a canonical URL to prevent duplicate content issues';
        }

        return $recommendations;
    }

    public function getMetrics(): array
    {
        return Cache::remember('seo_analytics_metrics', $this->cacheTtl, function () {
            return $this->metrics;
        });
    }

    public function clearMetrics(): void
    {
        $this->metrics = [];
        Cache::forget('seo_analytics_metrics');
    }
}
