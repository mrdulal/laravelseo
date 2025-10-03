<?php

namespace LaravelSeoPro\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class SeoAuditCommand extends Command
{
    protected $signature = 'seo:audit {url? : URL to audit (defaults to app URL)}';
    protected $description = 'Perform SEO audit on a URL';

    public function handle()
    {
        $url = $this->argument('url') ?: URL::to('/');
        
        $this->info("Auditing SEO for: {$url}");
        
        try {
            $response = Http::get($url);
            $content = $response->body();
            
            $auditResults = $this->performSeoAudit($content);
            
            $this->displayAuditResults($auditResults);
            
        } catch (\Exception $e) {
            $this->error("Failed to audit URL: {$e->getMessage()}");
            return 1;
        }
        
        return 0;
    }

    protected function performSeoAudit(string $content): array
    {
        $issues = [];
        $warnings = [];
        $suggestions = [];
        $config = config('seo.audit');

        // Check title
        $title = $this->extractMetaContent($content, 'title');
        if (empty($title)) {
            $issues[] = 'Missing page title';
        } elseif (strlen($title) < $config['min_title_length']) {
            $warnings[] = "Title too short ({strlen($title)} characters, recommended: {$config['min_title_length']}-{$config['max_title_length']})";
        } elseif (strlen($title) > $config['max_title_length']) {
            $warnings[] = "Title too long ({strlen($title)} characters, recommended: {$config['min_title_length']}-{$config['max_title_length']})";
        } else {
            $suggestions[] = "✓ Title length is optimal ({strlen($title)} characters)";
        }

        // Check description
        $description = $this->extractMetaContent($content, 'description');
        if (empty($description)) {
            $issues[] = 'Missing meta description';
        } elseif (strlen($description) < $config['min_description_length']) {
            $warnings[] = "Description too short ({strlen($description)} characters, recommended: {$config['min_description_length']}-{$config['max_description_length']})";
        } elseif (strlen($description) > $config['max_description_length']) {
            $warnings[] = "Description too long ({strlen($description)} characters, recommended: {$config['min_description_length']}-{$config['max_description_length']})";
        } else {
            $suggestions[] = "✓ Description length is optimal ({strlen($description)} characters)";
        }

        // Check keywords
        $keywords = $this->extractMetaContent($content, 'keywords');
        if (empty($keywords)) {
            $warnings[] = 'Missing meta keywords (optional but recommended)';
        } else {
            $suggestions[] = "✓ Meta keywords found";
        }

        // Check Open Graph tags
        $ogTitle = $this->extractMetaProperty($content, 'og:title');
        $ogDescription = $this->extractMetaProperty($content, 'og:description');
        $ogImage = $this->extractMetaProperty($content, 'og:image');
        $ogType = $this->extractMetaProperty($content, 'og:type');

        if (empty($ogTitle)) {
            $warnings[] = 'Missing Open Graph title';
        } else {
            $suggestions[] = "✓ Open Graph title found";
        }

        if (empty($ogDescription)) {
            $warnings[] = 'Missing Open Graph description';
        } else {
            $suggestions[] = "✓ Open Graph description found";
        }

        if (empty($ogImage)) {
            $warnings[] = 'Missing Open Graph image';
        } else {
            $suggestions[] = "✓ Open Graph image found";
        }

        if (empty($ogType)) {
            $warnings[] = 'Missing Open Graph type';
        } else {
            $suggestions[] = "✓ Open Graph type found";
        }

        // Check Twitter Card tags
        $twitterCard = $this->extractMetaName($content, 'twitter:card');
        $twitterTitle = $this->extractMetaName($content, 'twitter:title');
        $twitterDescription = $this->extractMetaName($content, 'twitter:description');

        if (empty($twitterCard)) {
            $warnings[] = 'Missing Twitter Card type';
        } else {
            $suggestions[] = "✓ Twitter Card type found";
        }

        if (empty($twitterTitle)) {
            $warnings[] = 'Missing Twitter Card title';
        } else {
            $suggestions[] = "✓ Twitter Card title found";
        }

        if (empty($twitterDescription)) {
            $warnings[] = 'Missing Twitter Card description';
        } else {
            $suggestions[] = "✓ Twitter Card description found";
        }

        // Check canonical URL
        $canonical = $this->extractCanonicalUrl($content);
        if (empty($canonical)) {
            $warnings[] = 'Missing canonical URL';
        } else {
            $suggestions[] = "✓ Canonical URL found";
        }

        // Check for h1 tags
        preg_match_all('/<h1[^>]*>(.*?)<\/h1>/i', $content, $h1Matches);
        if (empty($h1Matches[1])) {
            $warnings[] = 'Missing H1 tag';
        } else {
            $suggestions[] = "✓ H1 tag found";
        }

        // Check for images with alt text
        preg_match_all('/<img[^>]*>/i', $content, $imgMatches);
        $imagesWithoutAlt = 0;
        foreach ($imgMatches[0] as $img) {
            if (!preg_match('/alt=["\'][^"\']*["\']/', $img)) {
                $imagesWithoutAlt++;
            }
        }
        
        if ($imagesWithoutAlt > 0) {
            $warnings[] = "{$imagesWithoutAlt} image(s) missing alt text";
        } else {
            $suggestions[] = "✓ All images have alt text";
        }

        return [
            'issues' => $issues,
            'warnings' => $warnings,
            'suggestions' => $suggestions,
            'title' => $title,
            'description' => $description,
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

    protected function displayAuditResults(array $results): void
    {
        $this->newLine();
        
        if (!empty($results['title'])) {
            $this->info("Title: {$results['title']}");
        }
        
        if (!empty($results['description'])) {
            $this->info("Description: {$results['description']}");
        }
        
        $this->newLine();
        
        if (!empty($results['issues'])) {
            $this->error('❌ Critical Issues:');
            foreach ($results['issues'] as $issue) {
                $this->line("  • {$issue}");
            }
            $this->newLine();
        }
        
        if (!empty($results['warnings'])) {
            $this->warn('⚠️  Warnings:');
            foreach ($results['warnings'] as $warning) {
                $this->line("  • {$warning}");
            }
            $this->newLine();
        }
        
        if (!empty($results['suggestions'])) {
            $this->info('✅ Good Practices:');
            foreach ($results['suggestions'] as $suggestion) {
                $this->line("  • {$suggestion}");
            }
            $this->newLine();
        }
        
        $totalIssues = count($results['issues']) + count($results['warnings']);
        
        if ($totalIssues === 0) {
            $this->info('🎉 Excellent! No SEO issues found.');
        } else {
            $this->warn("Found {$totalIssues} SEO issue(s) to address.");
        }
    }
}
