<?php

namespace LaravelSeoPro\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use LaravelSeoPro\Models\SeoMeta;

class SeoMonitoringService
{
    protected array $monitoringData = [];
    protected int $cacheTtl = 3600; // 1 hour

    public function monitorPage(string $url): array
    {
        $cacheKey = "seo_monitor_" . md5($url);
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($url) {
            return $this->performPageAnalysis($url);
        });
    }

    protected function performPageAnalysis(string $url): array
    {
        try {
            $response = Http::timeout(30)->get($url);
            
            if (!$response->successful()) {
                return $this->createErrorResult($url, "HTTP {$response->status()}");
            }

            $content = $response->body();
            $analysis = [
                'url' => $url,
                'status' => 'success',
                'timestamp' => now(),
                'http_status' => $response->status(),
                'response_time' => $response->transferStats->getHandlerStat('total_time'),
                'content_length' => strlen($content),
                'seo_analysis' => $this->analyzeSeoContent($content),
                'performance' => $this->analyzePerformance($content),
                'accessibility' => $this->analyzeAccessibility($content),
            ];

            $this->logMonitoringData($analysis);
            return $analysis;

        } catch (\Exception $e) {
            Log::error('SEO Monitoring Error', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            
            return $this->createErrorResult($url, $e->getMessage());
        }
    }

    protected function analyzeSeoContent(string $content): array
    {
        $analysis = [
            'title' => $this->extractTitle($content),
            'description' => $this->extractMetaContent($content, 'description'),
            'keywords' => $this->extractMetaContent($content, 'keywords'),
            'canonical' => $this->extractCanonicalUrl($content),
            'open_graph' => $this->extractOpenGraphTags($content),
            'twitter_cards' => $this->extractTwitterCards($content),
            'json_ld' => $this->extractJsonLd($content),
            'headings' => $this->extractHeadings($content),
            'images' => $this->extractImages($content),
            'links' => $this->extractLinks($content),
        ];

        $analysis['score'] = $this->calculateSeoScore($analysis);
        $analysis['recommendations'] = $this->generateRecommendations($analysis);

        return $analysis;
    }

    protected function analyzePerformance(string $content): array
    {
        return [
            'title_length' => strlen($this->extractTitle($content)),
            'description_length' => strlen($this->extractMetaContent($content, 'description')),
            'image_count' => count($this->extractImages($content)),
            'link_count' => count($this->extractLinks($content)),
            'heading_structure' => $this->analyzeHeadingStructure($content),
            'has_favicon' => $this->hasFavicon($content),
            'has_robots_meta' => $this->hasRobotsMeta($content),
        ];
    }

    protected function analyzeAccessibility(string $content): array
    {
        return [
            'has_alt_text' => $this->hasAltText($content),
            'heading_hierarchy' => $this->checkHeadingHierarchy($content),
            'form_labels' => $this->checkFormLabels($content),
            'color_contrast' => $this->checkColorContrast($content),
        ];
    }

    protected function extractTitle(string $content): string
    {
        preg_match('/<title[^>]*>(.*?)<\/title>/i', $content, $matches);
        return isset($matches[1]) ? trim(strip_tags($matches[1])) : '';
    }

    protected function extractMetaContent(string $content, string $name): string
    {
        preg_match('/<meta[^>]*name=["\']' . preg_quote($name, '/') . '["\'][^>]*content=["\']([^"\']*)["\'][^>]*>/i', $content, $matches);
        return isset($matches[1]) ? trim($matches[1]) : '';
    }

    protected function extractCanonicalUrl(string $content): string
    {
        preg_match('/<link[^>]*rel=["\']canonical["\'][^>]*href=["\']([^"\']*)["\'][^>]*>/i', $content, $matches);
        return isset($matches[1]) ? trim($matches[1]) : '';
    }

    protected function extractOpenGraphTags(string $content): array
    {
        $ogTags = [];
        preg_match_all('/<meta[^>]*property=["\']og:([^"\']*)["\'][^>]*content=["\']([^"\']*)["\'][^>]*>/i', $content, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $ogTags[$match[1]] = $match[2];
        }
        
        return $ogTags;
    }

    protected function extractTwitterCards(string $content): array
    {
        $twitterTags = [];
        preg_match_all('/<meta[^>]*name=["\']twitter:([^"\']*)["\'][^>]*content=["\']([^"\']*)["\'][^>]*>/i', $content, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $twitterTags[$match[1]] = $match[2];
        }
        
        return $twitterTags;
    }

    protected function extractJsonLd(string $content): array
    {
        $jsonLd = [];
        preg_match_all('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/is', $content, $matches);
        
        foreach ($matches[1] as $json) {
            $decoded = json_decode(trim($json), true);
            if ($decoded) {
                $jsonLd[] = $decoded;
            }
        }
        
        return $jsonLd;
    }

    protected function extractHeadings(string $content): array
    {
        $headings = [];
        preg_match_all('/<h([1-6])[^>]*>(.*?)<\/h[1-6]>/i', $content, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $headings[] = [
                'level' => (int) $match[1],
                'text' => trim(strip_tags($match[2])),
            ];
        }
        
        return $headings;
    }

    protected function extractImages(string $content): array
    {
        $images = [];
        preg_match_all('/<img[^>]*src=["\']([^"\']*)["\'][^>]*>/i', $content, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $images[] = [
                'src' => $match[1],
                'alt' => $this->extractAttribute($match[0], 'alt'),
                'title' => $this->extractAttribute($match[0], 'title'),
            ];
        }
        
        return $images;
    }

    protected function extractLinks(string $content): array
    {
        $links = [];
        preg_match_all('/<a[^>]*href=["\']([^"\']*)["\'][^>]*>(.*?)<\/a>/i', $content, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $links[] = [
                'href' => $match[1],
                'text' => trim(strip_tags($match[2])),
                'title' => $this->extractAttribute($match[0], 'title'),
            ];
        }
        
        return $links;
    }

    protected function extractAttribute(string $tag, string $attribute): string
    {
        preg_match('/' . preg_quote($attribute, '/') . '=["\']([^"\']*)["\']/i', $tag, $matches);
        return isset($matches[1]) ? trim($matches[1]) : '';
    }

    protected function calculateSeoScore(array $analysis): int
    {
        $score = 0;
        
        // Title (20 points)
        if (!empty($analysis['title'])) {
            $titleLength = strlen($analysis['title']);
            if ($titleLength >= 30 && $titleLength <= 60) {
                $score += 20;
            } elseif ($titleLength >= 20 && $titleLength <= 70) {
                $score += 15;
            } else {
                $score += 5;
            }
        }
        
        // Description (20 points)
        if (!empty($analysis['description'])) {
            $descLength = strlen($analysis['description']);
            if ($descLength >= 120 && $descLength <= 160) {
                $score += 20;
            } elseif ($descLength >= 100 && $descLength <= 180) {
                $score += 15;
            } else {
                $score += 5;
            }
        }
        
        // Canonical URL (10 points)
        if (!empty($analysis['canonical'])) {
            $score += 10;
        }
        
        // Open Graph (20 points)
        $ogScore = 0;
        if (!empty($analysis['open_graph']['title'])) $ogScore += 5;
        if (!empty($analysis['open_graph']['description'])) $ogScore += 5;
        if (!empty($analysis['open_graph']['image'])) $ogScore += 5;
        if (!empty($analysis['open_graph']['type'])) $ogScore += 5;
        $score += $ogScore;
        
        // Twitter Cards (10 points)
        $twitterScore = 0;
        if (!empty($analysis['twitter_cards']['card'])) $twitterScore += 5;
        if (!empty($analysis['twitter_cards']['title'])) $twitterScore += 3;
        if (!empty($analysis['twitter_cards']['description'])) $twitterScore += 2;
        $score += $twitterScore;
        
        // JSON-LD (10 points)
        if (!empty($analysis['json_ld'])) {
            $score += 10;
        }
        
        // Headings (10 points)
        if (!empty($analysis['headings'])) {
            $score += 10;
        }
        
        return min($score, 100);
    }

    protected function generateRecommendations(array $analysis): array
    {
        $recommendations = [];
        
        if (empty($analysis['title'])) {
            $recommendations[] = 'Add a page title';
        } elseif (strlen($analysis['title']) < 30) {
            $recommendations[] = 'Make your title longer (30-60 characters)';
        } elseif (strlen($analysis['title']) > 60) {
            $recommendations[] = 'Shorten your title (30-60 characters)';
        }
        
        if (empty($analysis['description'])) {
            $recommendations[] = 'Add a meta description';
        } elseif (strlen($analysis['description']) < 120) {
            $recommendations[] = 'Make your description longer (120-160 characters)';
        } elseif (strlen($analysis['description']) > 160) {
            $recommendations[] = 'Shorten your description (120-160 characters)';
        }
        
        if (empty($analysis['canonical'])) {
            $recommendations[] = 'Add a canonical URL';
        }
        
        if (empty($analysis['open_graph']['image'])) {
            $recommendations[] = 'Add an Open Graph image';
        }
        
        if (empty($analysis['json_ld'])) {
            $recommendations[] = 'Add structured data (JSON-LD)';
        }
        
        return $recommendations;
    }

    protected function analyzeHeadingStructure(string $content): array
    {
        $headings = $this->extractHeadings($content);
        $structure = [];
        
        foreach ($headings as $heading) {
            $structure[] = "H{$heading['level']}: {$heading['text']}";
        }
        
        return $structure;
    }

    protected function hasFavicon(string $content): bool
    {
        return strpos($content, 'rel="icon"') !== false || 
               strpos($content, 'rel="shortcut icon"') !== false;
    }

    protected function hasRobotsMeta(string $content): bool
    {
        return strpos($content, 'name="robots"') !== false;
    }

    protected function hasAltText(string $content): bool
    {
        preg_match_all('/<img[^>]*>/i', $content, $matches);
        
        foreach ($matches[0] as $img) {
            if (strpos($img, 'alt=') === false) {
                return false;
            }
        }
        
        return true;
    }

    protected function checkHeadingHierarchy(string $content): bool
    {
        $headings = $this->extractHeadings($content);
        $levels = array_column($headings, 'level');
        
        // Check if H1 exists
        if (!in_array(1, $levels)) {
            return false;
        }
        
        // Check if headings follow proper hierarchy
        $prevLevel = 0;
        foreach ($levels as $level) {
            if ($level > $prevLevel + 1) {
                return false;
            }
            $prevLevel = $level;
        }
        
        return true;
    }

    protected function checkFormLabels(string $content): bool
    {
        preg_match_all('/<input[^>]*>/i', $content, $matches);
        
        foreach ($matches[0] as $input) {
            if (strpos($input, 'id=') !== false && strpos($content, 'for=') === false) {
                return false;
            }
        }
        
        return true;
    }

    protected function checkColorContrast(string $content): bool
    {
        // This is a simplified check - in reality, you'd need more sophisticated analysis
        return true;
    }

    protected function createErrorResult(string $url, string $error): array
    {
        return [
            'url' => $url,
            'status' => 'error',
            'timestamp' => now(),
            'error' => $error,
        ];
    }

    protected function logMonitoringData(array $data): void
    {
        Log::info('SEO Monitoring Data', $data);
    }

    public function getMonitoringData(): array
    {
        return Cache::get('seo_monitoring_data', []);
    }

    public function clearMonitoringData(): void
    {
        Cache::forget('seo_monitoring_data');
    }
}
