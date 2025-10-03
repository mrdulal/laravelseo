<?php

namespace LaravelSeoPro\Tests\Unit;

use LaravelSeoPro\Services\SeoService;
use LaravelSeoPro\Tests\TestCase;

class SeoServiceTest extends TestCase
{

    public function test_can_set_title()
    {
        $seo = new SeoService();
        $seo->setTitle('Test Title');
        
        $this->assertEquals('Test Title', $seo->getTitle());
    }

    public function test_can_set_description()
    {
        $seo = new SeoService();
        $seo->setDescription('Test Description');
        
        $this->assertEquals('Test Description', $seo->getDescription());
    }

    public function test_can_set_keywords()
    {
        $seo = new SeoService();
        $seo->setKeywords('test, keywords, seo');
        
        $this->assertEquals('test, keywords, seo', $seo->getKeywords());
    }

    public function test_can_set_open_graph_data()
    {
        $seo = new SeoService();
        $seo->setOpenGraph('og:title', 'OG Title');
        
        $this->assertEquals('OG Title', $seo->getOpenGraphData()['og:title']);
    }

    public function test_can_set_twitter_card_data()
    {
        $seo = new SeoService();
        $seo->setTwitterCard('twitter:card', 'summary');
        
        $this->assertEquals('summary', $seo->getTwitterCardData()['twitter:card']);
    }

    public function test_can_set_json_ld()
    {
        $seo = new SeoService();
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => 'Test Article'
        ];
        $seo->setJsonLd($jsonLd);
        
        $this->assertEquals($jsonLd, $seo->getJsonLd());
    }

    public function test_can_generate_robots_txt()
    {
        $seo = new SeoService();
        $robots = $seo->generateRobots();
        
        $this->assertStringContainsString('User-agent: *', $robots);
        $this->assertStringContainsString('Disallow:', $robots);
    }

    public function test_can_generate_sitemap()
    {
        $seo = new SeoService();
        $sitemap = $seo->generateSitemap();
        
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $sitemap);
        $this->assertStringContainsString('<urlset', $sitemap);
    }
}
