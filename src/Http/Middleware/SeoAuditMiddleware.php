<?php

namespace LaravelSeoPro\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use LaravelSeoPro\Facades\Seo;

class SeoAuditMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!config('seo.audit.enabled')) {
            return $next($request);
        }

        $response = $next($request);

        // Only audit HTML responses
        if ($response->headers->get('Content-Type') && 
            str_contains($response->headers->get('Content-Type'), 'text/html')) {
            
            $auditResults = $this->performSeoAudit($response->getContent());
            
            if ($auditResults['has_issues']) {
                $this->logSeoIssues($request, $auditResults);
            }
        }

        return $response;
    }

    protected function performSeoAudit(string $content): array
    {
        $issues = [];
        $config = config('seo.audit');

        // Check title
        if ($config['check_title']) {
            $title = $this->extractMetaContent($content, 'title');
            if (empty($title)) {
                $issues[] = 'Missing page title';
            } elseif (strlen($title) < $config['min_title_length']) {
                $issues[] = "Title too short (less than {$config['min_title_length']} characters)";
            } elseif (strlen($title) > $config['max_title_length']) {
                $issues[] = "Title too long (more than {$config['max_title_length']} characters)";
            }
        }

        // Check description
        if ($config['check_description']) {
            $description = $this->extractMetaContent($content, 'description');
            if (empty($description)) {
                $issues[] = 'Missing meta description';
            } elseif (strlen($description) < $config['min_description_length']) {
                $issues[] = "Description too short (less than {$config['min_description_length']} characters)";
            } elseif (strlen($description) > $config['max_description_length']) {
                $issues[] = "Description too long (more than {$config['max_description_length']} characters)";
            }
        }

        // Check keywords
        if ($config['check_keywords']) {
            $keywords = $this->extractMetaContent($content, 'keywords');
            if (empty($keywords)) {
                $issues[] = 'Missing meta keywords';
            }
        }

        // Check Open Graph tags
        if ($config['check_og_tags']) {
            $ogTitle = $this->extractMetaProperty($content, 'og:title');
            $ogDescription = $this->extractMetaProperty($content, 'og:description');
            $ogImage = $this->extractMetaProperty($content, 'og:image');

            if (empty($ogTitle)) {
                $issues[] = 'Missing Open Graph title';
            }
            if (empty($ogDescription)) {
                $issues[] = 'Missing Open Graph description';
            }
            if (empty($ogImage)) {
                $issues[] = 'Missing Open Graph image';
            }
        }

        // Check Twitter Card tags
        if ($config['check_twitter_tags']) {
            $twitterCard = $this->extractMetaName($content, 'twitter:card');
            $twitterTitle = $this->extractMetaName($content, 'twitter:title');
            $twitterDescription = $this->extractMetaName($content, 'twitter:description');

            if (empty($twitterCard)) {
                $issues[] = 'Missing Twitter Card type';
            }
            if (empty($twitterTitle)) {
                $issues[] = 'Missing Twitter Card title';
            }
            if (empty($twitterDescription)) {
                $issues[] = 'Missing Twitter Card description';
            }
        }

        // Check canonical URL
        if ($config['check_canonical']) {
            $canonical = $this->extractCanonicalUrl($content);
            if (empty($canonical)) {
                $issues[] = 'Missing canonical URL';
            }
        }

        return [
            'has_issues' => !empty($issues),
            'issues' => $issues,
            'timestamp' => now(),
        ];
    }

    protected function extractMetaContent(string $content, string $name): ?string
    {
        if ($name === 'title') {
            preg_match('/<title[^>]*>(.*?)<\/title>/i', $content, $matches);
            return isset($matches[1]) ? trim($matches[1]) : null;
        }

        preg_match('/<meta[^>]*name=["\']' . preg_quote($name, '/') . '["\'][^>]*content=["\']([^"\']*)["\'][^>]*>/i', $content, $matches);
        return isset($matches[1]) ? trim($matches[1]) : null;
    }

    protected function extractMetaProperty(string $content, string $property): ?string
    {
        preg_match('/<meta[^>]*property=["\']' . preg_quote($property, '/') . '["\'][^>]*content=["\']([^"\']*)["\'][^>]*>/i', $content, $matches);
        return isset($matches[1]) ? trim($matches[1]) : null;
    }

    protected function extractMetaName(string $content, string $name): ?string
    {
        preg_match('/<meta[^>]*name=["\']' . preg_quote($name, '/') . '["\'][^>]*content=["\']([^"\']*)["\'][^>]*>/i', $content, $matches);
        return isset($matches[1]) ? trim($matches[1]) : null;
    }

    protected function extractCanonicalUrl(string $content): ?string
    {
        preg_match('/<link[^>]*rel=["\']canonical["\'][^>]*href=["\']([^"\']*)["\'][^>]*>/i', $content, $matches);
        return isset($matches[1]) ? trim($matches[1]) : null;
    }

    protected function logSeoIssues(Request $request, array $auditResults): void
    {
        $logData = [
            'url' => $request->url(),
            'method' => $request->method(),
            'issues' => $auditResults['issues'],
            'timestamp' => $auditResults['timestamp'],
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
        ];

        \Log::warning('SEO Audit Issues Detected', $logData);
    }
}
